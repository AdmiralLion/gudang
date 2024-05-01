  $(document).ready(function () {
    data_masterbarang();
    reset_masterbarang();

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
  
    function reset_masterbarang()
    {
      $('#id_barang').val('');
      $('#nama_barang').val('');
      $('#satuan_barang').val('');
      $('#jenis_barang').val('');
    }

    $("#table-1").dataTable();
  
    $('#tambah_barang').on('click', function() {
      $('#modal_tambahbarang').modal('show');
    })

    function data_masterbarang(){
      $.ajax({
        type:"POST",
        url: "../Master/getdatamasterbarang",
        cache: false,
        success : function(data){
        console.log(data);
        var html;
                var i;
                var n =0;
                    var data = $.parseJSON(data);
                    $("#table-1").DataTable().clear();

            $.each(data, function(i){

                var btn_masterbrg = '<td style="text-align:center;">'+
                '<button  type="button" class="btn btn-primary btn-icon  barang_edit" data="'+data[i].id+'"><i class="fa fa-pen"></i></button >'+'  '
                +'<button type="button" class="btn btn-danger btn-icon  barang_hapus"  data="'+data[i].id+'"><i class="fa fa-trash"></i></button> </br>'+
                '</td>';

                  n++;
                  html = [
                    n,
                    btn_masterbrg,
                    data[i].nama_barang,
                    data[i].satuan_barang,
                    data[i].jenis_barang
                  ];
          
                  // Add the row to DataTables
                  $("#table-1").DataTable().row.add(html);
                
                });
                    
            $("#table-1").DataTable().draw();

              }
        });
    }

    $('#data_master_barang').on('click','.barang_edit', function () {
      var id = $(this).attr('data');
      $.ajax({
          type: 'POST',
          url: "../Master/get_dataeditmasterbarang",//dilanjut besok
          data: {
            id:id
          }
        }).done(function(data) {
          var data3 = $.parseJSON(data);
          $.each(data3, function (i) {
            $('#id_barang').val(data3[i].id);
            $('#nama_barang').val(data3[i].nama_barang);
            $('#satuan_barang').val(data3[i].satuan_barang);
            $('#jenis_barang').val(data3[i].jenis_barang);
          });
        });
        $('#modal_tambahbarang').modal('show');
  });

  $('#data_master_barang').on('click','.barang_hapus', function () {
    var id = $(this).attr('data');
    var table = 'm_barang';
    let text = "Anda yakin untuk menghapus master barang tersebut ?";
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
          data_masterbarang();
          $("#table-1").DataTable();
      } else {
          alert(response.message);
          data_masterbarang();
          $("#table-1").DataTable();
        }
      });
        }
});

    $('#save_masterbarang').on('click', function() {
      var id_barang = $('#id_barang').val();
      var nama_barang = $('#nama_barang').val();
      var satuan_barang = $('#satuan_barang').val();
      var jenis_barang = $('#jenis_barang').val();
      $.ajax({
        type: 'POST',
        url: "../Master/master_barang_act",//dilanjut besok
        data: {
            id_barang:id_barang,
            nama_barang:nama_barang,
            satuan_barang:satuan_barang,
            jenis_barang:jenis_barang,
        }
        }).done(function(response) {
          
            var pesan = response.message;
            console.log(response);
            console.log(pesan);
            if (response.status === '200') {
                alert(response.message);
                data_masterbarang();
            } else {
                alert(response.message);
                data_masterbarang();
                return false;
            }
            throttled = false;
        });
    })



});