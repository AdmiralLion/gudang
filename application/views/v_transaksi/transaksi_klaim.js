$(document).ready(function () {
  data_transaksiklaim();
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



  $('#modal_klaim').on('shown.bs.modal', function () {
    if (!$('#pil_brgtukar').hasClass('select2-hidden-accessible')) {
        $('#pil_brgtukar').select2({
            placeholder: 'Pilih nama barang',
            width: "100%",
            dropdownParent: $('#modal_klaim .modal-content'),
            allowClear: true
        });
    }
});

  $('#tgl_transaksi').change(function (){
    data_transaksiklaim();
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

  function data_transaksiklaim(){
    var tanggal_transaksi = $('#tgl_transaksi').val();
    // if(tanggal_transaksi == null || tanggal_transaksi == ''){
    //   var tanggal_transaksi = new Date().toJSON().slice(0, 10);
    // }
    $.ajax({
      type:"POST",
      data:{
        tanggal_transaksi:tanggal_transaksi
      },
      url: "../Transaksi/getdataklaim",
      cache: false,
      success : function(data){
      console.log(data);
      var html;
              var i;
              var n =0;
                  var data2 = $.parseJSON(data);
                  var alldata = data2.alldata;
                  $("#table-1").DataTable().clear();

          $.each(alldata, function(i){


            var btn_klaim =
            '<td style="text-align:center;">' +
            '<button  type="button" class="btn btn-primary btn-icon  klaim_brg" data="' +
            alldata[i].kode_transaksi +
            '"><i class="fa fa-paper-plane"></i></button >' +
            '</td>';

                n++;
                html = [
                  n,
                  alldata[i].kode_transaksi,
                  alldata[i].nama_pembeli,
                  alldata[i].tgl,
                  alldata[i].tgl_batasklaim,
                  btn_klaim
                ];
        
                // Add the row to DataTables
                $("#table-1").DataTable().row.add(html);
              
              });
                  
          $("#table-1").DataTable().draw();

            }
      });
  }

  $('#data_transaksiklaim').on('click','.klaim_brg', function () {
    var kode_transaksi = $(this).attr('data');
    $.ajax({
        type: 'POST',
        url: "../Transaksi/data_klaim",//dilanjut besok
        data: {
          kode_transaksi:kode_transaksi
        }
      }).done(function(data) {
        var n =0;
        var m =0;

        var data4 = $.parseJSON(data);
        var listData = data4.list_data;
        var historiKlaim = data4.histori_klaim;
        console.log(historiKlaim);

        // Accessing individual elements from 'bayar'
        var kodeTransaksi = listData.kode_transaksi;
        // Use the retrieved values as needed
        $('#kode_transaksi').val(kodeTransaksi);
        $.each(listData, function(i, item) {
          $('#nama_pembeli').val(item.nama_pembeli);
          console.log(item.is_klaim);
          if(item.is_retur == 1){
            var btn_retur = '<td style="text-align:center;">' +
              '<button  type="button" class="btn btn-success btn-icon ">Sudah Retur</button >' +
            '</td>';
          }else{
            var btn_retur =  '<td style="text-align:center;">' +
              '<button  type="button" class="btn btn-danger btn-icon ">Tidak Retur</button >' +
            '</td>';
          }
          if(item.is_klaim == 1){
            var btn_klaimcek = '<td style="text-align:center;">' +
              '<button  type="button" class="btn btn-success btn-icon ">Sudah Klaim</button >' +
            '</td>';
            var btn_klaim = '<td style="text-align:center;">' +
            '<button  type="button" class="btn btn-success btn-icon" disabled>Sudah Ganti</button >' +
          '</td>';
          }else if(item.is_klaim == 2){
            var btn_klaimcek =  '<td style="text-align:center;">' +
              '<button  type="button" class="btn btn-info btn-icon "> Barang Ganti Klaim</button >' +
            '</td>';
            var btn_klaim = '<td style="text-align:center;">' +
            '<button  type="button" class="btn btn-success btn-icon disabled">Sudah Ganti</button >' +
          '</td>';
          }else{
            var btn_klaimcek =  '<td style="text-align:center;">' +
              '<button  type="button" class="btn btn-danger btn-icon ">Belum Klaim</button >' +
            '</td>';
            var btn_klaim = '<td style="text-align:center;">' +
            '<button  type="button" class="btn btn-success btn-icon btn_klaimbrg" data="' +
            item.kode_transaksi +'" data-id="' +
            item.id_keluar +'">GANTI!!!</button >' +
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
              btn_klaimcek,
              item.harga_jual,
              btn_klaim
          ];
        
                // Add the row to DataTables
                $("#table-2").DataTable().row.add(html);
              
              });

        $.each(historiKlaim, function(i, item) {
          m++;
          var row_baranglama = '<td style="text-align:center;">' + item.nama_barang1 + ' - ' + item.nama_merk1  + ' - ' + item.tahun_barang1  + ' - ' + item.seri_barang1  + ' - ' + item.kode_bulan1  + ' - ' + item.kode_urut1 + '</td>';
          var row_barangganti = '<td style="text-align:center;">' + item.nama_barang2 + ' - ' + item.nama_merk2  + ' - ' + item.tahun_barang2  + ' - ' + item.seri_barang2  + ' - ' + item.kode_bulan2  + ' - ' + item.kode_urut2 + '</td>';
          var html2 = '<tr>'
          +'<td style="text-align:center;">' + m + '</td>'
            +'<td style="text-align:center;">' + item.kode_klaim + '</td>'
            +'<td style="text-align:center;">' + item.kode_transaksi + '</td>'
            +row_baranglama
            +row_barangganti
            +'<td style="text-align:center;">' + item.nama_user + '</td>'
            +'<td style="text-align:center;">' + item.tgl + '</td>'
            + '</tr>';

            $('#histori_klaim').append(html2);

                // Add the row to DataTables
              
              });
                  
          $("#table-2").DataTable().draw();

      });
      $('#modal_klaim').modal('show');
});

$('#data_klaimgar').on('click','.btn_klaimbrg', function () {
  $('#id_barangkeluar').val('');
  $('#kd_trans').val('');
  var kode_transaksi = $(this).attr('data');
  var id_brg_keluar = $(this).attr('data-id');
  $('#id_barangkeluar').val(id_brg_keluar);
  $('#kd_trans').val(kode_transaksi);
  $("#hide_klaim").removeAttr("style");
});

  $('#save_klaimgar').on('click', function() {
    let text = "Anda yakin untuk Klaim barang tersebut sudah sesuai ?";
    if (confirm(text) == true) {
      var id_baranglama = $('#id_barangkeluar').val();
      var kd_trans = $('#kd_trans').val();
      var pil_brgtukar = $('#pil_brgtukar').val();
      var alasan_klaim = $('#alasan_klaim').val();
      var nama_pembeli = $('#nama_pembeli').val();

      $('#save_klaimgar').addClass('btn-progress');

      $.ajax({
        type: 'POST',
        url: "../Transaksi/klaim_barang_act",//dilanjut besok
        data: { 
          id_baranglama: id_baranglama,
          kd_trans: kd_trans, 
          pil_brgtukar: pil_brgtukar,
          alasan_klaim: alasan_klaim,
          nama_pembeli: nama_pembeli
        },
        }).done(function(response) {
          
            var pesan = response.message;
            console.log(response);
            console.log(pesan);
            if (response.status === '200') {
                alert(response.message);
                $('#save_klaimgar').removeClass('btn-progress');
                location.reload();
            } else {
                alert(response.message);
                $('#save_klaimgar').removeClass('btn-progress');
                location.reload();
                return false;
            }
            throttled = false;
        });
      }
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
  // $('.select2').select2({
  //   placeholder: '--Pilih--',
  //   width: "100%",
  //   dropdownParent: $('#modal_tambahtransaksikeluar .modal-content'),
  //   allowClear: true
  // });
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
