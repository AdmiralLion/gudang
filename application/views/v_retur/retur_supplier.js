  $(document).ready(function () {
    data_retursupplier();
    // reset_masterbarang();
    // ChangeWidth();


    function reset_masterbarang()
    {
      $('#id_barang').val('');
      $('#nama_barang').val('');
      $('#satuan_barang').val('');
      $('#jenis_barang').val('');
    }

    $("#table-1").dataTable();


    $('#tambah_retursupplier').on('click', function() {
      $('#modal_tambahretursupplier').modal('show');
    })

    $('.select2').select2({
      placeholder: 'Pilih nama supplier',
      width: "100%",
      dropdownParent: $('#modal_tambahretursupplier'),
      allowClear: true
    });

    $('.select2').select2({
      placeholder: 'tes',
      width: "100%",
      dropdownParent: $('#modal_tambahretursupplier'),
      allowClear: true
    });

    $('#tgl_transaksi').change(function (){
      data_retursupplier();
    });


    function data_retursupplier(){
      var tanggal_transaksi = $('#tgl_transaksi').val();
      // if(tanggal_transaksi == null || tanggal_transaksi == ''){
      //   var tanggal_transaksi = new Date().toJSON().slice(0, 10);
      // }
      $.ajax({
        type:"POST",
        data:{
          tanggal_transaksi:tanggal_transaksi
        },
        url: "../Transaksi/getdataretursupplier",
        cache: false,
        success : function(data){
        console.log(data);
        var html;
                var i;
                var n =0;
                    var data = $.parseJSON(data);
                    $("#table-1").DataTable().clear();

            $.each(data, function(i){


                var btn_retursupplier = '<td style="text-align:center;">'+'<a href="<?php echo base_url();?>Transaksi/print_retursupplier/'+data[i].id+'" class="btn btn-info btn-icon" target="_blank"><i class="fa fa-print"></i>'+
                '</td>';

                  n++;
                  html = [
                    n,
                    data[i].kd_retur,
                    data[i].nama_rekanan,
                    data[i].tgl,
                    btn_retursupplier
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

    $('#save_retursupplier').on('click', function() {
      var id_retur = $('#id_retur').val();
      var nama_supplier = $('#nama_supplier').val();
      var transaksi_temp = [];

      $('.form-group').each(function() {
        var nama_barang = $(this).find('#nama_barang').val();
        var harga_masuk = $(this).find('#harga_masuk').val();
        if (nama_barang != undefined && harga_masuk != undefined){
          transaksi_temp.push({
            id_retur: id_retur,
            nama_supplier: nama_supplier,
            nama_barang: nama_barang,
            harga_masuk: harga_masuk
        });
        }
        // Push values into corresponding arrays
        
    });
    console.log(transaksi_temp);
      $.ajax({
        type: 'POST',
        url: "../Transaksi/retur_supplier_act",//dilanjut besok
        data: { transaksi_temp: transaksi_temp },
        }).done(function(response) {
          
            var pesan = response.message;
            console.log(response);
            console.log(pesan);
            if (response.status === '200') {
                alert(response.message);
                data_retursupplier();
                location.reload();
            } else {
                alert(response.message);
                data_retursupplier();
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
    '<div class="col-sm-8 nopadding"><div class="form-group"> <label for="Barang">Barang :</label><br><select class="select2" style="width:100%" id="nama_barang" name="nama_barang[]" onchange="setHarga(this)">' +'<option value="">--Barang--</option>'+
                options1 +
    '</select></div></div>'+'<div class="col-sm-4 nopadding"><div class="form-group"><label for="Harga">Harga Masuk :</label><br><div class="input-group"><input type="text" placeholder="Harga" class="form-control" name="harga_masuk[]" id="harga_masuk" onchange="hitung_harga()" readonly> &nbsp; &nbsp;<div class="input-group-btn"> <button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"> <span class="fa fa-minus" aria-hidden="true"></span> </button></div></div></div></div><div class="clear"></div></div>';
    objTo.appendChild(divtest)
    $('.select2').select2({
      placeholder: '--Pilih--',
      width: "100%",
      dropdownParent: $('#modal_tambahretursupplier .modal-content'),
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


setInterval(function() {
  hitung_harga();
}, 1000);

   function hitung_harga() {
    // Get all elements with name 'harga_keluar[]'
    var harga_keluar_fields = document.getElementsByName('harga_masuk[]');
    console.log('tes');
    var total = 0;

    // Iterate through all harga_keluar fields and sum up their values
    for (var i = 0; i < harga_keluar_fields.length; i++) {
        var harga_keluar_value = parseFloat(harga_keluar_fields[i].value) || 0; // Parse float, default to 0 if NaN
        total += harga_keluar_value;
    }

    // Update the value of the 'harga_total' field with the calculated total
    document.getElementById('harga_total').value = total;
}