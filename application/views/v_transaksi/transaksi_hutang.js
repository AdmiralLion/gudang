$(document).ready(function () {
  data_transaksihutang();
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


  $('#tambah_transaksikeluar').on('click', function() {
    $('#modal_tambahtransaksikeluar').modal('show');
  })

  $('.select2').select2({
    placeholder: 'Pilih nama rekanan',
    width: "100%",
    dropdownParent: $('#modal_tambahtransaksikeluar'),
    allowClear: true
  });

  $('.select2').select2({
    placeholder: 'tes',
    width: "100%",
    dropdownParent: $('#modal_tambahtransaksikeluar'),
    allowClear: true
  });

  $('#tgl_transaksi').change(function (){
    data_transaksihutang();
  });

  $("#tutup").click(function(){
    location.reload();
  });
  
  $("#tutupmdl").click(function(){
    location.reload();
  });

  $("#tgl_transaksi").datepicker( {
    format: "mm-yyyy",
    startView: "months", 
    minViewMode: "months"
});

  function data_transaksihutang(){
    var tanggal_transaksi = $('#tgl_transaksi').val();
    // if(tanggal_transaksi == null || tanggal_transaksi == ''){
    //   var tanggal_transaksi = new Date().toJSON().slice(0, 10);
    // }
    $.ajax({
      type:"POST",
      data:{
        tanggal_transaksi:tanggal_transaksi
      },
      url: "../Transaksi/getdatahutang",
      cache: false,
      success : function(data){
      console.log(data);
      var html;
              var i;
              var n =0;
                  var data = $.parseJSON(data);
                  $("#table-1").DataTable().clear();

          $.each(data, function(i){


            var btn_hutang =
            '<td style="text-align:center;">' +
            '<button  type="button" class="btn btn-primary btn-icon  bayar_hutang" data="' +
            data[i].kode_transaksi +
            '"><i class="fa fa-money-bill-wave"></i></button >' +
            '</td>';

            if(data[i].is_lunas == 1){
              var btn_indikator = '<td style="text-align:center;">' +
                '<button  type="button" class="btn btn-success btn-icon " data="' +
                data[i].id +
                '">Lunas</button >' +
              '</td>';
            }else{
              var btn_indikator =  '<td style="text-align:center;">' +
                '<button  type="button" class="btn btn-danger btn-icon " data="' +
                data[i].id +
                '">Belum Lunas</button >' +
              '</td>';
            }

                n++;
                html = [
                  n,
                  data[i].kode_transaksi,
                  data[i].nama_pembeli,
                  data[i].tgl,
                  data[i].tgl_jatuhtempo,
                  btn_indikator,
                  btn_hutang
                ];
        
                // Add the row to DataTables
                $("#table-1").DataTable().row.add(html);
              
              });
                  
          $("#table-1").DataTable().draw();

            }
      });
  }

  $('#data_transaksihutang').on('click','.bayar_hutang', function () {
    var kode_transaksi = $(this).attr('data');
    $.ajax({
        type: 'POST',
        url: "../Transaksi/data_hutang",//dilanjut besok
        data: {
          kode_transaksi:kode_transaksi
        }
      }).done(function(data) {
        var n =0;
        var m =0;

        var data4 = $.parseJSON(data);
        var listData = data4.list_data;
        var historiHutang = data4.histori_hutang;
        var data2 = data4.bayar;
        console.log(historiHutang);

        // Accessing individual elements from 'bayar'
        var pay = data2.pay;
        var kodeTransaksi = data2.kode_transaksi;
        // Use the retrieved values as needed
        $('#sudah_bayar').val(pay);
        $('#kode_transaksi').val(kodeTransaksi);
        $('#tot_seluruh').val(data2.total_harga);
        $('#potongan_bayar').val(data2.potongan);
        $('#belum_bayar').val(data2.harus_bayar);
        $.each(listData, function(i, item) {
          $('#nama_pembeli').val(item.nama_pembeli);
          console.log(item.is_retur);
          if(item.is_retur == 1){
            var btn_retur = '<td style="text-align:center;">' +
              '<button  type="button" class="btn btn-success btn-icon ">Sudah Retur</button >' +
            '</td>';
          }else{
            var btn_retur =  '<td style="text-align:center;">' +
              '<button  type="button" class="btn btn-danger btn-icon ">Tidak Retur</button >' +
            '</td>';
          }
          var row_barang = '<td style="text-align:center;">' + item.nama_barang + ' - ' + item.nama_merk  + ' - ' + item.tahun_barang  + ' - ' + item.seri_barang  + ' - ' + item.kode_bulan  + ' - ' + item.kode_urut + '</td>';
          n++;
          var html = [
              n,
              item.kode_transaksi,
              row_barang,
              item.tgl_act,
              btn_retur,
              item.harga_jual
          ];
        
                // Add the row to DataTables
                $("#table-2").DataTable().row.add(html);
              
              });

        $.each(historiHutang, function(i, item) {
          m++;
          var html2 = '<tr>'
          +'<td style="text-align:center;">' + m + '</td>'
            +'<td style="text-align:center;">' + item.kode_hutang + '</td>'
            +'<td style="text-align:center;">' + item.kode_transaksi + '</td>'
            +'<td style="text-align:center;">' + item.pembayaran + '</td>'
            +'<td style="text-align:center;">' + item.nama_user + '</td>'
            +'<td style="text-align:center;">' + item.tgl + '</td>'
            + '</tr>';

            $('#histori_hutang').append(html2);

                // Add the row to DataTables
              
              });
                  
          $("#table-2").DataTable().draw();

      });
      $('#modal_pelunasan').modal('show');
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

  $('#save_transaksiutang').on('click', function() {
    var kode_transaksi = $('#kode_transaksi').val();
    var nama_pembeli = $('#nama_pembeli').val();
    var akan_bayar = $('#akan_bayar').val();
    var belum_bayar = $('#belum_bayar').val();
    $('#save_transaksiutang').addClass('btn-progress');

    $.ajax({
      type: 'POST',
      url: "../Transaksi/transaksi_hutang_act",//dilanjut besok
      data: { 
        kode_transaksi: kode_transaksi,
        nama_pembeli: nama_pembeli, 
        belum_bayar: belum_bayar,
        akan_bayar: akan_bayar
      },
      }).done(function(response) {
        
          var pesan = response.message;
          console.log(response);
          console.log(pesan);
          if (response.status === '200') {
              alert(response.message);
              $('#save_transaksiutang').removeClass('btn-progress');
              data_transaksihutang();
              location.reload();
          } else {
              alert(response.message);
              $('#save_transaksiutang').removeClass('btn-progress');
              data_transaksihutang();
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
  url: "../Transaksi/getdatamasterbarangready",
  cache: false,
  success : function(response){
  var response = $.parseJSON(response);
  console.log(response);
  var masterbarang = response.master_barang;
  var mastermerk = response.mastermerk;
  var options1 = '';
  var options2 = '';

  masterbarang.forEach(function(item) {
    options1 += '<option value="' + item.id + '" data-harga="' + item.harga_barang + '">' + item.nama_barang + ' Merk '+ item.nama_merk + ' Tahun ' + item.tahun_barang + ' Seri ' + item.seri_barang + ' Kode Bulan ' + item.kode_bulan + ' Kode Urut ' + item.kode_urut+'</option>';
});

//   mastermerk.forEach(function(item2) {
//     options2 += '<option value="' + item2.id + '">' + item2.nama_merk + '</option>';
// });



// $('#nama_barang').append(options1);
  divtest.innerHTML = '<div class="row">'+
  '<div class="col-sm-6 nopadding"><div class="form-group"> <label for="Barang">Barang :</label><br><select class="select2" style="width:100%" id="nama_barang" name="nama_barang[]" onchange="setHarga(this)">' +'<option value="">--Barang--</option>'+
              options1 +
  '</select></div></div>'+'<div class="col-sm-2 nopadding"><div class="form-group"><label for="Harga">Harga Masuk :</label><br><div class="input-group"><input type="text" placeholder="Harga" class="form-control" name="harga_masuk[]" id="harga_masuk" readonly></div></div></div>'+
  '<div class="col-sm-2 nopadding"><div class="form-group"><label for="Urut">Hutang :</label> <br> <select class="select2" style="width:100%" id="hutang" name="hutang[]">' +'<option value="">Hutang</option>'+
  '<option value="Tidak">Tidak</option>'+'<option value="Iya">Iya</option>'+
  '</select></div></div>'+
  '<div class="col-sm-2 nopadding"><div class="form-group"> <label for="Harga Keluar">Harga Keluar :</label><br><div class="input-group"><input type="text" placeholder="Harga" class="form-control" name="harga_keluar[]" id="harga_keluar" onkeyup="hitung_harga()"> &nbsp; &nbsp;<div class="input-group-btn"> <button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"> <span class="fa fa-minus" aria-hidden="true"></span> </button></div></div></div></div><div class="clear"></div></div>';
  objTo.appendChild(divtest)
  $('.select2').select2({
    placeholder: '--Pilih--',
    width: "100%",
    dropdownParent: $('#modal_tambahtransaksikeluar .modal-content'),
    allowClear: true
  });
  }
  });
  
 
}
 function remove_education_fields(rid) {
   $('.removeclass'+rid).remove();
 }

 function setHarga(select) {
  var hargaMasukInput = $(select).closest('.row').find('#harga_masuk');
  var selectedOption = $(select).find('option:selected');
  var hargaMasukValue = selectedOption.data('harga');
  hargaMasukInput.val(hargaMasukValue);
}


 function hitung_harga() {
  // Get all elements with name 'harga_keluar[]'
  var harga_keluar_fields = document.getElementsByName('harga_keluar[]');
  
  var total = 0;

  // Iterate through all harga_keluar fields and sum up their values
  for (var i = 0; i < harga_keluar_fields.length; i++) {
      var harga_keluar_value = parseFloat(harga_keluar_fields[i].value) || 0; // Parse float, default to 0 if NaN
      total += harga_keluar_value;
  }

  // Update the value of the 'harga_total' field with the calculated total
  document.getElementById('harga_total').value = total;
}
