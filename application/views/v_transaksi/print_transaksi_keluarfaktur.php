<?php 

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

$tglnow = date('d-m-Y');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice for Transaction</title>
    <style>
        body {
            font-family: Courier, monospace;
            font-size: 12px;
        }
        .invoice-container {
            width: 100%;
            margin: 0 auto;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 10px;
        }
        .content {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
        .content td, .content th {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        .content th {
            background-color: #f2f2f2;
        }
        .content .right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <h1>CV ABS</h1>
            <p>Jln. Kecipik Baru Nomor 99</p>
            <p>08123456789</p>
        </div>
        <p><strong>Invoice Nomor :</strong> <?php echo $kode_transaksi; ?></p>
        <p><strong>Nama Pembeli :</strong> <?php echo $nama_pembeli; ?></p>
        <p><strong>Tanggal Transaksi :</strong> <?php echo $tgl_transaksi; ?></p>
        <p><strong>Tanggal Jatuh Tempo : </strong><?php echo ($tgl_jatuhtempo == $tgl_transaksi) ? '-' : $tgl_jatuhtempo; ?></p>
        <table class="content">
            <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Barang</th>
                <th style="text-align: center;">Merk</th>
                <th style="text-align: center;">No. Seri</th>
                <th style="text-align: center;">Jenis</th>
                <th style="text-align: center;">Pembayaran</th>
                <th style="text-align: center;">Harga</th>
            </tr>
            <?php 
            $no = 1;
            $totalharga = 0;
            $totalhutang = 0;
            $totaltunai = 0;
            $totaltunai += $jml_bayar;
            //  dd($get_barang);
            foreach ($get_barang as $item): 
                if ($item->is_hutang == '1') {
                    if($item -> is_retur != '1'){
                        $totalhutang += $item->harga_jual;
                        $totalharga += $item->harga_jual;
                        $pembayaran = 'Hutang';
                        $harga_jual1 = rupiah($item->harga_jual) ;
                    }else{
                        $pembayaran = 'Retur';
                        $harga_jual1 = '-';
                    }
                    
                } else {
                    // $totaltunai += $item->harga_jual;
                    $harga_jual1 = rupiah($item->harga_jual);
                    $totalharga += $item->harga_jual;
                    $pembayaran = 'Tunai';
                }
                ?>
                <tr>
                    <td style="text-align: center;"><?php echo $no++; ?></td>
                    <td style="text-align: center;"><?php echo $item->nama_barang; ?></td>
                    <td style="text-align: center;"><?php echo $item->nama_merk; ?></td>
                    <td style="text-align: center;"><?php echo $item->seri_barang; ?></td>
                    <td style="text-align: center;"><?php echo $item->jns_penjualan; ?></td>
                    <td style="text-align: center;"><?php echo $pembayaran; ?></td>
                    <td style="text-align: center;"><?php echo $harga_jual1;?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td style="text-align: center;background-color: aquamarine;" colspan="7">PENGGANTI RETUR</td>
            </tr>
 <?php 
            $noretur = 1;
            foreach($ganti_retur as $rows):
                // dd($ganti_retur);
                    foreach($rows as $r): ?>
            <tr style="text-align: center;">
                <td style="text-align: center;"><?= $noretur++;?></td>
                <td style="text-align: center;"><?= $r -> nama_barang;?></td>
                <td style="text-align: center;"><?= $r -> nama_merk;?></td>
                <td style="text-align: center;"><?= $r -> seri_barang;?></td>
                <td style="text-align: center;">RETUR</td>
                <td style="text-align: center;"><?php if($r -> is_hutang == '1'){
                        $totalhutang += $r->harga_keluar;
                        echo 'Hutang';
                        } else {
                            echo 'Tunai';
                        }
                    ?></td>
                <td style="text-align: center;">
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
                <td colspan="6" class="right">Total Yang Belum Dibayarkan:</td>
                <td style="text-align: center;"><?php
                if($totalhutang == $totaltunai){
                    $final_hutang = $totalhutang - $totaltunai;
                    $final_hutang1 = rupiah($final_hutang);
                    echo $final_hutang1;
                }else{
                    $totalhutang1 = rupiah($totalhutang);
                    echo $totalhutang1;
                } 
                 ?></td>
            </tr>
            <tr>
                <td colspan="6" class="right">Total Yang Sudah Dibayarkan:</td>
                <td style="text-align: center;"><?php
                $totaltunai1 = rupiah($totaltunai);
                echo $totaltunai1; ?></td>
            </tr>
            <tr>
                <td colspan="6" class="right">Total Harga Sebelum dipotong:</td>
                <td style="text-align: center;"><?php 
                $totalharga1 = rupiah($totalharga);
                echo $totalharga1; ?></td>
            </tr>
            <tr>
                <td colspan="6" class="right">Total Harga Sesudah dipotong:</td>
                <td style="text-align: center;"><?php $finalharga = $totalharga - $jml_potongan;
                $finalharga1 = rupiah($finalharga);
                echo $finalharga1; ?></td>
            </tr>
            <tr>
                <td colspan="6" class="right">Terbilang</td>
                <td style="text-align: center;"><?php 
                $finalharga2 = terbilang($finalharga);
                echo $finalharga2; ?> Rupiah</td>
            </tr>
            <tr>
                <td colspan="7">
                    <table>
                        <tr>
                            <td>
                                * Batas Klaim Barang Hanya 1 Kali untuk setiap barang yang dilakukan pembelian <br>
                                * Batas Klaim tidak boleh melebihi tanggal maksimal klaim barang <br>
                                * Pelunasan pembayaran tidak boleh melebihi tanggal jatuh tempo
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <table style="width: 100%;">
            <tr>
                <td style="text-align: center;padding:20px;width:17%">
                    Penerima
                </td>
                <td style="text-align: center;padding:20px;width:17%">
                    Pengirim
                </td>
                <td style="text-align: center;padding:20px;width:17%">
                    Administrasi
                </td>
                <td style="text-align: center;padding:20px;width:17%">
                    &nbsp;
                </td>
                <td style="text-align: center;padding:20px;">
                    <p>Dicetak tanggal: <?php echo $tglnow; ?></p>
                </td>
            </tr>
            <tr>
                <td style="padding: 20px;"><br><br><br></td>
                <td style="padding: 20px;"><br><br><br></td>
                <td style="padding: 20px;"><br><br><br></td>
                <td style="padding: 20px;"><br><br><br></td>
                <td style="padding: 20px;"><br><br><br></td>
            </tr>
            <tr>
                <td style="padding: 20px;"><hr></td>
                <td style="padding: 20px;"><hr></td>
                <td style="padding: 20px;"><hr></td>
                <td style="padding: 20px;">&nbsp;</td>
                <td style="text-align: center;"></td>
            </tr>
        </table>

    </div>
</body>
</html>
