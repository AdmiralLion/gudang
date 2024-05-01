$('#btnlogout').click(function() {
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url("Login/logout"); ?>',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Logout berhasil, lakukan redirect atau tindakan lainnya
                alert('Berhasil Logout');
                window.location.replace('<?php echo base_url("login"); ?>');
            } else {
                // Handle jika logout gagal
                alert('Logout gagal. Silakan coba lagi.');
            }
        },
        error: function(xhr, status, error) {
            // Handle jika terjadi error saat request
            console.error(xhr.responseText);
        }
    });
});