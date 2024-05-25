<!DOCTYPE html>
<html lang="en">
<?php $tgl = $_GET['tgl'];
  $jns_lap = $_GET['jnslap']; 
  if($jns_lap == 'excel'){
    header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=lap_pembayaran_hutang_".$tgl.".xls"); 
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
  }
  ?>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Pembayaran Hutang</title>
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
    <p>Laporan Pembayaran Hutang</p>
    <p>Periode : <?= $tgl;?></p>
</div>

<!-- Table to print -->

<table id="myTable" class="center">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode Pembayaran Hutang</th>
            <th>Kode Transaksi</th>
            <th>Nama Pembeli</th>
            <th>Pembayaran</th>
            <th>Total Hutang</th>
            <th>Lunas</th>
            <th>User Input</th>
            <th>Tanggal Pembayaran</th>
            <th>Tanggal Jatuh Tempo</th>
        </tr>
    </thead>
    <tbody>
      <?php $no = 1;
            $tglskrg = date('d-m-Y H:i:s');
      foreach($get_barang as $row):
        $tgl_pembayaran = date('d-m-Y H:i:s', strtotime($row -> tgl_act));
        $tgl_jatuhtempo = date('d-m-Y', strtotime($row -> tgl_jatuhtempo));

        ?>
        <tr>
            <td style="text-align:center;"><?= $no++;?></td>
            <td style="text-align:center;"><?= $row -> kode_hutang;?></td>
            <td style="text-align:center;"><?= $row -> kode_transaksi;?></td>
            <td style="text-align:center;"><?= $row -> nama_pembeli;?></td>
            <td style="text-align:center;"><?= $row -> pembayaran;?></td>
            <td style="text-align:center;"><?= $row -> total_hutang;?></td>
            <td style="text-align:center;">
                    <?php if($row -> is_lunas == 1){
                        echo 'Lunas';
                    }else{
                        echo 'Belum Lunas';
                    };?>
            </td>
            <td style="text-align:center;"><?= $row -> nama_user;?></td>
            <td style="text-align:center;"><?= $tgl_pembayaran;?></td>
            <td style="text-align:center;"><?= $tgl_jatuhtempo;?></td>
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
