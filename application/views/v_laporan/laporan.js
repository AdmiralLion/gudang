  $(document).ready(function () {
    // data_transaksimasuk();
    // reset_masterbarang();
    // ChangeWidth();

//     $('#btn1').on('click', function(){
//       $('<a href="<?= base_url();?>Laporan/lap_barang_masuk" target="blank"></a>')[0].click();    
// })

// $('#btn2').on('click', function(){
//   $('<a href="<?= base_url();?>Laporan/lap_barang_keluar" target="blank"></a>')[0].click();    
// })

// $('#btn3').on('click', function(){
//   $('<a href="<?= base_url();?>Laporan/lap_retur_supplier" target="blank"></a>')[0].click();    
// })

// $('#btn4').on('click', function(){
//   $('<a href="<?= base_url();?>Laporan/lap_retur_penjualan" target="blank"></a>')[0].click();    
// })

// $('#btn5').on('click', function(){
//   $('<a href="<?= base_url();?>Laporan/lap_penghasilan" target="blank"></a>')[0].click();    
// })

// $('#btn6').on('click', function(){
//   $('<a href="<?= base_url();?>Laporan/lap_barang_masuk" target="blank"></a>')[0].click();    
// })

  //   $('#btn1').click(function(){
  //     window.location.href='<?= base_url();?>Laporan/lap_barang_masuk';
  //  })

  //  $('#btn2').click(function(){
  //   window.location.href='<?= base_url();?>Laporan/lap_barang_keluar';
  //   })
    
  //   $('#btn3').click(function(){
  //     window.location.href='<?= base_url();?>Laporan/lap_retur_supplier';
  //   })

  //   $('#btn4').click(function(){
  //     window.location.href='<?= base_url();?>Laporan/lap_retur_penjualan';
  //   })

  //   $('#btn5').click(function(){
  //     window.location.href='<?= base_url();?>Laporan/lap_penghasilan';
  //   })

    // $('#btn6').click(function(){
    //   window.location.href='<?= base_url();?>Laporan/lap_barang_masuk';
    // })

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

    $('#jns_laporan').on("change", function () {
      var jns_laporan = $('#jns_laporan').val();
      $('#jangka_waktu').val('');
          if(jns_laporan == 'Laporan Stok Gudang'){
            $("#lap_harian").attr("style", "display: none;");
            $("#btn_lihat").removeAttr("style");
            $("#btn_download").removeAttr("style");
            $("#lap_bulanan").attr("style", "display: none;");
            $("#lap_rtgwaktu1").attr("style", "display: none;");
            $("#lap_rtgwaktu2").attr("style", "display: none;");
            $("#tglgrup").attr("style", "display: none;");
            $("#jangka_waktu").attr("style", "display: none;");
          }else{
            $("#jangka_waktu").removeAttr("style");
          }
        })


    $('#jangka_waktu').on("change", function () {
      var jangka_waktu = $('#jangka_waktu').val();
          if(jangka_waktu == 'Harian'){
            $("#lap_harian").removeAttr("style");
            $("#btn_lihat").removeAttr("style");
            $("#btn_download").removeAttr("style");
            $("#lap_bulanan").attr("style", "display: none;");
            $("#lap_rtgwaktu1").attr("style", "display: none;");
            $("#lap_rtgwaktu2").attr("style", "display: none;");
            $("#tglgrup").attr("style", "display: none;");
            // $("#lap_tahunan").attr("style", "display: none;");
            // $('#lap_tahunan').val('');
            $('#lap_bulanan').val('');
          }else if(jangka_waktu == 'Bulanan'){
            $("#lap_bulanan").removeAttr("style");
            $("#btn_lihat").removeAttr("style");
            $("#btn_download").removeAttr("style");
            $("#lap_harian").attr("style", "display: none;");
            $("#lap_rtgwaktu1").attr("style", "display: none;");
            $("#lap_rtgwaktu2").attr("style", "display: none;");
            $("#tglgrup").attr("style", "display: none;");
            // $("#lap_tahunan").attr("style", "display: none;");
            // $('#lap_tahunan').val('');
            $('#lap_harian').val('');
          }else if(jangka_waktu == 'Rentang Waktu'){
            $("#lap_rtgwaktu1").removeAttr("style");
            $("#lap_rtgwaktu2").removeAttr("style");
            $("#tglgrup").removeAttr("style");
            $("#btn_lihat").removeAttr("style");
            $("#btn_download").removeAttr("style");
            $("#lap_harian").attr("style", "display: none;");
            $("#lap_bulanan").attr("style", "display: none;");
            // $("#lap_tahunan").attr("style", "display: none;");
            // $('#lap_tahunan').val('');
            $('#lap_harian').val('');
          }else{
            $("#lap_harian").attr("style", "display: none;");
            $("#lap_bulanan").attr("style", "display: none;");
            $("#btn_lihat").attr("style", "display: none;");
            $("#btn_download").attr("style", "display: none;");
            $("#lap_rtgwaktu1").attr("style", "display: none;");
            $("#lap_rtgwaktu2").attr("style", "display: none;");
            $("#tglgrup").attr("style", "display: none;");
            // $("#lap_tahunan").attr("style", "display: none;");
            $('#lap_bulanan').val('');
            $('#lap_harian').val('');
            // $('#lap_tahunan').val('');

          }
    })

    $('#btn_lihat').click(function(){
      var jns_laporan = $('#jns_laporan').val();
      var jangka_waktu = $('#jangka_waktu').val();
      var jns_lap = 'print';
      if(jns_laporan == 'Laporan Barang Masuk' && jangka_waktu == 'Harian'){  
        var lap_harian = $('#lap_harian').val();
          $('<a href="<?= base_url();?>Laporan/print_barang_masuk/?jangka_waktu='+jangka_waktu+'&tgl='+lap_harian+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Barang Masuk' && jangka_waktu == 'Bulanan'){
        var lap_bulanan = $('#lap_bulanan').val();
        $('<a href="<?= base_url();?>Laporan/print_barang_masuk/?jangka_waktu='+jangka_waktu+'&tgl='+lap_bulanan+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Barang Keluar' && jangka_waktu == 'Harian'){
                var lap_harian = $('#lap_harian').val();
          $('<a href="<?= base_url();?>Laporan/print_barang_keluar/?jangka_waktu='+jangka_waktu+'&tgl='+lap_harian+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Barang Keluar' && jangka_waktu == 'Bulanan'){
                var lap_bulanan = $('#lap_bulanan').val();
          $('<a href="<?= base_url();?>Laporan/print_barang_keluar/?jangka_waktu='+jangka_waktu+'&tgl='+lap_bulanan+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Barang Keluar' && jangka_waktu == 'Rentang Waktu'){
        var lap_rtgwaktu1 = $('#lap_rtgwaktu1').val();
        var lap_rtgwaktu2 = $('#lap_rtgwaktu2').val();
        $('<a href="<?= base_url();?>Laporan/print_barang_keluar/?jangka_waktu='+jangka_waktu+'&tgl1='+lap_rtgwaktu1+'&tgl2='+lap_rtgwaktu2+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Retur Supplier' && jangka_waktu == 'Harian'){
                var lap_harian = $('#lap_harian').val();
          $('<a href="<?= base_url();?>Laporan/print_retur_supplier/?jangka_waktu='+jangka_waktu+'&tgl='+lap_harian+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Retur Supplier' && jangka_waktu == 'Bulanan'){
                var lap_bulanan = $('#lap_bulanan').val();
          $('<a href="<?= base_url();?>Laporan/print_retur_supplier/?jangka_waktu='+jangka_waktu+'&tgl='+lap_bulanan+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Retur Penjualan' && jangka_waktu == 'Harian'){
                var lap_harian = $('#lap_harian').val();
          $('<a href="<?= base_url();?>Laporan/print_retur_penjualan/?jangka_waktu='+jangka_waktu+'&tgl='+lap_harian+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Retur Penjualan' && jangka_waktu == 'Bulanan'){
                var lap_bulanan = $('#lap_bulanan').val();
          $('<a href="<?= base_url();?>Laporan/print_retur_penjualan/?jangka_waktu='+jangka_waktu+'&tgl='+lap_bulanan+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Penghasilan' && jangka_waktu == 'Harian'){
                var lap_harian = $('#lap_harian').val();
          $('<a href="<?= base_url();?>Laporan/print_penghasilan/?jangka_waktu='+jangka_waktu+'&tgl='+lap_harian+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Penghasilan' && jangka_waktu == 'Bulanan'){
                var lap_bulanan = $('#lap_bulanan').val();
          $('<a href="<?= base_url();?>Laporan/print_penghasilan/?jangka_waktu='+jangka_waktu+'&tgl='+lap_bulanan+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Pembayaran Hutang' && jangka_waktu == 'Harian'){
        var lap_harian = $('#lap_harian').val();
        $('<a href="<?= base_url();?>Laporan/print_pembayaran_hutang/?jangka_waktu='+jangka_waktu+'&tgl='+lap_harian+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Pembayaran Hutang' && jangka_waktu == 'Bulanan'){
              var lap_bulanan = $('#lap_bulanan').val();
        $('<a href="<?= base_url();?>Laporan/print_pembayaran_hutang/?jangka_waktu='+jangka_waktu+'&tgl='+lap_bulanan+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Jatuh Tempo' && jangka_waktu == 'Harian'){
        var lap_harian = $('#lap_harian').val();
        $('<a href="<?= base_url();?>Laporan/print_jatuh_tempo/?jangka_waktu='+jangka_waktu+'&tgl='+lap_harian+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Jatuh Tempo' && jangka_waktu == 'Bulanan'){
              var lap_bulanan = $('#lap_bulanan').val();
        $('<a href="<?= base_url();?>Laporan/print_jatuh_tempo/?jangka_waktu='+jangka_waktu+'&tgl='+lap_bulanan+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Stok Gudang'){
        var lap_harian = $('#lap_harian').val();
        $('<a href="<?= base_url();?>Laporan/print_stok_gudang/?jangka_waktu='+jangka_waktu+'&tgl='+lap_harian+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }
    });

    $('#btn_download').click(function(){
      var jns_laporan = $('#jns_laporan').val();
      var jangka_waktu = $('#jangka_waktu').val();
      var jns_lap = 'excel';
      if(jns_laporan == 'Laporan Barang Masuk' && jangka_waktu == 'Harian'){  
        var lap_harian = $('#lap_harian').val();
          $('<a href="<?= base_url();?>Laporan/print_barang_masuk/?jangka_waktu='+jangka_waktu+'&tgl='+lap_harian+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Barang Masuk' && jangka_waktu == 'Bulanan'){
        var lap_bulanan = $('#lap_bulanan').val();
        $('<a href="<?= base_url();?>Laporan/print_barang_masuk/?jangka_waktu='+jangka_waktu+'&tgl='+lap_bulanan+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Barang Keluar' && jangka_waktu == 'Harian'){
                var lap_harian = $('#lap_harian').val();
          $('<a href="<?= base_url();?>Laporan/print_barang_keluar/?jangka_waktu='+jangka_waktu+'&tgl='+lap_harian+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Barang Keluar' && jangka_waktu == 'Bulanan'){
                var lap_bulanan = $('#lap_bulanan').val();
          $('<a href="<?= base_url();?>Laporan/print_barang_keluar/?jangka_waktu='+jangka_waktu+'&tgl='+lap_bulanan+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Barang Keluar' && jangka_waktu == 'Rentang Waktu'){
        var lap_rtgwaktu1 = $('#lap_rtgwaktu1').val();
        var lap_rtgwaktu2 = $('#lap_rtgwaktu2').val();
        $('<a href="<?= base_url();?>Laporan/print_barang_keluar/?jangka_waktu='+jangka_waktu+'&tgl1='+lap_rtgwaktu1+'&tgl2='+lap_rtgwaktu2+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Retur Supplier' && jangka_waktu == 'Harian'){
                var lap_harian = $('#lap_harian').val();
          $('<a href="<?= base_url();?>Laporan/print_retur_supplier/?jangka_waktu='+jangka_waktu+'&tgl='+lap_harian+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Retur Supplier' && jangka_waktu == 'Bulanan'){
                var lap_bulanan = $('#lap_bulanan').val();
          $('<a href="<?= base_url();?>Laporan/print_retur_supplier/?jangka_waktu='+jangka_waktu+'&tgl='+lap_bulanan+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Retur Penjualan' && jangka_waktu == 'Harian'){
                var lap_harian = $('#lap_harian').val();
          $('<a href="<?= base_url();?>Laporan/print_retur_penjualan/?jangka_waktu='+jangka_waktu+'&tgl='+lap_harian+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Retur Penjualan' && jangka_waktu == 'Bulanan'){
                var lap_bulanan = $('#lap_bulanan').val();
          $('<a href="<?= base_url();?>Laporan/print_retur_penjualan/?jangka_waktu='+jangka_waktu+'&tgl='+lap_bulanan+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Penghasilan' && jangka_waktu == 'Harian'){
                var lap_harian = $('#lap_harian').val();
          $('<a href="<?= base_url();?>Laporan/print_penghasilan/?jangka_waktu='+jangka_waktu+'&tgl='+lap_harian+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Penghasilan' && jangka_waktu == 'Bulanan'){
                var lap_bulanan = $('#lap_bulanan').val();
          $('<a href="<?= base_url();?>Laporan/print_penghasilan/?jangka_waktu='+jangka_waktu+'&tgl='+lap_bulanan+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Pembayaran Hutang' && jangka_waktu == 'Harian'){
        var lap_harian = $('#lap_harian').val();
        $('<a href="<?= base_url();?>Laporan/print_pembayaran_hutang/?jangka_waktu='+jangka_waktu+'&tgl='+lap_harian+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Pembayaran Hutang' && jangka_waktu == 'Bulanan'){
              var lap_bulanan = $('#lap_bulanan').val();
        $('<a href="<?= base_url();?>Laporan/print_pembayaran_hutang/?jangka_waktu='+jangka_waktu+'&tgl='+lap_bulanan+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Jatuh Tempo' && jangka_waktu == 'Harian'){
        var lap_harian = $('#lap_harian').val();
        $('<a href="<?= base_url();?>Laporan/print_jatuh_tempo/?jangka_waktu='+jangka_waktu+'&tgl='+lap_harian+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Jatuh Tempo' && jangka_waktu == 'Bulanan'){
              var lap_bulanan = $('#lap_bulanan').val();
        $('<a href="<?= base_url();?>Laporan/print_jatuh_tempo/?jangka_waktu='+jangka_waktu+'&tgl='+lap_bulanan+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }else if(jns_laporan == 'Laporan Stok Gudang'){
        var lap_harian = $('#lap_harian').val();
        $('<a href="<?= base_url();?>Laporan/print_stok_gudang/?jangka_waktu='+jangka_waktu+'&tgl='+lap_harian+'&jnslap='+jns_lap+'" target="blank"></a>')[0].click();    
      }
    });

    $("#table-1").dataTable();


    $('#tambah_transaksimasuk').on('click', function() {
      $('#modal_tambahtransaksimasuk').modal('show');
    })

    $('.select2').select2({
      placeholder: 'Pilih nama rekanan',
      width: "100%",
      dropdownParent: $('#modal_tambahtransaksimasuk'),
      allowClear: true
    });

    $('.select2').select2({
      placeholder: 'tes',
      width: "100%",
      dropdownParent: $('#modal_tambahtransaksimasuk'),
      allowClear: true
    });

    $('#tgl_transaksi').change(function (){
      data_transaksimasuk();
    });


    function data_transaksimasuk(){
      var tanggal_transaksi = $('#tgl_transaksi').val();
      // if(tanggal_transaksi == null || tanggal_transaksi == ''){
      //   var tanggal_transaksi = new Date().toJSON().slice(0, 10);
      // }
      $.ajax({
        type:"POST",
        data:{
          tanggal_transaksi:tanggal_transaksi
        },
        url: "../Transaksi/getdatatransaksimasuk",
        cache: false,
        success : function(data){
        console.log(data);
        var html;
                var i;
                var n =0;
                    var data = $.parseJSON(data);
                    $("#table-1").DataTable().clear();

            $.each(data, function(i){


                var btn_transaksimasuk = '<td style="text-align:center;">'+'<a href="<?php echo base_url();?>Transaksi/print_transaksimasuk/'+data[i].id+'" class="btn btn-info btn-icon" target="_blank"><i class="fa fa-print"></i>'+
                '</td>';

                  n++;
                  html = [
                    n,
                    data[i].kode_transaksi,
                    data[i].nama_rekanan,
                    data[i].tgl,
                    btn_transaksimasuk
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

    $('#save_transaksimasuk').on('click', function() {
      var id_transaksi = $('#id_transaksi').val();
      var id_rekanan = $('#nama_rekanan').val();
      var transaksi_temp = [];

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
                data_transaksimasuk();
                location.reload();
            } else {
                alert(response.message);
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
    url: "../Transaksi/getdatamasterbarang",
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
      dropdownParent: $('#modal_tambahtransaksimasuk .modal-content'),
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

$(function() {
  $("#lap_bulanan").datepicker( {
      format: "mm-yyyy",
      startView: "months", 
      minViewMode: "months"
  });
  });