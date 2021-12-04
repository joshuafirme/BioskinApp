function doLogin(email, password, btn) {
    btn.html('<i class="fas fa-spinner fa-pulse"></i>');
    $.ajax({
        url: '/login-ajax',
        type: 'POST',
        data: {
            email    : email,
            password : password
        },
        success:async function(data){
            btn.html('Login');
            let html = '' ;
            if ( email != "" && password != "" ){
                if (data.message == 'unauthorized') {
                    html += '<small class="text-danger">Invalid username or password.</small>';
                }
                else if (data.message == 'authorized') {
                    window.location.reload();
                }
            }
            else {
                html += '<small class="text-danger">Please input your credential.</small>';
            }

            
            $('#login-validation').html(html);
        
        }
    });
}

$(document).on('click', '#btn-login', function(){
    let email = $('[name="email"]').val();
    let password = $('[name="password"]').val();
    let btn = $(this);
    doLogin(email, password, btn);
});