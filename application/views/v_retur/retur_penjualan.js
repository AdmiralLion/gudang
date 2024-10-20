  $(document).ready(function () {
    // data_returpenjualan();
    // reset_masterbarang();
    // ChangeWidth();

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


    $('#tambah_returpenjualan').on('click', function() {
      $('#modal_tambahreturpenjualan').modal('show');
    })

    $('.select2').select2({
      placeholder: 'Pilih nama barang',
      width: "100%",
      dropdownParent: $('#modal_tambahreturpenjualan'),
      allowClear: true
    });

    

    $('#tgl_transaksi').change(function (){
      data_returpenjualan();
    });

    $('#tgl_retur').change(function (){
      get_returtgl();
    });

    function get_returtgl(){
      var tgl_retur = $('#tgl_retur').val();
      // if(tanggal_transaksi == null || tanggal_transaksi == ''){
      //   var tanggal_transaksi = new Date().toJSON().slice(0, 10);
      // }
      $.ajax({
        type:"POST",
        data:{
          tanggal_transaksi:tgl_retur
        },
        url: "../Transaksi/getdatatransaksikeluar",
        cache: false,
        success : function(data){
        console.log(data);
        var html;
                var i;
                var n =0;
                    var data = $.parseJSON(data);
                    $("#table-2").DataTable().clear();

            $.each(data, function(i){


                var btn_barang = '<td style="text-align:center;">'+'<a id="tampil_barang" data="'+data[i].id+'"" class="btn btn-info btn-icon tampil_barang"><i class="fa fa-download"> Cek!!</i>'+
                '</td>';

                  n++;
                  html = [
                    n,
                    data[i].kode_transaksi,
                    data[i].nama_pembeli,
                    data[i].tgl,
                    btn_barang
                  ];
          
                  // Add the row to DataTables
                  $("#table-2").DataTable().row.add(html);
                
                });
                    
            $("#table-2").DataTable().draw();

              }
        });
    }

    function data_returpenjualan(){
      var tanggal_transaksi = $('#tgl_transaksi').val();
      // if(tanggal_transaksi == null || tanggal_transaksi == ''){
      //   var tanggal_transaksi = new Date().toJSON().slice(0, 10);
      // }
      $.ajax({
        type:"POST",
        data:{
          tanggal_transaksi:tanggal_transaksi
        },
        url: "../Transaksi/getdatareturstok",
        cache: false,
        success : function(data){
        console.log(data);
        var html;
                var i;
                var n =0;
                    var data = $.parseJSON(data);
                    $("#table-1").DataTable().clear();

            $.each(data, function(i){


                var btn_returstoko = '<td style="text-align:center;">'+'<a href="<?php echo base_url();?>Transaksi/print_returstok/'+data[i].id+'" class="btn btn-info btn-icon" target="_blank"><i class="fa fa-print"></i>'+
                '</td>';

                  n++;
                  html = [
                    n,
                    data[i].kd_retur,
                    data[i].nama_pembeli,
                    data[i].nama_user,
                    data[i].tgl,
                    btn_returstoko
                  ];
          
                  // Add the row to DataTables
                  $("#table-1").DataTable().row.add(html);
                
                });
                    
            $("#table-1").DataTable().draw();

              }
        });
    }

    $('#data_barangpenjualan').on('click','.tampil_barang', function () {
      var id = $(this).attr('data');
      $.ajax({
          type: 'POST',
          url: "../Transaksi/getallbarangkeluar",//dilanjut besok
          data: {
            id:id
          },
          success : function(data){
            console.log(data);
            var html;
                    var i;
                    var n =0;
                        var data = $.parseJSON(data);
                        $("#table-3").DataTable().clear();
                        var masterbarang = data.master_barang;
                        var barang_keluar = data.barang_keluar;
                        var options1 = '';
                        var options2 = '';
                      
                        masterbarang.forEach(function(item) {
                          options1 += '<option value="' + item.id + '" data-harga="' + item.harga_barang + '">' + item.nama_barang + ' Merk '+ item.nama_merk + ' Tahun ' + item.tahun_barang + ' Seri ' + item.seri_barang + ' Kode Bulan ' + item.kode_bulan + ' Kode Urut ' + item.kode_urut+'</option>';
                      });
    
                $.each(barang_keluar, function(i){
    
                  $("#table-3").attr("style", "display:block");
                    var btn_returstok = '<td style="text-align:center;">'+'<a id="retur_barang" data="'+barang_keluar[i].id_stok+'" class="btn btn-info btn-icon retur_barang"><i class="fa fa-download"> Retur</i>'+
                    '</td>';

                    var input_alasan = '<td style="text-align:center;width:150px;">'+'<textarea class="form-control" name="input_alasan" id="input_alasan"></textarea>'+'</td>';

                    var pil_barang = '<td style="text-align:center;width:150px;">'+'<select class="select2" style="width:100px" id="nama_barang" name="nama_barang[]">' +'<option value="">--Barang--</option>'+options1 +'</select>'+'</td>';

    
                      n++;
                      html = [
                        n,
                        barang_keluar[i].kode_transaksi,
                        barang_keluar[i].nama_barang,
                        barang_keluar[i].nama_merk,
                        barang_keluar[i].tahun_barang,
                        barang_keluar[i].seri_barang,
                        barang_keluar[i].nama_pembeli,
                        barang_keluar[i].harga_jual,
                        barang_keluar[i].tgl_act,
                        pil_barang,
                        input_alasan,
                        btn_returstok
                      ];
              
                      // Add the row to DataTables
                      $("#table-3").DataTable().row.add(html);
                    
                    });
                        
                $("#table-3").DataTable().draw();
                $('#table-3').find('.select2').select2({
                  placeholder: '--Pilih--',
                  width: "100%",
                  dropdownParent: $('#modal_tambahreturpenjualan .modal-content'),
                  allowClear: true
              });
    
                  }
        })
  });

  $('#data_allbarang').on('click','.retur_barang', function () {
    var id = $(this).attr('data');
    var row = $(this).closest('tr');
    var alasan = row.find('textarea[name="input_alasan"]').val();
    var barang_ganti = row.find('select[name="nama_barang[]"]').val();
    console.log(id);
    var table = 'b_barang_masuk';
    let text = "Anda yakin untuk meretur stok barang tersebut ?";
    if (confirm(text) == true) {
      $.ajax({
        type: 'POST',
        url: "../Transaksi/retur_stok",//dilanjut besok
        data: {
          id:id,
          alasan:alasan,
          barang_ganti:barang_ganti,
          table:table
        }
      }).done(function(response) {
        console.log(response);
        var pesan = response.message;
        console.log(pesan);
        if (response.status === '200') {
          alert(response.message);
          get_returtgl();
          $("#table-3").DataTable();
          $("#table-3").attr("style", "display:none");
      } else {
          alert(response.message);
          get_returtgl();
          $("#table-3").DataTable();
          $("#table-3").attr("style", "display:none");
        }
      });
        }
});

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

    $('#save_returpenjualan').on('click', function() {
      var id_retur = $('#id_retur').val();
      // var id_rekanan = $('#nama_rekanan').val();
      var transaksi_temp = [];
      $('#save_returpenjualan').addClass('btn-progress');

      $('.form-group').each(function() {
        var nama_barang = $(this).find('#nama_barang').val();
        var nama_merk = $(this).find('#nama_merk').val();
        var tahun_barang = $(this).find('#tahun_barang').val();
        var seri_barang = $(this).find('#seri_barang').val();
        var kode_bulan = $(this).find('#kode_bulan').val();
        var kode_urut = $(this).find('#kode_urut').val();
        var harga_masuk = $(this).find('#harga_masuk').val();
        console.log(nama_barang);
        console.log(harga_masuk);
        if (nama_barang != undefined && harga_masuk != undefined){
          transaksi_temp.push({
            id_transaksi: id_transaksi,
            id_rekanan: id_rekanan,
            nama_barang: nama_barang,
            nama_merk: nama_merk,
            tahun_barang: tahun_barang,
            seri_barang: seri_barang,
            kode_bulan: kode_bulan,
            kode_urut: kode_urut,
            harga_masuk: harga_masuk
        });
        }
        // Push values into corresponding arrays
        
    });
console.log(transaksi_temp);
      $.ajax({
        type: 'POST',
        url: "../Transaksi/transaksi_masuk_act",//dilanjut besok
        data: { transaksi_temp: transaksi_temp },
        }).done(function(response) {
          
            var pesan = response.message;
            console.log(response);
            console.log(pesan);
            if (response.status === '200') {
                alert(response.message);
                $('#save_returpenjualan').removeClass('btn-progress');
                data_transaksimasuk();
                location.reload();
            } else {
                alert(response.message);
                $('#save_returpenjualan').removeClass('btn-progress');
                data_transaksimasuk();
                location.reload();
                return false;
            }
            throttled = false;
        });
    })

    function ChangeWidth() {
      var d = document.getElementsByClassName('modal-lg')
      for (var i = 0; i < d.length; i++)
      {
          d[i].style.width = "1200px";
      }
 
}

});

