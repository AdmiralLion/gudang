$(document).ready(function() {
    
    $('#login').on('click', function() {
        var username = $('#username').val();
        var password = $('#password').val();
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
                window.location.href = 'Home';
            } else {
                alert(response.message);
                return false;
            }
            throttled = false;
        });
    })

})
