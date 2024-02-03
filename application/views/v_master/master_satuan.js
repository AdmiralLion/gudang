  $(document).ready(function () {
    data_mastersatuan();
    reset_mastersatuan();


    function reset_mastersatuan()
    {
      $('#id_satuan').val('');
      $('#nama_satuan').val('');
      $('#alamat_satuan').val('');
      $('#notelp_satuan').val('');
      $('#email_satuan').val('');

    }

    $('.table-1').DataTable();

  
    $('#tambah_satuan').on('click', function() {
      $('#modal_tambahsatuan').modal('show');
    })

    function data_mastersatuan() {
      $.ajax({
        type: "POST",
        url: "../Master/getdatamastersatuan",
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
            var btn_mastersatuan =
              '<td style="text-align:center;">' +
              '<button  type="button" class="btn btn-primary btn-icon  satuan_edit" data="' +
              data[i].id +
              '"><i class="fa fa-pen"></i></button >' +
              '  ' +
              '<button type="button" class="btn btn-danger btn-icon  satuan_hapus"  data="' +
              data[i].id +
              '"><i class="fa fa-trash"></i></button> </br>' +
              '</td>';
    
            n++;
            html = [
              n,
              btn_mastersatuan,
              data[i].nama_satuan,
              data[i].deskripsi_satuan,
              data[i].notelp_satuan
            ];
    
            // Add the row to DataTables
            $('.table-1').DataTable().row.add(html);
          });
    
          // Draw the updated DataTables
          $('.table-1').DataTable().draw();
        },
      });
    }
    

    $('#data_master_satuan').on('click','.satuan_edit', function () {
      var id = $(this).attr('data');
      $.ajax({
          type: 'POST',
          url: "../Master/get_dataeditmastersatuan",//dilanjut besok
          data: {
            id:id
          }
        }).done(function(data) {
          var data3 = $.parseJSON(data);
          $.each(data3, function (i) {
            $('#id_satuan').val(data3[i].id);
            $('#nama_satuan').val(data3[i].nama_satuan);
            $('#deskripsi_satuan').val(data3[i].deskripsi_satuan);
          });
        });
        $('#modal_tambahsatuan').modal('show');
  });

  $('#data_master_satuan').on('click','.satuan_hapus', function () {
    var id = $(this).attr('data');
    var table = 'm_satuan';
    let text = "Anda yakin untuk menghapus master satuan tersebut ?";
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
          data_mastersatuan();
      } else {
          alert(response.message);
          data_mastersatuan();
        }
      });
        }
});

    $('#save_mastersatuan').on('click', function() {
      var id_satuan = $('#id_satuan').val();
      var nama_satuan = $('#nama_satuan').val();
      var deskripsi_satuan = $('#deskripsi_satuan').val();

      $.ajax({
        type: 'POST',
        url: "../Master/master_satuan_act",//dilanjut besok
        data: {
            id_satuan:id_satuan,
            nama_satuan:nama_satuan,
            deskripsi_satuan:deskripsi_satuan
        }
        }).done(function(response) {
          
            var pesan = response.message;
            console.log(response);
            console.log(pesan);
            if (response.status === '200') {
                alert(response.message);
                data_mastersatuan();
            } else {
                alert(response.message);
                data_mastersatuan();
                return false;
            }
            throttled = false;
        });
    })
});