  $(document).ready(function () {
    data_mastermerk();
    reset_mastermerk();

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

    function reset_mastermerk()
    {
      $('#id_merk').val('');
      $('#nama_merk').val('');

    }

    $('.table-1').DataTable();

  
    $('#tambah_merk').on('click', function() {
      $('#modal_tambahmerk').modal('show');
    })

    function data_mastermerk() {
      $.ajax({
        type: "POST",
        url: "../Master/getdatamastermerk",
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
            var btn_mastermerk =
              '<td style="text-align:center;">' +
              '<button  type="button" class="btn btn-primary btn-icon  merk_edit" data="' +
              data[i].id +
              '"><i class="fa fa-pen"></i></button >' +
              '  ' +
              '<button type="button" class="btn btn-danger btn-icon  merk_hapus"  data="' +
              data[i].id +
              '"><i class="fa fa-trash"></i></button> </br>' +
              '</td>';
    
            n++;
            html = [
              n,
              btn_mastermerk,
              data[i].nama_merk
            ];
    
            // Add the row to DataTables
            $('.table-1').DataTable().row.add(html);
          });
    
          // Draw the updated DataTables
          $('.table-1').DataTable().draw();
        },
      });
    }
    

    $('#data_master_merk').on('click','.merk_edit', function () {
      var id = $(this).attr('data');
      $.ajax({
          type: 'POST',
          url: "../Master/get_dataeditmastermerk",//dilanjut besok
          data: {
            id:id
          }
        }).done(function(data) {
          var data3 = $.parseJSON(data);
          $.each(data3, function (i) {
            $('#id_merk').val(data3[i].id);
            $('#nama_merk').val(data3[i].nama_merk);
          });
        });
        $('#modal_tambahmerk').modal('show');
  });

  $('#data_master_merk').on('click','.merk_hapus', function () {
    var id = $(this).attr('data');
    var table = 'm_merk';
    let text = "Anda yakin untuk menghapus master merk tersebut ?";
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
          data_mastermerk();
      } else {
          alert(response.message);
          data_mastermerk();
        }
      });
        }
});

    $('#save_mastermerk').on('click', function() {
      var id_merk = $('#id_merk').val();
      var nama_merk = $('#nama_merk').val();
      $('#save_mastermerk').addClass('btn-progress');

      $.ajax({
        type: 'POST',
        url: "../Master/master_merk_act",//dilanjut besok
        data: {
            id_merk:id_merk,
            nama_merk:nama_merk
        }
        }).done(function(response) {
          
            var pesan = response.message;
            console.log(response);
            console.log(pesan);
            if (response.status === '200') {
                alert(response.message);
                $('#save_mastermerk').removeClass('btn-progress');
                data_mastermerk();
            } else {
                alert(response.message);
                $('#save_mastermerk').removeClass('btn-progress');
                data_mastermerk();
                return false;
            }
            throttled = false;
        });
    })
});