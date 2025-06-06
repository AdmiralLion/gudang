
<?php $this->load->view('v_main/header.php'); 
foreach($user as $row):
    $nama = $row -> nama_user;
endforeach;
// dd($master_barang);
?>
<head>
<script src="<?php echo base_url(); ?>assets/modules/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
</head>

<body class="layout-3">
<div class="main-wrapper container">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <a href="index.html" class="navbar-brand sidebar-gone-hide">CV ABS</a>
        <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
        <form class="form-inline ml-auto">
         <!-- empty -->
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="<?= base_url();?>assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, <?= $nama;?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <!-- <div class="dropdown-title">Logged in <?= $last_activity;?> min ago</div> -->
              <a href="#" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a>
              <div class="dropdown-divider"></div>
              <button id="btnlogout" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </div>
          </li>
        </ul>
      </nav>
      <nav class="navbar navbar-secondary navbar-expand-lg">
        <div class="container">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a href="<?= base_url();?>home" class="nav-link"><i class="fas fa-fire"></i><span>Home</span></a>
            </li>
            <li class="nav-item dropdown">
              <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i class="far fa-star"></i><span>Master data</span></a>
                  <ul class="dropdown-menu">
                    <li class="nav-item"><a href="<?= base_url('');?>Home/master_barang" class="nav-link">Master Barang</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>Home/master_rekanan" class="nav-link">Master Rekanan</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>home/master_harga" class="nav-link">Master Harga</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>Home/master_satuan" class="nav-link">Master Satuan</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>Home/master_merk" class="nav-link">Master Merk</a></li>
                  </ul>
            </li>
            <li class="nav-item dropdown active">
              <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i class="fas fa-store"></i><span>Transaksi</span></a>
                  <ul class="dropdown-menu">
                    <li class="nav-item "><a href="<?= base_url('');?>Home/transaksi_keluar" class="nav-link">Penjualan</a></li>
                    <li class="nav-item "><a href="<?= base_url('');?>Home/transaksi_masuk" class="nav-link">Barang Masuk</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>Home/stok_barang" class="nav-link">Pengelolaan Stok</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>Home/retur_jual" class="nav-link">Retur Penjualan</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>Home/retur_supplier" class="nav-link">Retur Supplier</a></li>
                    <li class="nav-item "><a href="<?= base_url('');?>Home/transaksi_hutang" class="nav-link">Pembayaran Hutang</a></li>
                    <li class="nav-item active"><a href="#" class="nav-link">Klaim Garansi</a></li>
                  </ul>
            </li>
            <li class="nav-item">
            <a href="<?= base_url('');?>Home/laporan" class="nav-link"><i class="fas fa-calendar"></i><span>Laporan</span></a>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Klaim Garansi</h1>
          </div>

          <div class="section-body">
            <div class="card">
              <div class="card-header">
                <h4>Klaim Garansi</h4>
              </div>
              <div class="card-body">
                <div class="row">
                <!-- <div class="col-md-4"><button id="tambah_transaksikeluar" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus"></i> Tambah </button></div> -->
                </div>
              
                
                <br>
                <div class="table-responsive">
                      <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                          Tanggal Transaksi : <input class="form-control" type="text" name="tgl_transaksi" id="tgl_transaksi" >
                        </div>
                        <div class="col-md-4"></div>
                      </div>
                      <table class="table table-striped" id="table-1">
                        <thead>                                 
                          <tr>
                            <th class="text-center" style="width:10px;">
                              No
                            </th>
                            <th class="text-center">Kode Transaksi</th>
                            <th class="text-center">Pembeli</th>
                            <th class="text-center">Tgl Transaksi</th>
                            <th class="text-center">Tgl Batas Klaim</th>
                            <th class="text-center">Klaim</th>
                          </tr>
                        </thead>
                        <tbody id="data_transaksiklaim" style="text-align: center;">                                 
                         
                        </tbody>
                      </table>
                    </div>
              </div>
              <div class="card-footer bg-whitesmoke">
                This is card footer
              </div>
            </div>
          </div>
        </section>
      </div>
      <?php
      $this->load->view('v_main/footer.php');
      ?>
    </div>


        <!-- General JS Scripts -->
  <script src="<?php echo base_url(); ?>assets/modules/popper.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/tooltip.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/moment.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/stisla.js"></script>
  <script>
