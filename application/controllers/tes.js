$(document).ready(function() {

    data_formrekon();
    reset_prabedah();

    function reset_prabedah()
    {
        
        // $('#textdiagnosis').val('');
        // $('#texttindakan').val('');
        $('#diagnosis').val('');
        $('#tindakan_ops').val('');
        // $('#textdiagnosis').val('');
        // $('#texttindakan').val('');
        $('#lokalis').val('');
        $('#durasi').val('');
        $('#urgensi').val('');
        $('#urgensilain').val('');
        $('#implan').val('');
        $('#adaimplan').val('');
        // $('#adaobat').val('');
        $('#makanan').val('');
        $('#adamakanan').val('');
        // $('#gcs').val('');
        // $('#tekanan_darah').val('');
        // $('#nadi').val('');
        // $('#suhu').val('');
        // $('#rr').val('');
        // $('#tinggi').val('');
        // $('#berat').val('');
        $('#nyeri').val('');
        $('#makan_minum').val('');
        $('#radiologi').val('');
        // $('#adaradiologi').val('');
        $('#laboratorium').val('');
        // $('#adalaboratorium').val('');
        $('#pers_darah').val('');
        $('#wb_val').val('');
        $('#prc_val').val('');
        $('#tc_val').val('');
        $('#ffp_val').val('');
        $('#darah_lain2').val('');

    }
    $('#form_rekon_obat').on('click',function(){
      $('#modal_rekon_obat').modal('show');
    }); 
    


    $('#urgensi').on("change", function () {
		var urgensi = $('#urgensi').val();
        if(urgensi == 'Lain-Lain'){
            $("#urgensilain").removeAttr("style");
        }else{
            $("#urgensilain").attr("style", "display: none;");
        }
    })

    $('#implan').on("change", function () {
		var implan = $('#implan').val();
        if(implan == 'Ada Jenis Implan'){
            $("#adaimplan").removeAttr("style");
        }else{
            $("#adaimplan").attr("style", "display: none;");
        }
    })

    $('#obat').on("change", function () {
		var obat = $('#obat').val();
        if(obat == 'Ada'){
            $("#adaobat").removeAttr("style");
        }else{
            $("#adaobat").attr("style", "display: none;");
        }
    })

    $('#makanan').on("change", function () {
		var makanan = $('#makanan').val();
        if(makanan == 'Ada'){
            $("#adamakanan").removeAttr("style");
        }else{
            $("#adamakanan").attr("style", "display: none;");
        }
    })

    $('#radiologi').on("change", function () {
		var radiologi = $('#radiologi').val();
        if(radiologi == 'Ada'){
            $("#adaradiologi").removeAttr("style");
        }else{
            $("#adaradiologi").attr("style", "display: none;");
        }
    })

    $('.pers_darah').on("change", function () {
		var persiapan_darah = $('.pers_darah').val();
        if(persiapan_darah == 'Ada'){
            $("#bungkusdarah").removeAttr("style");
        }else{
            $("#bungkusdarah").attr("style", "display: none;");
        }
    })

    $('#laboratorium').on("change", function () {
		var laboratorium = $('#laboratorium').val();
        if(laboratorium == 'Ada'){
            $("#adalaboratorium").removeAttr("style");
        }else{
            $("#adalaboratorium").attr("style", "display: none;");
        }
    })

    $("#diagnosis").select2({ placeholder: "Pilih Diagnosa",
        dropdownParent: $("#modal_prabedah"),
        width: "100%"
        });

    $("#tindakan_ops").select2({ placeholder: "Pilih Rencana Tindakan Operasi",
        dropdownParent: $("#modal_prabedah"),
        width: "100%"
        });

    // $('#diagnosis').on("change", function () {
    //         var nama_diag = $('#diagnosis').val();
    //         $("#textdiagnosis").val(nama_diag);
    // })

    // $('#tindakan_ops').on("change", function () {
    //         var nama_tind = $('#tindakan_ops').val();
    //         $("#texttindakan").val(nama_tind);
    // })


    var throttled = false;
    
   $('#save_rekon_obat').on('click', function() {
        if (!throttled) {
            throttled = true;
            var id_rekon_obat = $('#id_rekon_obat').val();
            var user_act = $('#user_act').val();
            var pelayanan_id = $('#pelayanan_id').val();
            var kunjungan_id = $('#kunjungan_id').val();
            var pasien_id = $('#pasien_id').val();
            var petugas_input_ERM = $('#petugas_input_ERM').val();
            // var obatArrayJson = $('#obat_array').val();
            var id_urut_obat = $('#id_urut_obat').val();
            var obatArray = [];

            $("#table_obat tr").each(function(index, row) {
                var id = $(row).find('input[name^="id_obat"]').val();
                var namaObat = $(row).find('input[name^="nama_obat"]').val();
                
                // Check if any field is empty in the current row
                if (id || namaObat) {
                    var nama_barang = $(this).find('#nama_barang').val();
                    var nama_merk = $(this).find('#nama_merk').val();
                    var tahun_barang = $(this).find('#tahun_barang').val();
                    var seri_barang = $(this).find('#seri_barang').val();
                    var kode_bulan = $(this).find('#kode_bulan').val();
                    var kode_urut = $(this).find('#kode_urut').val();
                    var harga_masuk = $(this).find('#harga_masuk').val();
            
                    obatArray.push({
                        id: id_urut_obat,
                        no_obat: id,
                        nama_obat: namaObat,
                        komposisi_obat: komposisiObat,
                        dosis_frekuensi: dosisFrekuensi,
                        rute: rute,
                        tgl_penggunaanobat: tglPenggunaanObat,
                        lanjut_obat: lanjutObat,
                        keterangan_obat: keteranganObat
                    });
                }
            });
            
            // console.log(obatArray);
            var obatArrayJson = JSON.stringify(obatArray);


            $.ajax({
                type: 'POST',
                url: "../rme_rj/rekonsiliasi_obat_act",//dilanjut besok
                data: {
                    id_rekon_obat:id_rekon_obat,
                    user_act:user_act,
                    pelayanan_id:pelayanan_id,
                    kunjungan_id:kunjungan_id,
                    pasien_id:pasien_id,
                    petugas_input_ERM:petugas_input_ERM,
                    obatArray:obatArray
                }
            }).done(function(data) {
                console.log(data);
                if(data==1){
                 alert('DATA  Berhasil disimpan');
                 location.reload();
               }else if (data==2){
                 alert('DATA  Berhasil disimpan');
                 location.reload();
               }else{
                 alert('Data Gagal disimpan');
                //  data_assesmen_edukasi();
                 return false
                }
                throttled = false;
                });
            }  
    })

    function data_formrekon(){
            var kunjungan_id = $('#kunjungan_id').val();
            $.ajax({
                type:"POST",
                url: "../rme_rj/getdatarekonobat",
                data : {kunjungan_id},
                    cache: false,
                    success : function(data){
                    console.log(data);
                    var html;
                            var i;
                            var n =0;
                                var data = $.parseJSON(data);
                    $.each(data, function(i){
                        $("#tab_profil1").attr("style", "background-color: #00FFFF;");
                        var btn_rekonobat = '<td style="text-align:center;">'+
                        '<button  type="button" class="btn btn-primary btn-sm  rekonobat_edit" data="'+data[i].id+'"><i class="fa fa-pencil"></i></button >'+''
                        +'<button type="button" class="btn btn-danger btn-sm  rekonobat_hapus"  data="'+data[i].id+'"><i class="fa fa-trash"></i></button> </br>'+
                        '</td>';
                        var btn_print_rekonobat = '<td style="text-align:center;">'+'<a href="<?= base_url()?>rme_rj/cetakRekonObat?id='+data[i].id+'&kunjungan_id='+data[i].kunjungan_id+'&pelayanan_id='+data[i].pelayanan_id+'&pasien_id='+data[i].pasien_id+'" target="_blank" class="btn btn-success btn-sm" ><i class="fa fa-print"></i>&nbsp;&nbsp;&nbsp;Print Rekonsiliasi Obat</a>'+'</td>';
                        if(data[i].id){
                                n++;
                                html += '<tr>'+
                            '<td>'+n+'</td>'+
                                    btn_rekonobat+
                                            '<td style="text-align:center;">'+data[i].petugas_input_ERM+'</td>'+
                                            '<td style="text-align:center;">'+data[i].tgl_act+'</td>'+
                                            btn_print_rekonobat+
                                            '</tr>';
                                        // menambahkan untuk ttd dan print
                                   
                        }else{
                            $("#tab_profil1").removeAttr("style");
                            }
                        });
                            
                    $('.data_rekon_obat').html(html);
                }
            });
        }

        $('#data_rekon_obat').on('click','.rekonobat_edit',function(){
            var id=$(this).attr('data');
               $.ajax({
                type:"POST",
                url: "../rme_rj/getdataeditrekonobat",
                data : {id:id
                    },
                    cache: false,
                success : function(data3){
                  var data3 = $.parseJSON(data3);
                  console.log(data3);
                $.each(data3, function(i,item){  
                    editRow(item);
                    var implan = data3[i].implan;
                    var urgensi = data3[i].urgensi_op;
                    var obat = data3[i].alergi_obat;
                    var makanan = data3[i].alergi_makanan;
                    $('#diagnosis').val(data3[i].diagnosis);
                    $('#textdiagnosis').val(data3[i].diagnosis);
                    $('#tindakan_ops').val(data3[i].tindakan);
                    $('#texttindakan').val(data3[i].tindakan);
                    $("#lokalis").val(data3[i].status_lok);
                    $("#durasi").val(data3[i].durasi);
                    $("#urgensi").val(data3[i].urgensi_op);
                    });
                        $('#modal_rekon_obat').modal('show');
                    }
               })
            })

            $('#data_rekon_obat').on('click','.rekonobat_hapus',function(){
                var id=$(this).attr('data');
                var table='rekonsiliasi_obat';
                var table2 = 'list_obat';
                if (confirm('Apakah anda yakin menghapus data Rekonsiliasi Obat ?')) {
                         $.ajax({
                           type:"POST",
                           url: "../rme_rj/hps_act_rekonobat",
                           data : {id:id,
                                   table:table,
                                   table2:table2   
                           },
                           success : function(data1){
                             console.log(data1);
                             if(data1==1){
                               alert('Data Rekonsiliasi obat dihapus');
                            //    reset_prabedah();
                            //    data_assprabedah();
                               location.reload();    
                             }else{
                               alert('Data Rekonsiliasi obat gagal dihapus');
                            //    reset_prabedah();
                            //    data_assprabedah();
                               location.reload();
                             }
                             
                           }
                         }); 
                        }
                  }); 

})

