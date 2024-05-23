<?php 
foreach ($get_barang as $row):
    $kode_transaksi = $row -> kode_transaksi;
    $kd_retur = $row -> kd_retur;
    $temp1 = $row -> tgl_act;
    $nama_pembeli = $row -> nama_pembeli;
endforeach;
$tglpembelian = date('d-m-Y H:i:s' , strtotime($temp1));
foreach ($user as $row):
    $nama_user = $row -> nama_user;
endforeach;

$tglnow = date('d-m-Y H:i:s');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice for Retur Stok</title>
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
        <h5>Invoice Nomor Penjualan : <?php echo $kode_transaksi; ?></h5>
        <h5>Nama Pembeli  : <?php echo $nama_pembeli; ?></h5>
        <h5>Tanggal Penjualan : <?php echo $tglpembelian; ?></h5>

        <!-- Output the details of the transaction here -->
        <table class="table table-bordered">
            <tr style="text-align: center;">
                <th>No</th>
                <th>Kode Retur</th>
                <th>Barang Awal</th>
                <th>Barang Pengganti</th>
                <th>Alasan Retur</th>
                <th>Tanggal Retur</th>
            </tr>
            <!-- Loop through transaction items and display each row -->
            <?php $no = 1;
            $totalharga = 0;
             foreach ($get_barang as $item): 
                $tglretur = date('d-m-Y H:i:s' , strtotime($item -> tgl_act));
                ?>
                <tr style="text-align: center;">
                    <td><?= $no++;?></td>
                    <td><?= $item -> kd_retur;?></td>
                    <td><?= $item -> nama_barangasli . '&nbsp;' . $item -> tahun_barang . '&nbsp;' . $item -> kode_bulan . '&nbsp;' . $item -> kode_urut;?></td>
                    <td><?= $item -> nama_barangganti . '&nbsp;' . $item -> tahun_barangganti . '&nbsp;' . $item -> kode_bulanganti . '&nbsp;' . $item -> kode_urutganti;?></td>
                    <td><?= $item -> alasan_retur;?></td>
                    <td><?= $tglretur;?></td>
                </tr>
            <?php endforeach; ?>
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