<?php echo $JavaScriptTambahan; ?>  
</script>
  <!-- JS Libraies -->

  <script src="<?= base_url();?>assets/modules/prism/prism.js"></script>

  <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/bootstrap-daterangepicker/daterangepicker.js"></script>

  <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>

  <!-- Page Specific JS File -->
  <!-- <script src="<?php echo base_url(); ?>assets/js/page/modules-datatables.js"></script> -->
  
  <!-- Template JS File -->
  <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
</body>

<div class="modal fade" id="modal_klaim" role="dialog" aria-labelledby="modal_klaim" aria-hidden="true">
                  <div class="modal-dialog" style="min-width:100%;" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modal_klaim">Klaim Garansi</h5>
                        <button id="tutupmdl" type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <input type="hidden" name="kode_transaksi" id="kode_transaksi" value="">
                        <div class="panel-body">
                          <br>
                          <div class="row">
                            <div class="col-md-1">
                            <h6>Nama Pembeli : </h6>
                            </div>
                            <div class="col-md-4">
                            <input class="form-control" readonly type="text" name="nama_pembeli" id="nama_pembeli">
                            </div>
                          </div>
                          <br>
                          <table style="width: 100%;" class="table table-striped" id="table-3">
                            <tr>
                              <th colspan="7" style="text-align: center;">
                                  LIST KLAIM GARANSI
                              </th>
                            </tr>
                            <tr>
                              <th style="text-align: center;">No</th>
                              <th style="text-align: center;">Kode Klaim Garansi</th>
                              <th style="text-align: center;">Kode Transaksi</th>
                              <th style="text-align: center;">Barang Lama</th>
                              <th style="text-align: center;">Barang Tukar</th>
                              <th style="text-align: center;">User</th>
                              <th style="text-align: center;">Tanggal Klaim</th>
                            </tr>
                            <tbody id="histori_klaim">

                            </tbody>
                          </table>
                          <br>
                        <table class="table table-striped" id="table-2">
                          <thead>                                 
                            <tr>
                              <th class="text-center" style="width:10px;">
                                No
                              </th>
                              <th class="text-center">Kode Transaksi</th>
                              <th class="text-center">Nama Barang</th>
                              <th class="text-center">Tgl Transaksi</th>
                              <th class="text-center">RETUR</th>
                              <th class="text-center">KLAIM</th>
                              <th class="text-center">Harga</th>
                              <th class="text-center">Aksi</th>
                            </tr>
                          </thead>
                          <tbody id="data_klaimgar" style="text-align: center;">                                 
                          
                          </tbody>
                        </table>
                          <br>
                          <div id="hide_klaim" style="display: none;">
                          <input type="hidden" name="id_klaim" id="id_klaim">
                          <input type="hidden" name="id_barangkeluar" id="id_barangkeluar">
                          <input type="hidden" name="kd_trans" id="kd_trans">
                          <table class="table table-hover table-bordered" style="width: 100%;">
                            <tr>
                              <th style="text-align: center; width:50%;">Barang Pengganti</th>
                              <th style="text-align: center; width:40%">Alasan Klaim</th>
                              <th style="text-align: center; width:10%">Simpan</th>
                            </tr>
                            <tr>
                              <td>
                                <select name="pil_brgtukar" id="pil_brgtukar" style="width:100%">
                                    <option value="">--Pilih--</option>
                                    <?php foreach($master_barang as $rows): ?>
                                        <option value="<?= $rows -> id;?>"><?= $rows -> nama_barang.'-'.$rows -> nama_merk.'-'.$rows -> tahun_barang.'-'.$rows -> seri_barang.'-'.$rows -> kode_bulan.'-'.$rows -> kode_urut;?> </option>
                                    <?php endforeach;?>
                                </select>
                              </td>
                              <td>
                                <textarea name="alasan_klaim" id="alasan_klaim" class="form-control"></textarea>
                              </td>
                              <td style="text-align: center;">
                                <button id="save_klaimgar" type="button" class="btn btn-icon icon-left btn-success"><i class="fa fa-save"></i></button>                              
                              </td>
                            </tr>
                          </table>
                          </div>
                          <br>
                        </div>
                      </div>  
                      <div class="modal-footer">
                        <button type="button" id="tutup" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>