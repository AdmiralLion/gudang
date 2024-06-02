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
        <h5>Invoice Nomor : <?php echo $kode_hutang; ?></h5>
        <h5>Nama Pembeli  : <?php echo $nama_pembeli; ?></h5>
        <h5>Tanggal Pembayaran Hutang : <?php echo $tgl_transaksihutang; ?></h5>
        <h5><strong>Tanggal Jatuh Tempo : </strong><?php echo ($tgl_jatuhtempo == $tgl_transaksibarang) ? '-' : $tgl_jatuhtempo; ?></h5>
        <!-- Output the details of the transaction here -->
        <table class="table table-bordered">
            <tr style="text-align: center;">
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">No Invoice</th>
                <th style="text-align: center;">Kode Transaksi</th>
                <th style="text-align: center;">Pembayaran</th>
                <th style="text-align: center;">Pegawai</th>
            </tr>
            <tr style="text-align: center;">
                <td style="text-align: center;">1</td>
                <td style="text-align: center;"><?php echo $kode_hutang; ?></td>
                <td style="text-align: center;"><?php echo $kode_transaksi; ?></td>
                <td style="text-align: center;">Rp. <?php echo $jml_bayar; ?></td>
                <td style="text-align: center;"><?php echo $peg_pembayaran; ?></td>
            </tr>
            
            <tr>
                <td colspan="4" class="right" style="text-align: right;">DITERIMA :</td>
                <td style="text-align: center;">Rp. <?php echo $jml_bayar; ?></td>
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
