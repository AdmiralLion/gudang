<!DOCTYPE html>
<html lang="en">
  <?php $tgl = $_GET['tgl'];
  $jns_lap = $_GET['jnslap']; 

  if($jns_lap == 'excel'){
    header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=lap_barang_keluar_".$tgl.".xls"); 
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
  }
  ?>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Barang Keluar</title>
<style>
    /* Style the table for printing */
    table {
            width: 85%;
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
    <p>Laporan Barang Keluar</p>
    <p>Periode : <?= $tgl;?></p>
</div>

<!-- Table to print -->

<table id="myTable" class="center">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode Transaksi</th>
            <th>Nama Barang</th>
            <th>Merk</th>
            <th>Tahun Barang</th>
            <th>Seri Barang</th>
            <th>Kode bulan</th>
            <th>Kode Urut</th>
            <th>Kualitas</th>
            <th>Harga Masuk</th>
            <th>Harga Jual</th>
            <th>User Input</th>
            <th>Retur</th>
            <th>Status Hutang</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
      <?php $no = 1;
            $tglskrg = date('d-m-Y H:i:s');
            $hargamodal = 0;
            $hargalaba = 0;
      foreach($get_barang as $row):
        $hargamodal += $row -> harga_barang;
        $hargalaba += $row -> harga_jual;
        ?>
        <tr>
            <td style="text-align:center;"><?= $no++;?></td>
            <td style="text-align:center;"><?= $row -> kode_transaksi;?></td>
            <td style="text-align:center;"><?= $row -> nama_barang;?></td>
            <td style="text-align:center;"><?= $row -> nama_merk;?></td>
            <td style="text-align:center;"><?= $row -> tahun_barang;?></td>
            <td style="text-align:center;"><?= $row -> seri_barang;?></td>
            <td style="text-align:center;"><?= $row -> kode_bulan;?></td>
            <td style="text-align:center;"><?= $row -> kode_urut;?></td>
            <td style="text-align:center;"><?= $row -> kualitas;?></td>
            <td style="text-align:center;"><?= $row -> harga_barang;?></td>
            <td style="text-align:center;"><?= $row -> harga_jual;?></td>
            <td style="text-align:center;"><?= $row -> nama_user;?></td>
            <td style="text-align:center;">
            <?php if($row -> is_retur == '1'){
              echo 'Retur Gudang';
            }else{
              echo 'Tidak Retur';
            }
            ;?>
            </td>
            <td style="text-align:center;">
            <?php if($row -> is_hutang == '1'){
              echo 'Hutang Belum Lunas';
            }else{
              echo 'Hutang Lunas';
            }
            ;?>
            </td>
            <td style="text-align:center;"><?= $row -> tgl;?></td>

        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="11" style="text-align: right;">Modal</td><td colspan="4"> Rp. <?= $hargamodal;?></td>
        </tr>
        <tr>
            <td colspan="11" style="text-align: right;">Laba Kotor</td><td colspan="4"> Rp. <?= $hargalaba - $totpotongan;?></td>
        </tr>
        <tr>
            <td colspan="11" style="text-align: right;">Laba Bersih</td><td colspan="4"> Rp. <?= $hargalaba - $hargamodal;?></td>
        </tr>
        <tr>
          <td colspan="15" style="text-align: right;">
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
