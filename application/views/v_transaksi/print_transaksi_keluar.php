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
                $totalharga += $item->harga_jual;
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
                    <td><?php if($item -> is_hutang == '1'){
                                    $totalhutang += $item->harga_jual;
                                    echo 'Hutang';
                                }else{
                                    // $totaltunai += $item->harga_jual;
                                    echo 'Tunai';
                                };?>
                    </td>
                    <td>Rp. <?= $item -> harga_jual;?></td>

                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="7" style="padding:10px;">&nbsp;</td>
                <td colspan="4" style="padding:10px;">Total Yang Belum Dibayarkan: Rp.<?php if($totalhutang == $totaltunai){
                    $final_hutang = $totalhutang - $totaltunai;
                    echo $final_hutang;
                }else{
                    echo $totalhutang;
                }  ?></td>
            </tr>
            <tr>
                <td colspan="7" style="padding:10px;">&nbsp;</td>
                <td colspan="4" style="padding:10px;">Total Yang Sudah Dibayarkan: Rp.<?php echo $totaltunai; ?></td>
            </tr>
            <tr>
                <td colspan="7" style="padding:10px;">&nbsp;</td>
                <td colspan="4" style="padding:10px;">Total Potongan Yang didapatkan: Rp.<?php echo $jml_potongan; ?></td>
            </tr>
            <tr>
                <td colspan="7" style="padding:10px;">&nbsp;</td>
                <td colspan="4" style="padding:10px;">Total Harga Sebelum dipotong: Rp.<?php echo $totalharga; ?></td>
            </tr>
            <tr>
                <td colspan="7" style="padding:10px;">&nbsp;</td>
                <td colspan="4" style="padding:10px;">Total Harga Sesudah dipotong: Rp.<?php $finalharga = $totalharga - $jml_potongan;
                echo $finalharga; ?></td>
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
