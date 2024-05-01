  $(document).ready(function () {
    data_masterrekanan();
    reset_masterrekanan();

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

    function reset_masterrekanan()
    {
      $('#id_rekanan').val('');
      $('#nama_rekanan').val('');
      $('#alamat_rekanan').val('');
      $('#notelp_rekanan').val('');
      $('#email_rekanan').val('');

    }

    $('.table-1').DataTable();

  
    $('#tambah_rekanan').on('click', function() {
      $('#modal_tambahrekanan').modal('show');
    })

    function data_masterrekanan() {
      $.ajax({
        type: "POST",
        url: "../Master/getdatamasterrekanan",
        cache: false,
        success: function (data) {
          console.log(data);
          var html;
          var i;
          var n = 0;
          var data = $.parseJSON(data);
    
          // Clear existing DataTables content
          $('.table-1').DataTable().clear();
    
          $.each(data, function (i) {
            var btn_masterrkn =
              '<td style="text-align:center;">' +
              '<button  type="button" class="btn btn-primary btn-icon  rekanan_edit" data="' +
              data[i].id +
              '"><i class="fa fa-pen"></i></button >' +
              '  ' +
              '<button type="button" class="btn btn-danger btn-icon  rekanan_hapus"  data="' +
              data[i].id +
              '"><i class="fa fa-trash"></i></button> </br>' +
              '</td>';
    
            n++;
            html = [
              n,
              btn_masterrkn,
              data[i].nama_rekanan,
              data[i].alamat_rekanan,
              data[i].notelp_rekanan
            ];
    
            // Add the row to DataTables
            $('.table-1').DataTable().row.add(html);
          });
    
          // Draw the updated DataTables
          $('.table-1').DataTable().draw();
        },
      });
    }
    

    $('#data_master_rekanan').on('click','.rekanan_edit', function () {
      var id = $(this).attr('data');
      $.ajax({
          type: 'POST',
          url: "../Master/get_dataeditmasterrekanan",//dilanjut besok
          data: {
            id:id
          }
        }).done(function(data) {
          var data3 = $.parseJSON(data);
          $.each(data3, function (i) {
            $('#id_rekanan').val(data3[i].id);
            $('#nama_rekanan').val(data3[i].nama_rekanan);
            $('#alamat_rekanan').val(data3[i].alamat_rekanan);
            $('#notelp_rekanan').val(data3[i].notelp_rekanan);
            $('#email_rekanan').val(data3[i].email_rekanan);
          });
        });
        $('#modal_tambahrekanan').modal('show');
  });

  $('#data_master_rekanan').on('click','.rekanan_hapus', function () {
    var id = $(this).attr('data');
    var table = 'm_rekanan';
    let text = "Anda yakin untuk menghapus master rekanan tersebut ?";
    if (confirm(text) == true) {
      $.ajax({
        type: 'POST',
        url: "../Master/hapus_master",//dilanjut besok
        data: {
          id:id,
          table:table
        }
      }).done(function(response) {
        console.log(response);
        var pesan = response.message;
        console.log(pesan);
        if (response.status === '200') {
          alert(response.message);
          data_masterrekanan();
      } else {
          alert(response.message);
          data_masterrekanan();
        }
      });
        }
});

    $('#save_masterrekanan').on('click', function() {
      var id_rekanan = $('#id_rekanan').val();
      var nama_rekanan = $('#nama_rekanan').val();
      var alamat_rekanan = $('#alamat_rekanan').val();
      var notelp_rekanan = $('#notelp_rekanan').val();
      var email_rekanan = $('#email_rekanan').val();

      $.ajax({
        type: 'POST',
        url: "../Master/master_rekanan_act",//dilanjut besok
        data: {
            id_rekanan:id_rekanan,
            nama_rekanan:nama_rekanan,
            alamat_rekanan:alamat_rekanan,
            notelp_rekanan:notelp_rekanan,
            email_rekanan:email_rekanan,
        }
        }).done(function(response) {
          
            var pesan = response.message;
            console.log(response);
            console.log(pesan);
            if (response.status === '200') {
                alert(response.message);
                data_masterrekanan();
            } else {
                alert(response.message);
                data_masterrekanan();
                return false;
            }
            throttled = false;
        });
    })



});