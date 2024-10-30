$(document).ready(function () {
  data_transaksimasuk();
  reset_fieldedit();
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

  function reset_fieldedit()
  {
    $('#id_brgedit').val('');
    $('#edit_namabrg').val('');
    $('#edit_merkbrg').val('');
    $('#edit_tahunbrg').val('');
    $('#edit_seribrg').val('');
    $('#edit_kodebln').val('');
    $('#edit_kodeurut').val('');
    $('#edit_jenisbrg').val('');
    $('#edit_hargabrg').val('');
  }

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

  $('#modal_editbrg').on('shown.bs.modal', function () {
    if (!$('#edit_namabrg').hasClass('select2-hidden-accessible')) {
        $('#edit_namabrg').select2({
            placeholder: 'Pilih nama barang',
            width: "100%",
            dropdownParent: $('#modal_editbrg .modal-content'),
            allowClear: true
        });
    }
});

$('#modal_editbrg').on('shown.bs.modal', function () {
  if (!$('#edit_merkbrg').hasClass('select2-hidden-accessible')) {
      $('#edit_merkbrg').select2({
          placeholder: 'Pilih merk barang',
          width: "100%",
          dropdownParent: $('#modal_editbrg .modal-content'),
          allowClear: true
      });
  }
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

              var btn_edittransmasuk = '<td style="text-align:center;">' +
              '<button  type="button" class="btn btn-primary btn-icon  editmasuk" data="' +
              data[i].kode_transaksi +
              '"><i class="fa fa-pen"></i></button >' +
              '</td>';

                n++;
                html = [
                  n,
                  btn_edittransmasuk,
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

  $('#data_transaksimasuk').on('click','.editmasuk', function () {
    var kode_transaksi = $(this).attr('data');
    $.ajax({
        type: 'POST',
        url: "../Transaksi/data_masukbarang",//dilanjut besok
        data: {
          kode_transaksi:kode_transaksi
        }
      }).done(function(data) {
        var n =0;
        var m =0;

        var data4 = $.parseJSON(data);
        var list_barang = data4.get_barang;
        $.each(list_barang, function(i, item) {
        
          var btn_editbrg = '<td style="text-align:center;">' +
            '<button  type="button" class="btn btn-success btn-icon edit_pilihan" data="' + item.id +
            '" >Edit</button></td>';
         
          var row_barang = '<td style="text-align:center;">' + item.nama_barang + ' - ' + item.nama_merk  + ' - ' + item.tahun_barang  + ' - ' + item.seri_barang  + ' - ' + item.kode_bulan  + ' - ' + item.kode_urut + ' - ' + item.kualitas + '</td>';
          n++;
          var html = [
              n,
              item.kode_transaksi,
              row_barang,
              item.harga_barang,
              item.tgl_transaksi,
              btn_editbrg,
          ];
        
                // Add the row to DataTables
                $("#table-2").DataTable().row.add(html);
              
              });

          $("#table-2").DataTable().draw();

      });
      $('#modal_editbrg').modal('show');
});

  $('#data_barangmsk').on('click','.edit_pilihan', function () {
    var id = $(this).attr('data');
    $.ajax({
        type: 'POST',
        url: "../Transaksi/get_databarangbyid",//dilanjut besok
        data: {
          id:id
        }
      }).done(function(data) {
        var data3 = $.parseJSON(data);
        $.each(data3, function (i) {
          $('#id_brgedit').val(data3[i].id);
          $('#edit_namabrg').val(data3[i].id_barang).trigger('change');
          $('#edit_merkbrg').val(data3[i].id_merk).trigger('change');
          $('#edit_tahunbrg').val(data3[i].tahun_barang);
          $('#edit_seribrg').val(data3[i].seri_barang);
          $('#edit_kodebln').val(data3[i].kode_bulan);
          $('#edit_kodeurut').val(data3[i].kode_urut);
          $('#edit_jenisbrg').val(data3[i].jenis_barang).trigger('change');
          $('#edit_kualitas').val(data3[i].kualitas).trigger('change');
          $('#edit_hargabrg').val(data3[i].harga_barang);
        });
      });
      $(".hidetable").removeAttr("style");
    });

$('#editdatafinal').on('click','#save_editbrg', function () {
  var id_brgedit = $('#id_brgedit').val();
  var edit_namabrg = $('#edit_namabrg').val();
  var edit_merkbrg = $('#edit_merkbrg').val();
  var edit_tahunbrg = $('#edit_tahunbrg').val();
  var edit_seribrg = $('#edit_seribrg').val();
  var edit_kodebln = $('#edit_kodebln').val();
  var edit_kodeurut = $('#edit_kodeurut').val();
  var edit_jenisbrg = $('#edit_jenisbrg').val();
  var edit_kualitas = $('#edit_kualitas').val();
  var edit_hargabrg = $('#edit_hargabrg').val();
  let text = "Anda yakin untuk Edit data barang tersebut ?";
  if (confirm(text) == true) {
    $.ajax({
      type: 'POST',
      url: "../Transaksi/save_editbrg",//dilanjut besok
      data: {
        id_brgedit:id_brgedit,
        edit_namabrg:edit_namabrg,
        edit_merkbrg:edit_merkbrg,
        edit_tahunbrg:edit_tahunbrg,
        edit_seribrg:edit_seribrg,
        edit_kodebln:edit_kodebln,
        edit_kodeurut:edit_kodeurut,
        edit_jenisbrg:edit_jenisbrg,
        edit_kualitas:edit_kualitas,
        edit_hargabrg:edit_hargabrg,
      }
    }).done(function(response) {
      console.log(response);
      var pesan = response.message;
      console.log(pesan);
      if (response.status === '200') {
        alert(response.message);
          $(".hidetable").css("display", "none");
      //   location.reload();
    } else {
        alert(response.message);
      //   location.reload();
      }
    });
      }
});

  $('#save_transaksimasuk').on('click', function() {
    var id_transaksi = $('#id_transaksi').val();
    var id_rekanan = $('#nama_rekanan').val();
    var transaksi_temp = [];
    $('#save_transaksimasuk').addClass('btn-progress');

    $('.form-group').each(function() {
      var nama_barang = $(this).find('#nama_barang').val();
      var nama_merk = $(this).find('#nama_merk').val();
      var tahun_barang = $(this).find('#tahun_barang').val();
      var seri_barang = $(this).find('#seri_barang').val();
      var kode_bulan = $(this).find('#kode_bulan').val();
      var kode_urut = $(this).find('#kode_urut').val();
      var jns_brg = $(this).find('#jns_brg').val();
      var kualitas = $(this).find('#kualitas').val();
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
          jns_brg:jns_brg,
          kualitas:kualitas,
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
              $('#save_transaksimasuk').removeClass('btn-progress');
              data_transaksimasuk();
              location.reload();
          } else {
              alert(response.message);
              $('#save_transaksimasuk').removeClass('btn-progress');
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
  '<div class="col-sm-1 nopadding"><div class="form-group"> <label for="Merk">Merk :</label><br><select class="select2" style="width:100%" id="nama_merk" name="nama_merk[]">' +'<option value="">--Merk--</option>'+
  options2 +
  '</select></div></div>'+
  '<div class="col-sm-1 nopadding"><div class="form-group"><label for="Urut">Jenis :</label> <br> <select class="select2" style="width:100%" id="jns_brg" name="jns_brg[]">' +'<option value="">Jenis barang</option>'+
'<option value="Jasa">Jasa</option>'+'<option value="Panas">Panas</option>'+'<option value="Dingin">Dingin</option>'+'<option value="Overtread">Overtread</option>'+'<option value="Afkir">Afkir</option>'+'<option value="Baru">Baru</option>'+'<option value="Bekas">Bekas</option>'+'<option value="Ori">Ori</option>'+'<option value="Tebelan">Tebelan</option>'+
'</select></div></div>'+
  '<div class="col-sm-1 nopadding"><div class="form-group"><label for="Tahun">Tahun :</label><br> <input type="text" class="form-control" id="tahun_barang" name="tahun_barang[]" value="" placeholder="Tahun"></div></div>'+
  '<div class="col-sm-1 nopadding"><div class="form-group"><label for="Seri">Seri :</label> <br> <input type="text" class="form-control" id="seri_barang" name="seri_barang[]" value="" placeholder="Seri"></div></div>'+
  '<div class="col-sm-1 nopadding"><div class="form-group"><label for="Bulan">Bulan :</label> <br> <input type="text" class="form-control" id="kode_bulan" name="kode_bulan[]" value="" placeholder="Bulan"></div></div>'+
  '<div class="col-sm-1 nopadding"><div class="form-group"><label for="Urut">Urut :</label> <br> <input type="text" class="form-control" id="kode_urut" name="kode_urut[]" value="" placeholder="Urut"></div></div>'+
  '<div class="col-sm-1 nopadding"><div class="form-group"><label for="Urut">Kualitas :</label> <br> <select class="select2" style="width:100%" id="kualitas" name="kualitas[]">' +'<option value="">Kualitas Barang</option>'+
  '<option value="AA">AA</option>'+'<option value="BB">BB</option>'+'<option value="CC">CC</option>'+'<option value="DD">DD</option>'+
  '</select></div></div>'+
  '<div class="col-sm-2 nopadding"><div class="form-group"><label for="Harga Masuk">Harga Masuk :</label> <br><div class="input-group"><input type="text" placeholder="Harga" class="form-control" name="harga_masuk[]" id="harga_masuk" onkeyup="hitung_harga()"> &nbsp; &nbsp;<div class="input-group-btn"> <button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"> <span class="fa fa-minus" aria-hidden="true"></span> </button></div></div></div></div><div class="clear"></div></div>';
  objTo.appendChild(divtest);
  // Get the current year and month
  var currentYear = new Date().getFullYear();
  var currentMonth = ("0" + (new Date().getMonth() + 1)).slice(-2); // Ensure month is two digits

  // Set the year and month to the respective fields
  divtest.querySelector("#tahun_barang").value = currentYear;
  var convertbulan = convertMonthToRoman(currentMonth);
  divtest.querySelector("#kode_bulan").value = convertbulan;

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

 function convertMonthToRoman(month) {
  var romanNumerals = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
  return romanNumerals[month - 1]; // Adjust for zero-based index
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