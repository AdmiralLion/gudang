$(document).ready(function() {
    
    $('#login').on('click', function() {
        var username = $('#username').val();
        var password = $('#password').val();
        $(this).addClass('btn-progress');


        $.ajax({
            type: 'POST',
            url: "Login/login_act",//dilanjut besok
            data: {
                username:username,
                password:password,
            }
        }).done(function(response) {
            var pesan = response.message;
            console.log(response);
            console.log(pesan);
            if (response.status === '200') {
                alert(response.message);
                $('#login').removeClass('btn-progress');
                window.location.href = 'Home';
            } else {
                alert(response.message);
                $('#login').removeClass('btn-progress');
                return false;
            }
            throttled = false;
        });
    })

})
