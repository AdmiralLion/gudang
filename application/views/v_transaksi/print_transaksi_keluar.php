<?php 
// dd($ganti_retur);
function rupiah($angka){
	
    $hasil_rupiah = "Rp " . number_format($angka,0,",",".");
    return $hasil_rupiah;
 
}

function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
        $temp = penyebut($nilai - 10). " Belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " Seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " Seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
    }     
    return $temp;
}

function terbilang($nilai) {
    if($nilai<0) {
        $hasil = "minus ". trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }     		
    return $hasil;
}

foreach ($get_barang as $row):
    $kode_transaksi = $row -> kode_transaksi;
    $tgl_transaksi = $row -> tgl_act;
    $tgl_jatuhtempo = $row -> tgl_jatuhtempo;
    $nama_pembeli = $row -> nama_pembeli;
    $jml_bayar = $row -> bayar;
    $jml_potongan = $row -> potongan;
endforeach;

foreach ($user as $row):
    $nama_user = $row -> nama_user;
endforeach;

$tglnow = date('d-m-Y H:i:s');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice for Transaction</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/bootstrap/css/bootstrap.min.css">
    <!-- Include any necessary CSS styles here -->
    <style>
        /* Define your CSS styles for the invoice */
        /* For example: */
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .header {
            display: flex;
            align-items: center;
        }
        .logo {
            width: 100px; /* Adjust the width of the logo as needed */
            margin-right: 20px; /* Adjust the spacing between logo and text */
        }
        /* Add more styles as needed */
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <img src="<?php echo base_url(); ?>assets/gudang/wheel.png" alt="Company Logo" class="logo">
            <div>
                <h1>CV ABS</h1>
                <p>Jln. Kecipik Baru Nomor 99</p>
                <p>08123456789</p>
                <!-- Add more information about the factory here -->
            </div>
        </div>
        <h5>Invoice Nomor : <?php echo $kode_transaksi; ?></h5>
        <h5>Nama Pembeli  : <?php echo $nama_pembeli; ?></h5>
        <h5>Tanggal Transaksi : <?php echo $tgl_transaksi; ?></h5>
        <h5><strong>Tanggal Jatuh Tempo : </strong><?php echo ($tgl_jatuhtempo == $tgl_transaksi) ? '-' : $tgl_jatuhtempo; ?></h5>
        <!-- Output the details of the transaction here -->
        <table class="table table-bordered">
            <tr style="text-align: center;">
                <th>No</th>
                <th>Barang</th>
                <th>Merk</th>
                <th>Tahun Barang</th>
                <th>No. Seri</th>
                <th>Kode Bulan</th>
                <th>Kode Urut</th>
                <th>Kualitas Barang</th>
                <th>Jenis Barang</th>
                <th>Pembayaran</th>
                <th style="width: 150px;">Harga</th>
            </tr>
            <!-- Loop through transaction items and display each row -->
            <?php $no = 1;
            $totalharga = 0;
            $totalhutang = 0;
            $totaltunai = 0;
            $totaltunai += $jml_bayar;
             foreach ($get_barang as $item): 
                ?>
                <tr style="text-align: center;">
                    <td><?= $no++;?></td>
                    <td><?= $item -> nama_barang;?></td>
                    <td><?= $item -> nama_merk;?></td>
                    <td><?= $item -> tahun_barang;?></td>
                    <td><?= $item -> seri_barang;?></td>
                    <td><?= $item -> kode_bulan;?></td>
                    <td><?= $item -> kode_urut;?></td>
                    <td><?= $item -> kualitas;?></td>
                    <td><?= $item -> jns_penjualan;?></td>
                    <td><?php if($item -> is_hutang == '1' AND $item -> is_retur == ''){
                                    $totalhutang += $item->harga_jual;
                                    echo 'Hutang';
                                }else if($item -> is_retur == '1'){
                                    // $totaltunai += $item->harga_jual;
                                    echo 'RETUR';
                                }else{
                                    echo 'Tunai';
                                };?>
                    </td>
                    <td>
                        <?php 
                        if($item -> is_retur == ''){
                            $totalharga += $item->harga_jual;
                            $harga_jual1 = rupiah($item -> harga_jual);
                            echo $harga_jual1;
                        }else{
                            echo '-';
                        }
                        ?></td>

                </tr>
            <?php endforeach; ?>
            <tr style="text-align: center;">
                <td colspan="11" style="background-color: aquamarine;">PENGGANTI RETUR</td>
            </tr>
            <?php 
            $noretur = 1;
            foreach($ganti_retur as $rows):
                    foreach($rows as $r): ?>
            <tr style="text-align: center;">
                <td><?= $noretur++;?></td>
                <td><?= $r -> nama_barang;?></td>
                <td><?= $r -> nama_merk;?></td>
                <td><?= $r -> tahun_barang;?></td>
                <td><?= $r -> seri_barang;?></td>
                <td><?= $r -> kode_bulan;?></td>
                <td><?= $r -> kode_urut;?></td>
                <td><?= $r -> kualitas;?></td>
                <td>RETUR</td>
                <td><?php if($r -> is_hutang == '1'){
                        $totalhutang += $r->harga_keluar;
                        echo 'Hutang';
                        } else {
                            echo 'Tunai';
                        }
                    ?></td>
                <td>
                    <?php $totalharga += $r->harga_keluar;
                        $harga_kel1 = rupiah($r -> harga_keluar);
                        echo $harga_kel1;
                    ?>
                </td>
            </tr>
            <?php endforeach; 
                endforeach;
            ?>
            <tr>
                <td colspan="7" style="padding:10px;">&nbsp;</td>
                <td colspan="4" style="padding:10px;">Total Yang Belum Dibayarkan: <?php if($totalhutang == $totaltunai){
                    $final_hutang = $totalhutang - $totaltunai;
                    $final_hutang = rupiah($final_hutang);
                    echo $final_hutang;
                }else{
                    $totalhutang = rupiah($totalhutang);
                    echo $totalhutang;
                }  ?></td>
            </tr>
            <tr>
                <td colspan="7" style="padding:10px;">&nbsp;</td>
                <td colspan="4" style="padding:10px;">Total Yang Sudah Dibayarkan: <?php
                $totaltunai = rupiah($totaltunai);
                 echo $totaltunai; ?></td>
            </tr>
            <tr>
                <td colspan="7" style="padding:10px;">&nbsp;</td>
                <td colspan="4" style="padding:10px;">Total Potongan Yang didapatkan: <?php 
                $jml_potongan1 = rupiah($jml_potongan);
                echo $jml_potongan1; ?></td>
            </tr>
            <tr>
                <td colspan="7" style="padding:10px;">&nbsp;</td>
                <td colspan="4" style="padding:10px;">Total Harga Sebelum dipotong: <?php 
                $totalharga1 = rupiah($totalharga);
                echo $totalharga1; ?></td>
            </tr>
            <tr>
                <td colspan="7" style="padding:10px;">&nbsp;</td>
                <td colspan="4" style="padding:10px;">Total Harga Sesudah dipotong: <?php
                 $finalharga = $totalharga - $jml_potongan;
                 $finalharga1 = rupiah($finalharga);
                echo $finalharga1; ?></td>
            </tr>
            <tr>
                <td colspan="7" style="padding:10px;text-align:right;">Terbilang : </td>
                <td colspan="4" style="padding:10px;"><?php
                 $finalharga2 = terbilang($finalharga);
                echo $finalharga2; ?> Rupiah</td>
            </tr>
        </table>
        <br>
        <div class="row">
            <div class="col-md-9">&nbsp;</div>
            <div class="col-md-3">Yang Mencetak <br> <?= $tglnow;?> <br> <br> <br>  <br> <?= $nama_user;?></div>
        </div>
        
        <!-- Output any additional information or totals -->

    </div>
</body>
</html>