function addNewRow(){
    var table = document.getElementById("table_obat");
    var rowCount = table.rows.length;
    var cellCount = table.rows[0].cells.length; 
    var row = table.insertRow(rowCount);
    
    // for (var n = 0; n< rowCount; n++){
    //     id_obat1++;
    // }
    for(var i =0; i < cellCount; i++){
        var cell = row.insertCell(i);
        if(i == 0){
            cell.innerHTML='<input class="form-control" type="text" name="id_obat['+rowCount+']" id="id_obat['+rowCount+']" value="'+rowCount+'" readonly/>';

        }else if(i == 1){
            cell.innerHTML='<input class="form-control" type="text" name="nama_obat['+rowCount+']" id="nama_obat['+rowCount+']" />';

        }else if(i == 2){
            cell.innerHTML='<input class="form-control" type="text" name="komposisi_obat['+rowCount+']" id="komposisi_obat['+rowCount+']">';

        }else if(i == 3){
            cell.innerHTML='<input class="form-control" type="text" name="dosis_frekuensi['+rowCount+']" id="dosis_frekuensi['+rowCount+']">';

        }else if(i == 4){
            cell.innerHTML='<input class="form-control" type="text" name="rute['+rowCount+']" id="rute['+rowCount+']">';

        }else if(i == 5){
            cell.innerHTML='<input class="form-control tgl_obat" type="text" id="tgl_penggunaanobat['+rowCount+']" name="tgl_penggunaanobat['+rowCount+']">';

        }else if(i == 6){
            cell.innerHTML='<select class="form-control" name="lanjut_obat['+rowCount+']" id="lanjut_obat['+rowCount+']"><option value="">--Lanjut Atau Tidak--</option><option value="Iya">Iya</option><option value="Tidak">Tidak</option></select>';        
        }else if(i == 7){
            cell.innerHTML='<textarea class="form-control" name="keterangan_obat['+rowCount+']" id="keterangan_obat['+rowCount+']"></textarea>';
        }else{
            cell.innerHTML = '<button class="btn btn-danger" '
            +'onclick="deleteRow(this)" />'+'<i class="fa fa-trash"></i>';
        }
        
        rowCount++;
    }
    $('.tgl_obat').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        minDate: '2000-01-01',
        minuteStep: 1
    });
}