var room = 1;
function education_fields() {
  
                
    room++;
    var objTo = document.getElementById('education_fields')
    var divtest = document.createElement("div");
  divtest.setAttribute("class", "form-group removeclass"+room);
  var rdiv = 'removeclass'+room;
  $.ajax({
    type:"POST",
    url: "../Transaksi/getdatapenjualan",
    cache: false,
    success : function(response){
    var response = $.parseJSON(response);
    console.log(response);
    var masterbarang = response.master_barang;
    var mastermerk = response.master_merk;
    var options1 = '';
    var options2 = '';

    masterbarang.forEach(function(item) {
      options1 += '<option value="' + item.id + '">' + item.nama_barang + '</option>';
  });

  mastermerk.forEach(function(item2) {
    options2 += '<option value="' + item2.id + '">' + item2.nama_merk + '</option>';
});

  

  // $('#nama_barang').append(options1);
    divtest.innerHTML = '<div class="row">'+
    '<div class="col-sm-3 nopadding"><div class="form-group"> <label for="Barang">Barang :</label><br><select class="select2" style="width:100%" id="nama_barang" name="nama_barang[]">' +'<option value="">--Barang--</option>'+
                options1 +
                '</select></div></div>'+
    '<div class="col-sm-3 nopadding"><div class="form-group"> <label for="Merk">Merk :</label><br><select class="select2" style="width:100%" id="nama_merk" name="nama_merk[]">' +'<option value="">--Merk--</option>'+
    options2 +
    '</select></div></div>'+
    '<div class="col-sm-1 nopadding"><div class="form-group"> <input type="text" class="form-control" id="tahun_barang" name="tahun_barang[]" value="" placeholder="Tahun"></div></div>'+
    '<div class="col-sm-1 nopadding"><div class="form-group"> <input type="text" class="form-control" id="seri_barang" name="seri_barang[]" value="" placeholder="Seri"></div></div>'+
    '<div class="col-sm-1 nopadding"><div class="form-group"> <input type="text" class="form-control" id="kode_bulan" name="kode_bulan[]" value="" placeholder="Bulan"></div></div>'+
    '<div class="col-sm-1 nopadding"><div class="form-group"> <input type="text" class="form-control" id="kode_urut" name="kode_urut[]" value="" placeholder="Urut"></div></div>'+
    '<div class="col-sm-2 nopadding"><div class="form-group"><div class="input-group"><input type="text" placeholder="Harga" class="form-control" name="harga_masuk[]" id="harga_masuk" onkeyup="hitung_harga()"> &nbsp; &nbsp;<div class="input-group-btn"> <button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"> <span class="fa fa-minus" aria-hidden="true"></span> </button></div></div></div></div><div class="clear"></div></div>';
    objTo.appendChild(divtest)
    $('.select2').select2({
      placeholder: '--Pilih--',
      width: "100%",
      dropdownParent: $('#modal_tambahtransaksimasuk'),
      allowClear: true
    });
    }
    });
    
   
}
   function remove_education_fields(rid) {
     $('.removeclass'+rid).remove();
   }


   function hitung_harga() {
    // Get all elements with name 'harga_masuk[]'
    var harga_masuk_fields = document.getElementsByName('harga_masuk[]');
    
    var total = 0;

    // Iterate through all harga_masuk fields and sum up their values
    for (var i = 0; i < harga_masuk_fields.length; i++) {
        var harga_masuk_value = parseFloat(harga_masuk_fields[i].value) || 0; // Parse float, default to 0 if NaN
        total += harga_masuk_value;
    }

    // Update the value of the 'harga_total' field with the calculated total
    document.getElementById('harga_total').value = total;
}