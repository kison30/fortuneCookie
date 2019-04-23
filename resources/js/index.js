function getResponsiveBreakpoint() {
    var envs = ["sm", "md", "lg", "xl"];
    var env = "";

    var $el = $("<div>");
    $el.appendTo($("body"));
    $el.addClass("d-block");
    for (var i = envs.length - 1; i >= 0; i--) {
        env = envs[i];
        $el.addClass("d-" + env + "-none");
        if ($el.is(":hidden")) {
            $el.remove();
            return env;
        }
    }
    $el.remove();
    return "xs";    //extra small
}

function detectMode() {
    var themode = getResponsiveBreakpoint();

    if(themode == 'xs' || themode == 'sm'){
        $('.collapse').collapse('hide');
        console.log('smsmsm');
        $('.leftnavpin').hide();
        $( '.rightcartpin' ).removeClass( "Zebra_Pin" );



    }else{
        $('.collapse').collapse('show');
        console.log('mdmdmd');

        $('.leftnavpin').show();

        new $.Zebra_Pin($('.leftnavpin'), {
            top_spacing: 10
        });
        new $.Zebra_Pin($('.rightcartpin'), {
            top_spacing: 10
        });
    }
}

detectMode();

$(document).ready(function() {

    /*
    $( window ).resize(function() {

        detectMode();
    });
*/


    $(".leftnav").click(function (){

        $(".leftnav").css('background-color', '#ffffff');
        $(".leftnav").css('color', '#495057');

        $(this).css('background-color', '#28a745');
        $(this).css('color', '#ffffff');


        var theId = $( this ).attr( "id" );
        var theTo = '#menu'+theId;


        $('html, body').animate({
            scrollTop: $(theTo).offset().top
        }, 500);

    });


});

