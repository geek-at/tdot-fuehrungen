<?php
session_start();

// basic path definitions
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('DOMAIN', $_SERVER['HTTP_HOST']);

//load composer stuff
require ROOT . '/api/lib/vendor/autoload.php';
require ROOT . '/api/lib/functions.php';
if (!file_exists(ROOT . '/inc/configs/' . DOMAIN . '.config.inc.php'))
    die(json_encode(array('code' => -1, 'reason' => 'Invalid URL', 'dom' => DOMAIN)));
require_once(ROOT . '/api/../inc/configs/' . DOMAIN . '.config.inc.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if($_GET['dl']=='true')
{
    //prepare general data
    $redis = connectRedis();
    $usertimes = array();
    $users = $redis->keys(REDIS_PRESTRING . ':users:*');
    foreach ($users as $u) {
        $a = explode(':', $u);
        $user = $a[3];
        $field = $a[4];

        if ($field == 'appointment') {
            $appointment = explode(';', $redis->get($u));
            $usertimes[$appointment[0]][$appointment[1]][] = $user;
        }
    }

    $fields = getFields();
    $everyheader = ['Uhrzeit'];
    foreach ($fields as $fieldname => $fd)
        $everyheader[]= $fieldname;

    //prepare xls
    $spreadsheet = new Spreadsheet();
    //worksheets
    $dd = getDayData();
    $i = 0;
    // each worksheet has this
    foreach ($dd as $day => $ddd) {
        $wsheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $ddd['tag']);
        $spreadsheet->addSheet($wsheet,  $i++);

        //add nice header to sheet
        $headerstyle = ['font' => ['bold' => true,'size' => 25]];
        $fat = ['font' => ['bold' => true]];
        $wsheet->setCellValue('A1',$ddd['tag']);
        $wsheet->getStyle('A1')->applyFromArray($headerstyle);
        $wsheet->getStyle('2:2')->applyFromArray($fat);

        //header einrichten
        $alc = 1; 
        foreach($everyheader as $header)
            $wsheet->setCellValue(chr(64+$alc++).'2', ucfirst($header)); //2 because line 1 is date

        $alc = 3; //1=day,2=headers
        foreach ($ddd['timeslots'] as $time) {
            $wsheet->setCellValue('A'.($alc), $time);
            $users = $usertimes[$day][$time];
            if ($users) {
                foreach ($users as $u) {
                    $alc++;
                    foreach ($fields as $fieldname => $fd) {
                        $index = array_search($fieldname,$everyheader);
                        $value = $redis->get(REDIS_PRESTRING.":users:$u:$fieldname");
                        if($value)
                            $wsheet->setCellValue(chr(65+$index).$alc,(is_numeric($value)?"'".$value:$value));
                    }
                }
            }

            $alc++;
        }

        foreach (range('B', $wsheet->getHighestColumn()) as $col) {
            $wsheet->getColumnDimension($col)->setAutoSize(true);
         }
    }

    //cleanup
    $spreadsheet->setActiveSheetIndex(0);
    $sheetIndex = $spreadsheet->getIndex(
        $spreadsheet->getSheetByName('Worksheet')
    );
    $spreadsheet->removeSheetByIndex($sheetIndex);

    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Fuehrungen-stand-'.date("d.m.y H:i").'.xlsx"');
    $writer->save('php://output');
    exit();
}

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title>Schulfuehrungen Administration</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="css/font-awesome.min.css">

</head>

