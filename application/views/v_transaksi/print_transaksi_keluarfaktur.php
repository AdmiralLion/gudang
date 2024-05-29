<?php 

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
                <th style="text-align: center;">Tahun</th>
                <th style="text-align: center;">No. Seri</th>
                <th style="text-align: center;">Kode Bulan</th>
                <th style="text-align: center;">Kode Urut</th>
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
            foreach ($get_barang as $item): 
                $totalharga += $item->harga_jual;
                if ($item->is_hutang == '1') {
                    $totalhutang += $item->harga_jual;
                    $pembayaran = 'Hutang';
                } else {
                    $totaltunai += $item->harga_jual;
                    $pembayaran = 'Tunai';
                }
                ?>
                <tr>
                    <td style="text-align: center;"><?php echo $no++; ?></td>
                    <td style="text-align: center;"><?php echo $item->nama_barang; ?></td>
                    <td style="text-align: center;"><?php echo $item->nama_merk; ?></td>
                    <td style="text-align: center;"><?php echo $item->tahun_barang; ?></td>
                    <td style="text-align: center;"><?php echo $item->seri_barang; ?></td>
                    <td style="text-align: center;"><?php echo $item->kode_bulan; ?></td>
                    <td style="text-align: center;"><?php echo $item->kode_urut; ?></td>
                    <td style="text-align: center;"><?php echo $item->jns_penjualan; ?></td>
                    <td style="text-align: center;"><?php echo $pembayaran; ?></td>
                    <td style="text-align: center;">Rp. <?php echo $item->harga_jual; ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="9" class="right">Total Yang Belum Dibayarkan:</td>
                <td style="text-align: center;">Rp. <?php $final_hutang = $totalhutang - $totaltunai;
                echo $final_hutang; ?></td>
            </tr>
            <tr>
                <td colspan="9" class="right">Total Yang Sudah Dibayarkan:</td>
                <td style="text-align: center;">Rp. <?php echo $totaltunai; ?></td>
            </tr>
            <tr>
                <td colspan="9" class="right">Total Harga Sebelum dipotong:</td>
                <td style="text-align: center;">Rp. <?php echo $totalharga; ?></td>
            </tr>
            <tr>
                <td colspan="9" class="right">Total Harga Sesudah dipotong:</td>
                <td style="text-align: center;">Rp. <?php $finalharga = $totalharga - $jml_potongan;
                echo $finalharga; ?></td>
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
                    Yang Mencetak
                    <br>
                    <p>Tanggal Cetak: <?php echo $tglnow; ?></p>
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
                <td style="text-align: center;"><?= $nama_user;?></td>
            </tr>
        </table>

    </div>
</body>
</html>
