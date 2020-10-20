

$(document).on('click', '#btn-delappointment', function(event){ 
    event.preventDefault();
    postData('/api/api.php?url=/api/deleteappointment', {}).then(data => {
        if(data.code==0)
        {
            alert("Ihr Termin wurde erfolgreich gelöscht");
            checkTimeslots();
        }
        else
        {
            alert("Fehler: "+data.reason)
        }
    });
});

$(document).on('click', '.time', function(event){ 
    event.preventDefault();
    var day = $(this).attr('day');
    var timeslot = $(this).attr('timeslot');

    //$(this).addClass("timeslottaken");
    
    postData('/api/api.php?url=/api/choosetimeslot/'+day+"/"+timeslot, {}).then(data => {
        if(data.code==0)
        {
            checkTimeslots();
            goToByScroll("#userappointmentwrapper");
            const element = document.querySelector('#userappointmentwrapper');
            element.classList.add('animate__animated', 'animate__flash');
            element.addEventListener('animationend', () => {
                
            });
        }
        else
        {
            alert("Fehler: "+data.reason)
        }
    });
    
});


$(document).on('click', '#btn-edituserinfo', function(event){ 
    event.preventDefault();
    $.ajax({
        url: '/views/userinfo.hbs',
        cache: false,
        success: function (data) {
            template = Handlebars.compile(data);

            for(key in pageinfo.USER_FIELDS)
            {
                if(userinfo[key])
                    pageinfo.USER_FIELDS[key]['value']=userinfo[key]
            }

            $("main").html(template(pageinfo.USER_FIELDS));
        }
    });
});

$(document).on('click', '#saveuserdata', function(event){ 
    event.preventDefault();
    var fields = {}
    var errors = false;
    for(key in pageinfo.USER_FIELDS)
    {
        var val = $("#input-"+key).val().trim()
        if(!val && pageinfo.USER_FIELDS[key]['mandatory']===true)
        {
            alert("Bitte füllen Sie das Pflichteld '"+pageinfo.USER_FIELDS[key]['text']+"' aus!")
            errors= true;
        }
        else{
            fields[key] = val
        }
    }

    if(errors===false)
    {
        postData('/api/api.php?url=/api/saveuserinfo', {fields:fields}).then(data => {
            if(data.code==0)
                loadUI(data.fields);
        });
    }
});