<body>
    <div class="jumbotron" id="jumbo">
        <div class="container">
            <h1 class="text-center"><i class="fa fa-graduation-cap" aria-hidden="true"></i> </h1>
        </div>
    </div>
    <div class="container">

        <h1><?php echo SCHOOLNAME; ?> </h1>

        <a class="btn btn-primary" href="?dl=true"><i class="fa fa-download" aria-hidden="true"></i> Export zu Excel</a>

        <hr />

        <?php

        if (!$_SESSION['login'] == true) {
            if ($_REQUEST['password']) {
                if ($_REQUEST['password'] == ADMIN_PW) {
                    $_SESSION['login'] = true;
                    echo '<script>window.location.href="?"</script>';
                } else
                    echo '<div class="alert alert-danger" role="alert">Falsches Passwort!</div>';
            }
            echo "<h3>Geben Sie bitte das Passwort ein</h3>";
            echo '<form method="POST" class="form-inline">
                                <div class="form-group">
                                        <label class="sr-only" for="password">Password</label>
                                        <input type="password" name="password" class="form-control" id="password" placeholder="Passwort">
                                </div>
                                <button type="submit" name="submit" class="btn btn-default">Login</button>
                        </form>';
        } else {
            $redis = connectRedis();

            $usertimes = array();
            $users = $redis->keys(REDIS_PRESTRING . ':users:*');
            foreach ($users as $u) {
                $a = explode(':', $u);
                $user = $a[3];
                $field = $a[4];

                if ($field == 'appointment') {
                    $appointment = explode(';', $redis->get($u));
                    $usertimes[$appointment[0]][$appointment[1]][] = $user;
                }
            }

            $fields = getFields();

            $everyheader = '';
            foreach ($fields as $fieldname => $fd) {
                $everyheader .= '<th>' . $fieldname . '</th>';
            }
            $everyheader .= '<th>Löschen</th>';


            $dd = getDayData();

            foreach ($dd as $day => $ddd) {

                $table = '<table class="table-striped table-bordered" style="width:100%">';
                $table .= '<tr>
                        <th scope="col">Uhrzeit</th>
                        ' . $everyheader . '
                    </tr>';


                foreach ($ddd['timeslots'] as $time) {
                    $table .= '<tr>
                            <td style="width:auto;text-align:center;white-space: nowrap;">' . $time . '</td>';

                    $users = $usertimes[$day][$time];
                    if ($users) {
                        foreach ($users as $u) {
                            if(EVENT_MAXRES_PER_TIMESLOT > 1)
                            $table .= '</tr><tr><td></td>';
                            foreach ($fields as $fieldname => $fd) {
                                
                                $table .= '<td>'.$redis->get(REDIS_PRESTRING.":users:$u:$fieldname").'</td>';
                            }
                            $table .= '<td><button user="'.$u.'" day="'.$day.'" time="'.$time.'" class="btn btn-danger userdelbutton">Löschen</button></td>';
                        }
                    }

                    //<td style="width: 100%;padding-left:20px;"></td>
                    $table .= '</tr>';
                }

                $table .= '</table>

                ';

                echo '<h1>' . $ddd['tag'] . '</h1>' . ($ddd['info'] ? '<h4>' . $ddd['info'] . '</h4>' : '') . $table
                    . '<div style="page-break-after:always;"></div>';
            }
        }
        ?>

        </script>

    </div> <!-- /container -->

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

    <script>
        $(document).on("click",".userdelbutton",function(e) {
            var user=$(this).attr("user");
            var day=$(this).attr("day");
            var time=$(this).attr("time");

            if(confirm('Soll dieser Termin wirklich gelöscht werden? Der Benutzer wird NICHT automatisch benachrichtigt!'))
            {
                postData('/api/api.php?url=/api/deleteappointment/admin', {},user).then(data => {
                    if(data.code==0)
                    {
                        $(this).parent().parent().fadeOut();
                    }
                    else
                    {
                        alert("Fehler: "+data.reason)
                    }
                });
            }

            e.preventDefault();
        });

        async function postData(url = '', data = {},token) {
            // Default options are marked with *
            const response = await fetch(url, {
                method: 'POST', // *GET, POST, PUT, DELETE, etc.
                cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                headers: {
                    'Content-Type': 'application/json',
                    'Firebase-Token': token,
                },
                body: JSON.stringify(data) // body data type must match "Content-Type" header
            });
            return response.json(); // parses JSON response into native JavaScript objects
        }
    </script>
</body>

</html>