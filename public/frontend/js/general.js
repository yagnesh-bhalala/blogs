$(document).ready(function() {
    $('#loginSubmitButton').on('click', function() {        
        //$("#advertiser_login").valid();        
    });
    $("#advertiser_login_____").validate({
        errorClass: 'error text-left',
        errorElement: 'p',
        rules:{
            emailOrPhone: {
                required: true,                
            },
            password: {
                required: true,
            },
        },
        messages:{
            emailOrPhone:{
                required: "Please enter email or phone.",                
            },
            password:{
                required: "Please enter password."
            },
        },
    });
});
