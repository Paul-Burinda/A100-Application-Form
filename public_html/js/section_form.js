'use strict';



$(document).ready(function() {
    var submitData = {};

    //$('#submit_insert_data').hide();
    // Real-time Validation
    // Name can't be blank

    // Menu Toggle Script
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    var loadurl = '/resources/new_applicant.php?section=1';
    $('#userContent').load(loadurl);

    $('.formSwapper').click(function() {
        $('.applicant-data').each(function (){
            var $control = $(this),
            name = $control.attr('name'),
            value = $control.val();
            submitData[name] = value;

        });

        var sectionId= $(this).attr('section-id'),
        url = '/resources/new_applicant.php?section=' + sectionId;
        $('#userContent').load(url);
    });

    $('#save_insert_data').click(function () {
      $('.applicant-data').each(function (){
         var $control = $(this),
         name = $control.attr('name'),
         value = $control.val();
         submitData[name] = value;

     });
  });

    // $('#check_insert_data').click(function () {
    //   alert(JSON.stringify(submitData));
    //   $("#submit_insert_data").show();
  // });

    // After Form Submitted Validation
    $("#submit_insert_data").click(function(event) {
        var dataStr = '';
        Object.keys(submitData).forEach(function (key, idx) {
            if (idx > 0) {
                dataStr += '&';
            }
            dataStr += key + ':';
            dataStr += submitData[key];
        });
        //alert(JSON.stringify(submitData));
        var jstring = JSON.stringify(submitData);
        $('#hiddensend').val(jstring);
        $('#sendform').submit();
        alert("Successfully Uploaded");
        window.location.href = 'http://www.indie-soft.com/a100';
        //$('#sendform').serialize();
        // $.ajax({
        //  type: 'post',
        //  url: '/resources/insert.php',
        //  data: dataStr,
        //  contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        //  success: function(data) {
        //      $('#userContent').html(data);
        //  }
        // });
    });

    // $("#submit_insert_data").click(function(e) {
    //     e.preventDefault();
    //     var first_name = $("#first_name").val();
    //     var last_name = $("#last_name").val();
    //     var dataString = 'first_name='+first_name+'&last_name='+last_name;
    //     $.ajax({
    //         type:'POST',
    //         data:dataString,
    //         url:'/resources/insert.php',
    //         success:function(data) {
    //           alert(data);
    //       }
    //   });
    // });

    //Validate email
    $('#email').on('input', function() {
        var input=$(this);
        var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        var is_email=re.test(input.val());
        if(is_email){input.removeClass("invalid").addClass("valid");}
        else{input.removeClass("valid").addClass("invalid");}
    });
});

