(function($){
    $(document).ready(function() 
    {
    jQuery.jGrowl("Registered Successefully. <br>Check your email for password.", {
                             position: 'top-right',
                             theme: 'jGrowlTheme',
                             life: '8000',
                             animateOpen: {opacity: 'show'},
                             animateClose: {opacity: 'hide'},
                             corners: '0'
                         });
    });
}(jQuery));