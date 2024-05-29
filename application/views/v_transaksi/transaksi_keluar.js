$(document).ready(function () {
  data_transaksikeluar();
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
    data_transaksikeluar();
  });


  function data_transaksikeluar(){
    var tanggal_transaksi = $('#tgl_transaksi').val();
    // if(tanggal_transaksi == null || tanggal_transaksi == ''){
    //   var tanggal_transaksi = new Date().toJSON().slice(0, 10);
    // }
    $.ajax({
      type:"POST",
      data:{
        tanggal_transaksi:tanggal_transaksi
      },
      url: "../Transaksi/getdatatransaksikeluar",
      cache: false,
      success : function(data){
      console.log(data);
      var html;
              var i;
              var n =0;
                  var data = $.parseJSON(data);
                  $("#table-1").DataTable().clear();

          $.each(data, function(i){


              var btn_transaksikeluar = '<td style="text-align:center;">'+'<a href="<?php echo base_url();?>Transaksi/print_transaksikeluar/'+data[i].id+'" class="btn btn-info btn-icon" target="_blank"><i class="fa fa-print"></i></a>&nbsp;&nbsp;'+'<a href="<?php echo base_url();?>Transaksi/print_transaksikeluarfaktur/'+data[i].id+'" class="btn btn-success btn-icon" target="_blank"><i class="fa fa-print"></i></a>'+
              '</td>';
              // var btn_transaksikeluarfaktur = '<td style="text-align:center;">'+'<a href="<?php echo base_url();?>Transaksi/print_transaksikeluarfaktur/'+data[i].id+'" class="btn btn-success btn-icon" target="_blank"><i class="fa fa-print"></i>'+
              // '</td>';

                n++;
                html = [
                  n,
                  data[i].kode_transaksi,
                  data[i].nama_pembeli,
                  data[i].tgl,
                  btn_transaksikeluar
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

  $('#save_transaksikeluar').on('click', function() {
    var id_transaksi = $('#id_transaksi').val();
    var nama_rekanan = $('#nama_rekanan').val();
    var jatuh_tempo = $('#jatuh_tempo').val();
    var jumlah_bayar = $('#jumlah_bayar').val();
    if((jumlah_bayar == '' || jumlah_bayar.length == 0) && (nama_rekanan == '' || nama_rekanan.length == 0) ){
      alert("Nama rekanan dan jumlah pembayaran tidak boleh kosong !!!!");
      return false;
    }
    var transaksi_temp = [];
    $('#save_transaksikeluar').addClass('btn-progress');

    $('.form-group').each(function() {
      var nama_barang = $(this).find('#nama_barang').val();
      var harga_keluar = $(this).find('#harga_keluar').val();
      var hutang = $(this).find('#hutang').val();
      var jns_brg = $(this).find('#jns_brg').val();

      console.log(nama_barang);
      console.log(harga_keluar);
      if (nama_barang != undefined && harga_keluar != undefined){
        transaksi_temp.push({
          id_transaksi: id_transaksi,
          nama_rekanan: nama_rekanan,
          jatuh_tempo:jatuh_tempo,
          jumlah_bayar:jumlah_bayar,
          nama_barang: nama_barang,
          hutang: hutang,
          jns_brg: jns_brg,
          harga_keluar: harga_keluar
      });
      }
      // Push values into corresponding arrays
      
  });
console.log(transaksi_temp);
    $.ajax({
      type: 'POST',
      url: "../Transaksi/transaksi_keluar_act",//dilanjut besok
      data: { transaksi_temp: transaksi_temp },
      }).done(function(response) {
        
          var pesan = response.message;
          console.log(response);
          console.log(pesan);
          if (response.status === '200') {
              alert(response.message);
              $('#save_transaksikeluar').removeClass('btn-progress');
              data_transaksikeluar();
              location.reload();
          } else {
              alert(response.message);
              $('#save_transaksikeluar').removeClass('btn-progress');
              data_transaksikeluar();
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
  '<div class="col-sm-4 nopadding"><div class="form-group"> <label for="Barang">Barang :</label><br><select class="select2" style="width:100%" id="nama_barang" name="nama_barang[]" onchange="setHarga(this)">' +'<option value="">--Barang--</option>'+
              options1 +
  '</select></div></div>'+'<div class="col-sm-2 nopadding"><div class="form-group"><label for="Harga">Harga Masuk :</label><br><div class="input-group"><input type="text" placeholder="Harga" class="form-control" name="harga_masuk[]" id="harga_masuk" readonly></div></div></div>'+
  '<div class="col-sm-2 nopadding"><div class="form-group"><label for="Urut">Hutang :</label> <br> <select class="select2" style="width:100%" id="hutang" name="hutang[]">' +'<option value="">Hutang</option>'+
  '<option value="Tidak">Tidak</option>'+'<option value="Iya">Iya</option>'+
  '</select></div></div>'+
  '<div class="col-sm-2 nopadding"><div class="form-group"><label for="Urut">Jenis Barang :</label> <br> <select class="select2" style="width:100%" id="jns_brg" name="jns_brg[]">' +'<option value="">Jenis barang</option>'+
  '<option value="Jasa">Jasa</option>'+'<option value="Panas">Panas</option>'+'<option value="Dingin">Dingin</option>'+'<option value="Overtreat">Overtreat</option>'+
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