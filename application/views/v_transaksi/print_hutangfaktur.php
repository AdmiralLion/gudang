<?php 

foreach ($get_barang as $row):
    $kode_transaksi = $row -> kode_transaksi;
    $kode_hutang = $row -> kode_hutang;
    $tgl_transaksihutang = $row -> tgl;
    $tgl_transaksibarang = $row -> tgl_transaksi;
    $tgl_jatuhtempo = $row -> tgl_jatuhtempo;
    $nama_pembeli = $row -> nama_pembeli;
    $jml_bayar = $row -> pembayaran;
    $peg_pembayaran = $row -> nama_user;
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
        <p><strong>Invoice Nomor :</strong> <?php echo $kode_hutang; ?></p>
        <p><strong>Nama Pembeli :</strong> <?php echo $nama_pembeli; ?></p>

        <p><strong>Tanggal Pembayaran Hutang :</strong> <?php echo $tgl_transaksihutang; ?></p>
        <p><strong>Tanggal Transaksi :</strong> <?php echo $tgl_transaksibarang; ?></p>
        <p><strong>Tanggal Jatuh Tempo :</strong> <?php echo $tgl_jatuhtempo; ?></p>
        <table class="content">
            <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">No Invoice</th>
                <th style="text-align: center;">Kode Transaksi</th>
                <th style="text-align: center;">Pembayaran</th>
                <th style="text-align: center;">Pegawai</th>
            </tr>
            <tr>
                <td style="text-align: center;">1</td>
                <td style="text-align: center;"><?php echo $kode_hutang; ?></td>
                <td style="text-align: center;"><?php echo $kode_transaksi; ?></td>
                <td style="text-align: center;">Rp. <?php echo $jml_bayar; ?></td>
                <td style="text-align: center;"><?php echo $peg_pembayaran; ?></td>
            </tr>
            
            <tr>
                <td colspan="4" class="right">DITERIMA :</td>
                <td style="text-align: center;">Rp. <?php echo $jml_bayar; ?></td>
            </tr>
        </table>
        <br>
        <table style="width: 100%;">
            <tr>
                <td style="text-align: center;padding:20px;width:17%">
                    Penerima Pembayaran
                </td>
                <td style="text-align: center;padding:20px;width:17%">
                    &nbsp;
                </td>
                <td style="text-align: center;padding:20px;width:17%">
                    &nbsp;
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
                <td style="padding: 20px;">&nbsp;</td>
                <td style="padding: 20px;">&nbsp;</td>
                <td style="padding: 20px;">&nbsp;</td>
                <td style="text-align: center;"><?= $nama_user;?></td>
            </tr>
        </table>

    </div>
</body>
</html>
