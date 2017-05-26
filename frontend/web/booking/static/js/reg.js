$( document ).ready(function() {
    $('.DateOfIssue, .ExpirationDate, .Birth_Date').datetimepicker({
        timepicker: false,
        format: "d.m.Y"
    });

    $('#usercode').inputmask({
        mask: 'wwww-wwww-wwww-wwww'
    });

    $("#usercode").keyup(function(event) {

        if(event.keyCode==13) {
            $("#search16sim").click();
        }

    });

    setDocType('');
});


    function regUser(){
        var curURL = window.location.pathname;
        var userCode = $("#usercode").val();
        window.location.href = curURL + '?u=' + userCode;
    }


    function docFields(docFields){
        //console.log(docFields);

        var docType = $("#doctype option:selected").text();
        var fields = docFields[docType];

        setFields(fields);
    }

    function setFields(fields){
    //console.log(fields);
    $("#docFields").html('');
        for (var name in fields){
            $("#docFields").append('<div class="col-lg-6 col-md-6 col-sm-12">' +
                '<div class="form-group">' +
                '<label for="input-' + fields[name] + '" class="col-sm-4 control-label">' + fields[name] + '</label>' +
                '<div class="col-sm-8">' +
                '<input id="input-' + fields[name] + '"type="text" class="form-control" name="' + name + '" placeholder="' + fields[name] + '">' +
                '</div>' +
                '</div>' +
                '</div>');
            //console.log(name + " = " + fields[name]);
        }
    }

    function setDocType(name){
        if (name == ''){
            var name = $('div.tab-pane.fade.active.in').attr('doctype');
        }else{
            console.log(name);
        }
        $("#myTabDrop1").html(name + '<span class="caret"></span>');
    }