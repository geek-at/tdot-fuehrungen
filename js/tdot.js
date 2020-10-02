var token = false;
var pageinfo = false;
var userinfo = false;
var timer;

$(document).ready(function () {
    loadPageInfo();
});

function loadPageInfo() {
    postData('/api/api.php?url=/api/getpageinfo', {  })
        .then(result => {
            console.log(result);
            if(result.code===0)
            {
                pageinfo = result.data;
                $("#jumbo").css('background-image', 'url(' + pageinfo.PAGE_HEADER_IMG + ')');

                if(pageinfo.PLATFORM_ONLINE_NOW)
                {
                    login_firebase(result.data.firebaseconfig);
                    loadHBS('/views/jumbo.hbs',$("premain"),result.data)
                }
                else if(pageinfo.PLATFORM_OPENS_IN>0)
                    renderCountdown((pageinfo.PLATFORM_OPENS_IN * 1000));
                else
                    $("main").html("<h2 class='text-center'>Die Plattform ist geschlossen</h2>")
                
            }
        });
}

function loadHBS(url,rendertoelement,viewdata)
{
    $.ajax({
        url: url,
        cache: false,
        success: function (data) {
            template = Handlebars.compile(data);
            $(rendertoelement).html(template(viewdata));
        }
    });
}

function loadUI(o)
{
    clearInterval(timer);
    userinfo = o
    if(o.email && o.phone && o.person1)
    {
        timer = setInterval(function () {
            checkTimeslots();
        }, 10000);

        $.ajax({
            url: '/views/timeselection.hbs',
            cache: false,
            success: function (data) {
                template = Handlebars.compile(data);
                $("main").html(template(pageinfo));
            }
        });
    }
    else
    {
        $.ajax({
            url: '/views/userinfo.hbs',
            cache: false,
            success: function (data) {
                template = Handlebars.compile(data);

                for(key in pageinfo.USER_FIELDS)
                {
                    if(o[key])
                        pageinfo.USER_FIELDS[key]['value']=o[key]
                }

                $("main").html(template(pageinfo.USER_FIELDS));
            }
        });
    }
}

function checkTimeslots()
{
    postData('/api/api.php?url=/api/gettimeslotdata', {})
    .then(result => {
        if(result.code==0)
        {
            //user appointment rendering
            if(result.data.userappointment)
            {
                var parts = result.data.userappointment.split(";");
                var app_day = pageinfo.TIMESLOTS[parts[0]].tag;
                var app_time = parts[1];
                $("#userappointment").html(app_day+" um "+app_time);
                $("#printbutton").removeClass("d-none");
                $("#btn-delappointment").removeClass("d-none");
            }
            else
            {
                $("#userappointment").html("Noch kein Termin gebucht");
                $("#printbutton").addClass("d-none");
                $("#btn-delappointment").addClass("d-none");
            }
            

            //timeslot rendering
            for(day in result.data.timeslotdata)
            {
                var days = result.data.timeslotdata[day];
                for(ttime in days)
                {
                    //how many slots are taken
                    var value = (days[ttime]?days[ttime]:0)
                    $(document.getElementById("time-"+day+"-"+ttime)).removeClass('timeslotfree');
                    $(document.getElementById("time-"+day+"-"+ttime)).removeClass('timeslottaken');

                    if(value < pageinfo.EVENT_MAXRES_PER_TIMESLOT)
                        $(document.getElementById("time-"+day+"-"+ttime)).addClass('timeslotfree');
                    else
                        $(document.getElementById("time-"+day+"-"+ttime)).addClass('timeslottaken');

                    //set text how many are slots are free
                    $(document.getElementById("time-"+day+"-"+ttime+"-free")).text(value+" / "+pageinfo.EVENT_MAXRES_PER_TIMESLOT);
                }
            }
        }
        else
        {

        }
    });
}

function login_firebase(firebaseConfig) {
    firebase.initializeApp(firebaseConfig);
    firebase.auth().onAuthStateChanged(function (user) {
        if (user) {
            firebase.auth().currentUser.getIdToken(true).then(function (idToken) {
                token = idToken

                postData('/api/api.php?url=/api/getuserinfo', {})
                    .then(data => {
                        $("#logoutcontainer").removeClass("d-none");
                        console.log("userdata",data);
                        loadUI(data.data.fields);
                        token = data.data.id
                    });

            }).catch(function (error) {
                console.log("error", error);
            });
        } else {

            var ui = new firebaseui.auth.AuthUI(firebase.auth());
            var uiConfig = {
                callbacks: {
                    signInSuccessWithAuthResult: function (authResult, redirectUrl) {
                        return true;
                    },
                    uiShown: function () {
                        //document.getElementById('loader').style.display = 'none';
                    }
                },
                // Will use popup for IDP Providers sign-in flow instead of the default, redirect.
                signInFlow: 'popup',
                signInSuccessUrl: '/',
                signInOptions: [
                    firebase.auth.EmailAuthProvider.PROVIDER_ID,
                    {
                        provider: firebase.auth.PhoneAuthProvider.PROVIDER_ID,
                        defaultCountry: 'AT'
                    }

                ]
            };

            $.ajax({
                url: '/views/login.hbs',
                cache: false,
                success: function (data) {
                    template = Handlebars.compile(data);
                    $("main").html(template());
                    ui.start('#firebaseui-auth-container', uiConfig);
                }
            });

            
        }
    });
}

Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {

    switch (operator) {
        case '==':
            return (v1 == v2) ? options.fn(this) : options.inverse(this);
        case '===':
            return (v1 === v2) ? options.fn(this) : options.inverse(this);
        case '!=':
            return (v1 != v2) ? options.fn(this) : options.inverse(this);
        case '!==':
            return (v1 !== v2) ? options.fn(this) : options.inverse(this);
        case '<':
            return (v1 < v2) ? options.fn(this) : options.inverse(this);
        case '<=':
            return (v1 <= v2) ? options.fn(this) : options.inverse(this);
        case '>':
            return (v1 > v2) ? options.fn(this) : options.inverse(this);
        case '>=':
            return (v1 >= v2) ? options.fn(this) : options.inverse(this);
        case '&&':
            return (v1 && v2) ? options.fn(this) : options.inverse(this);
        case '||':
            return (v1 || v2) ? options.fn(this) : options.inverse(this);
        default:
            return options.inverse(this);
    }
});

async function postData(url = '', data = {}) {
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

function renderCountdown(timeRemaining) {
    if (timeRemaining <= 0) location.reload();
    $("main").html("<h2>Plattform öffnet <span id='countdown'></span> ("+pageinfo.PLATFORM_ONLINE_FROM_STRING+")</h2>")
    var endTime = new Date(new Date().getTime() + timeRemaining);
    moment.locale('de');
    $("#countdown").text(moment().add(timeRemaining / 1000, 'seconds').fromNow())

    setInterval(function () {
        var countdown = (endTime.getTime() - new Date().getTime()) / 1000;
        if (countdown <= 0) location.reload();
        $("#countdown").text(moment().add(countdown, 'seconds').fromNow())
    }, 1000);

}

function logout()
{
    firebase.auth().signOut().then(function() {
        location.reload();
      }).catch(function(error) {
        alert("Logout failed")
        console.log(error);
      });
}