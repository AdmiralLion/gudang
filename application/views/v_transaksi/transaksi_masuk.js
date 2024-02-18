  $(document).ready(function () {
    data_transaksimasuk();
    reset_masterbarang();
    // ChangeWidth();


    function reset_masterbarang()
    {
      $('#id_barang').val('');
      $('#nama_barang').val('');
      $('#satuan_barang').val('');
      $('#jenis_barang').val('');
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
    function data_transaksimasuk(){
      $.ajax({
        type:"POST",
        url: "../Master/getdatatransaksimasuk",
        cache: false,
        success : function(data){
        console.log(data);
        var html;
                var i;
                var n =0;
                    var data = $.parseJSON(data);
                    $("#table-1").DataTable().clear();

            $.each(data, function(i){

                var btn_transaksimasuk = '<td style="text-align:center;">'+
                '<button  type="button" class="btn btn-primary btn-icon  masuk_edit" data="'+data[i].id+'"><i class="fa fa-pen"></i></button >'+
                '</td>';

                var btn_transaksimasuk = '<td style="text-align:center;">'+'<a href="print_transaksimasuk.php/'+data[i].id+'" class="btn btn-info btn-icon"><i class="fa fa-print"></i>'+
                '</td>';

                  n++;
                  html = [
                    n,
                    btn_transaksimasuk,
                    data[i].kode_transaksi,
                    data[i].nama_rekanan,
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
    divtest.innerHTML = '<div class="row"><div class="col-sm-3 nopadding"><div class="form-group"> <input type="text" class="form-control" id="Schoolname" name="Schoolname[]" value="" placeholder="School name"></div></div><div class="col-sm-3 nopadding"><div class="form-group"> <input type="text" class="form-control" id="Major" name="Major[]" value="" placeholder="Major"></div></div><div class="col-sm-3 nopadding"><div class="form-group"> <input type="text" class="form-control" id="Degree" name="Degree[]" value="" placeholder="Degree"></div></div><div class="col-sm-1 nopadding"><div class="form-group"><div class="input-group"> <select class="form-control" id="educationDate" name="educationDate[]"><option value="">Date</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option> </select></div></div></div><div class="col-sm-2 nopadding"><div class="form-group"><div class="input-group"><input type="text" placeholder="Harga" class="form-control" name="harga_masuk[]" id="harga_masuk"> &nbsp; &nbsp;<div class="input-group-btn"> <button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"> <span class="fa fa-minus" aria-hidden="true"></span> </button></div></div></div></div><div class="clear"></div></div>';
    
    objTo.appendChild(divtest)
}
   function remove_education_fields(rid) {
     $('.removeclass'+rid).remove();
   }