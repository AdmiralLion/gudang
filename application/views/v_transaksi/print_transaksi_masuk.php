<?php 
foreach ($get_barang as $row):
    $kode_transaksi = $row -> kode_transaksi;
    $tgl_masuk = $row -> tgl_transaksi;
    $nama_rekanan = $row -> nama_rekanan;
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
            max-width: 800px;
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
        <h5>Nama Pemasok  : <?php echo $nama_rekanan; ?></h5>
        <h5>Tanggal Masuk : <?php echo $tgl_masuk; ?></h5>
        <!-- Output the details of the transaction here -->
        <table class="table table-bordered">
            <tr style="text-align: center;">
                <th>No</th>
                <th>Barang</th>
                <th>Satuan</th>
                <th>Merk</th>
                <th>Tahun Barang</th>
                <th>No. Seri</th>
                <th>Kode Bulan</th>
                <th>Kode Urut</th>
                <th>Jenis Barang</th>
                <th>Kualitas</th>
                <th style="width: 150px;">Harga</th>
            </tr>
            <!-- Loop through transaction items and display each row -->
            <?php $no = 1;
            $totalharga = 0;
             foreach ($get_barang as $item): 
                $totalharga += $item->harga_barang;?>
                <tr style="text-align: center;">
                    <td><?= $no++;?></td>
                    <td><?= $item -> nama_barang;?></td>
                    <td><?= $item -> nama_satuan;?></td>
                    <td><?= $item -> nama_merk;?></td>
                    <td><?= $item -> tahun_barang;?></td>
                    <td><?= $item -> seri_barang;?></td>
                    <td><?= $item -> kode_bulan;?></td>
                    <td><?= $item -> kode_urut;?></td>
                    <td><?= $item -> jenis_barang;?></td>
                    <td><?= $item -> kualitas;?></td>
                    <td>Rp. <?= $item -> harga_barang;?></td>

                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="9" style="padding:10px;">&nbsp;</td>
                <td colspan="2" style="padding:10px;">Total Harga: Rp.<?php echo $totalharga; ?></td>
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
