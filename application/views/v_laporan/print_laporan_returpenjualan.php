<!DOCTYPE html>
<html lang="en">
<?php $tgl = $_GET['tgl']; ?>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Retur Penjualan</title>
<style>
    /* Style the table for printing */
    table {
            width: 80%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        /* Style the letterhead */
        .letterhead {
            text-align: center;
            margin-bottom: 20px;
            font-family: sans-serif !important;

        }
        .letterhead h1 {
            margin: 0;
            font-family: sans-serif !important;
        }

        .center {
          margin-left: auto;
          margin-right: auto;
        }

        button{
            height:60px; 
            width:100px; 
            margin: -20px -50px; 
            position:relative;
            top:50%; 
            left:50%;
        }
    @media print {
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        /* Style the letterhead */
        .letterhead {
            text-align: center;
            margin-bottom: 20px;
            font-family: sans-serif !important;

        }
        .letterhead h1 {
            margin: 0;
            font-family: sans-serif !important;
        }

        .center {
          margin-left: auto;
          margin-right: auto;
        }
    }
</style>
</head>
<body>

<!-- Letterhead -->
<div class="letterhead">
    <h1>CV ABS</h1>
    <p>ALAMAT KECIPIK BARU NO 99</p>
    <p>Laporan Retur Penjualan</p>
    <p>Periode : <?= $tgl;?></p>
</div>

<!-- Table to print -->

<table id="myTable" class="center">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode Retur</th>
            <th>Kode Transaksi</th>
            <th>Barang Retur</th>
            <th>Barang Ganti</th>
            <th>Alasan Retur</th>
            <th>Harga Jual</th>
            <th>User Input</th>
            <th>Tanggal Retur</th>
            <th>Tanggal Keluar</th>
        </tr>
    </thead>
    <tbody>
      <?php $no = 1;
            $tglskrg = date('d-m-Y H:i:s');

      foreach($get_barang as $row):
        ?>
        <tr>
            <td style="text-align:center;"><?= $no++;?></td>
            <td style="text-align:center;"><?= $row -> kd_retur;?></td>
            <td style="text-align:center;"><?= $row -> kd_transaksi;?></td>
            <td><?= $row -> nama_barangasli . '&nbsp;' . $row -> tahun_barang . '&nbsp;' . $row -> kode_bulan . '&nbsp;' . $row -> kode_urut;?></td>
            <td><?= $row -> nama_barangganti . '&nbsp;' . $row -> tahun_barangganti . '&nbsp;' . $row -> kode_bulanganti . '&nbsp;' . $row -> kode_urutganti;?></td>
            <td><?= $row -> alasan_retur;?></td>
            <td style="text-align:center;"><?= $row -> harga_jual;?></td>
            <td style="text-align:center;"><?= $row -> nama_user;?></td>
            <td style="text-align:center;"><?= $row -> tgl_retur;?></td>
            <td style="text-align:center;"><?= $row -> tgl_keluar;?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
          <td colspan="13" style="text-align: right;">
          Yang Mencetak <br>
          Gresik, <?= $tglskrg;?><br><br><br> <br><br>
          <?php foreach($user as $rows):
          echo $rows -> nama_user;
          endforeach;?>
          </td>
        </tr>
        <!-- Add more rows here -->
    </tbody>
</table>
<br><br>
<!-- Button to trigger printing -->
<button class="cenbut" onclick="printTable()">Print Laporan</button>

<script>
function printTable() {
    // Copy the table content to a new window
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Print Table with Letterhead</title></head><body>');
    printWindow.document.write('<div class="letterhead"><h1>CV ABS</h1><p>ALAMAT KECIPIK BARU NO 99</p></div>');
    printWindow.document.write('<h2>Laporan Tabel</h2>');
    printWindow.document.write(document.getElementById('myTable').outerHTML);
    printWindow.document.write('</body></html>');

    // Style the new window
    printWindow.document.head.innerHTML += '<style>' + 
        '@media print {table {width: 100%;border-collapse: collapse;}th, td {border: 1px solid #ddd;padding: 8px;}th {background-color: #f2f2f2;}tr:nth-child(even) {background-color: #f2f2f2;} .letterhead {text-align: center;margin-bottom: 20px;}.letterhead h1 {margin: 0;}}</style>';

    // Trigger printing
    printWindow.print();
    printWindow.close();
}
</script>

</body>
</html>
