
$(document).on('click', '#btn-edituserinfo', function(event){ 
    $.ajax({
        url: '/views/missingdata.hbs',
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