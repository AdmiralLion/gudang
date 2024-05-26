  $(document).ready(function () {
    data_masterharga();
    reset_masterharga();
    
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

    function reset_masterharga()
    {
      $('#id_harga').val('');
      $('#harga_jual').val('');
      $('#nama_barang').val('');
      $('#nama_satuan').val('');
      $('#harga_barang').val('');

    }

    $('.table-1').DataTable();
    // $('.table-2').DataTable();
    // $('.table-1').DataTable();

  
    // $('#edit_').on('click', function() {
    //   $('#modal_tambahsatuan').modal('show');
    // })

    function data_masterharga() {
      $.ajax({
        type: "POST",
        url: "../Master/getdatabarang",
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
            var btn_editharga =
              '<td style="text-align:center;">' +
              '<button  type="button" class="btn btn-primary btn-icon edit_harga" data="' +
              data[i].id +
              '"><i class="fa fa-pen"></i></button >';
    
            n++;
            html = [
              n,
              btn_editharga,
              data[i].nama_barang,
              data[i].nama_satuan
            ];
    
            // Add the row to DataTables
            $('.table-1').DataTable().row.add(html);

          });
    
          // Draw the updated DataTables
          $('.table-1').DataTable().draw();
        },
      });
    }
    

    $('#data_master_harga').on('click','.edit_harga', function () {
      var id = $(this).attr('data');
      $.ajax({
          type: 'POST',
          url: "../Master/getdatabarang2",//dilanjut besok
          data: {
            id:id
          }
        }).done(function(data) {
          var data3 = $.parseJSON(data);
          $.each(data3, function (i) {
            $('#id_barang').val(data3[i].id);
            $('#nama_barang').val(data3[i].nama_barang);
            $('#nama_satuan').val(data3[i].nama_satuan);
            data_harga2(id);

          });
        });
        $('#modal_harga').modal('show');
  });

    $('#save_harga').on('click', function() {
      var id_harga = $('#id_harga').val();
      var id_barang = $('#id_barang').val();
      var nama_barang = $('#nama_barang').val();
      var nama_satuan = $('#nama_satuan').val();
      var harga_barang = $('#harga_barang').val();
      $('#save_harga').addClass('btn-progress');

      $.ajax({
        type: 'POST',
        url: "../Master/master_harga_act",//dilanjut besok
        data: {
            id_harga:id_harga,
            id_barang:id_barang,
            nama_barang:nama_barang,
            nama_satuan:nama_satuan,
            harga_barang:harga_barang
        }
        }).done(function(response) {
          
            var pesan = response.message;
            console.log(response);
            console.log(pesan);
            if (response.status === '200') {
                alert(response.message);
                $('#save_harga').removeClass('btn-progress');
                data_harga2(id_barang);
            } else {
                alert(response.message);
                $('#save_harga').removeClass('btn-progress');
                data_harga2(id_barang);
                return false;
            }
            throttled = false;
        });
    })

    function data_harga2(id_barang) {
      var id_barang = id_barang;
      console.log(id_barang);
      $.ajax({
        type: "POST",
        url: "../Master/getharga",
        data: {
          id_barang:id_barang
        },
        cache: false,
        success: function (data) {
          console.log(data);
          var html;
          var i;
          var n = 0;
          var data = $.parseJSON(data);
          // alert(data.length);
    
          // Clear existing DataTables content
          // $('.table-2').DataTable().clear();
          if(data.length > 0){
            $.each(data, function (i) {
              // alert('ini cek');
              var btn_editharga2 =
                '<td style="text-align:center;">' +
                '<button  type="button" class="btn btn-primary btn-icon edit_harga2" data="' +
                data[i].id +
                '"><i class="fa fa-pen"></i></button >';
      
              n++;
              // html = [
              //   n,
              //   btn_editharga2,
              //   data[i].harga_jual
              // ];
              html += '<tr>'+
              '<td>'+n+'</td>'+
              btn_editharga2+
                              '<td style="text-align:center;">'+data[i].harga_jual+'</td>'
                              '</tr>';
            $('#dataharga').html(html);
  
  
      
              // Add the row to DataTables
              // $('.table-2').DataTable().row.add(html);
            });
          }else{
          //   var btn_editharga2 =
          //   '<td style="text-align:center;">' +
          //   '<button  type="button" class="btn btn-primary btn-icon edit_harga2" data="' +
          //   data[i].id +
          //   '"><i class="fa fa-pen"></i></button >';
  
          // n++;
          // html = [
          //   n,
          //   btn_editharga2,
          //   data[i].harga_jual
          // ];
          html += '<tr>'+
          '<td colspan="3">DATA KOSONG</td>'+
                          '</tr>';
          $('#dataharga').html(html);
          }
      
    
          // Draw the updated DataTables
          // $('.table-2').DataTable().draw();
        },
      });
    }

    $('#dataharga').on('click','.edit_harga2', function () {
      var id = $(this).attr('data');
      $.ajax({
          type: 'POST',
          url: "../Master/gethargabarang",//dilanjut besok
          data: {
            id:id
          }
        }).done(function(data) {
          var data3 = $.parseJSON(data);
          $.each(data3, function (i) {
            var id_barang = data3[i].id_barang;
            $('#id_harga').val(data3[i].id);
            $('#id_barang').val(data3[i].id_barang);
            $('#nama_barang').val(data3[i].nama_barang);
            $('#nama_satuan').val(data3[i].satuan_barang);
            $('#harga_barang').val(data3[i].harga_jual);
            data_harga2(id_barang);

          });
        });
        // $('#modal_harga').modal('show');
  });

});