function editRow(data) {
    var table = document.getElementById("table_obat");
    var rowCount = table.rows.length;
    var cellCount = table.rows[0].cells.length;
    var row = table.insertRow(rowCount);

    for (var i = 0; i < cellCount; i++) {
        var cell = row.insertCell(i);
        if (i == 0) {
            cell.innerHTML = '<input class="form-control" type="text" name="id_obat[' + rowCount + ']" id="id_obat[' + rowCount + ']" value="' + rowCount + '" readonly />';
        } else if (i == 1) {
            cell.innerHTML = '<input class="form-control" type="text" name="nama_obat[' + rowCount + ']" id="nama_obat[' + rowCount + ']" value="' + (data.nama_obat || '') + '" />';
        } else if (i == 2) {
            cell.innerHTML = '<input class="form-control" type="text" name="komposisi_obat[' + rowCount + ']" id="komposisi_obat[' + rowCount + ']" value="' + (data.komposisi_obat || '') + '" />';
        } else if (i == 3) {
            cell.innerHTML = '<input class="form-control" type="text" name="dosis_frekuensi[' + rowCount + ']" id="dosis_frekuensi[' + rowCount + ']" value="' + (data.dosis_frekuensi || '') + '" />';
        } else if (i == 4) {
            cell.innerHTML = '<input class="form-control" type="text" name="rute[' + rowCount + ']" id="rute[' + rowCount + ']" value="' + (data.rute || '') + '" />';
        } else if (i == 5) {
            cell.innerHTML = '<input class="form-control tgl_obat" type="text" id="tgl_penggunaanobat[' + rowCount + ']" name="tgl_penggunaanobat[' + rowCount + ']" value="' + (data.tgl_penggunaanobat || '') + '" />';
        } else if (i == 6) {
            var select = document.createElement('select');
            select.className = 'form-control';
            select.name = 'lanjut_obat[' + rowCount + ']';
            select.id = 'lanjut_obat[' + rowCount + ']';

            var lanjutOptions = ['', 'Iya', 'Tidak'];
            for (var j = 0; j < lanjutOptions.length; j++) {
                var option = document.createElement('option');
                option.value = lanjutOptions[j];
                option.text = lanjutOptions[j];
                if (data.lanjut_obat && data.lanjut_obat === lanjutOptions[j]) {
                    option.selected = true;
                }
                select.appendChild(option);
            }

            cell.appendChild(select);
        } else if (i == 7) {
            cell.innerHTML = '<textarea class="form-control" name="keterangan_obat[' + rowCount + ']" id="keterangan_obat[' + rowCount + ']">' + (data.keterangan_obat || '') + '</textarea>';
        } else {
            cell.innerHTML = '<button class="btn btn-danger" onclick="deleteRow(this)"><i class="fa fa-trash"></i></button>';
        }

        rowCount++;
    }

    $('.tgl_obat').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        minDate: '2000-01-01',
        minuteStep: 1
    });
}


/* This method will delete a row */
function deleteRow(ele){
    var table = document.getElementById('table_obat');
    var rowCount = table.rows.length;
    if(rowCount <= 1){
        alert("There is no row available to delete!");
        return;
    }
    if(ele){
        //delete specific row
        ele.parentNode.parentNode.remove();
    }else{
        //delete last row
        table.deleteRow(rowCount-1);
    }
}

// function addRows(){ 
// 	var table = document.getElementById('table_obat');
// 	var rowCount = table.rows.length;
// 	var cellCount = table.rows[0].cells.length; 
// 	var row = table.insertRow(rowCount);
// 	for(var i =0; i <= cellCount; i++){
// 		var cell = 'cell'+i;
// 		cell = row.insertCell(i);
// 		var copycel = document.getElementById('col'+i).innerHTML;
// 		cell.innerHTML=copycel;
// 	}
// }
// function deleteRows(){
// 	var table = document.getElementById('table_obat');
// 	var rowCount = table.rows.length;
// 	if(rowCount > '2'){
// 		var row = table.deleteRow(rowCount-1);
// 		rowCount--;
// 	}
// 	else{
// 		alert('There should be atleast one row');
// 	}
// }
