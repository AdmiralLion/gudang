
<?php $this->load->view('v_main/header.php'); 
foreach($user as $row):
    $nama = $row -> nama_user;
endforeach;
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
                  </ul>
            </li>
            <li class="nav-item dropdown">
              <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i class="fas fa-store"></i><span>Transaksi</span></a>
                  <ul class="dropdown-menu">
                    <li class="nav-item"><a href="<?= base_url('');?>Home/transaksi_keluar" class="nav-link">Penjualan</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>Home/transaksi_masuk" class="nav-link">Barang Masuk</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>Home/stok_barang" class="nav-link">Pengelolaan Stok</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>Home/retur_jual" class="nav-link">Retur Penjualan</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>Home/retur_supplier" class="nav-link">Retur Supplier</a></li>
                    <li class="nav-item "><a href="<?= base_url('');?>Home/transaksi_hutang" class="nav-link">Pembayaran Hutang</a></li>
                    <li class="nav-item "><a href="<?= base_url('');?>Home/transaksi_klaim" class="nav-link">Klaim Garansi</a></li>
                  </ul>
            </li>
            <li class="nav-item active">
              <a href="#" class="nav-link active"><i class="fas fa-fire"></i><span>Laporan</span></a>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>LAPORAN</h1>
          </div>

          <div class="section-body">
            <div class="card">
              <div class="card-header">
                <h4>LAPORAN GUDANG</h4>
              </div>
              <div class="card-body">
                  <div class="row">
                    <div class="col-md-3">
                      &nbsp;
                    </div>
                    <div class="col-md-6">
                      <table style="width: 100%;">
                          <tr>
                            <td>Jenis Laporan</td>
                            <td>:</td>
                            <td>
                                <select class="form-control" name="jns_laporan" id="jns_laporan">
                                    <option value="">--Pilih Jenis Laporan--</option>
                                    <option value="Laporan Barang Masuk">Laporan Barang Masuk</option>
                                    <option value="Laporan Barang Keluar">Laporan Barang Keluar</option>
                                    <option value="Laporan Retur Supplier">Laporan Retur Supplier</option>
                                    <option value="Laporan Retur Penjualan">Laporan Retur Penjualan</option>
                                    <option value="Laporan Penghasilan">Laporan Penghasilan</option>
                                    <option value="Laporan Pembayaran Hutang">Laporan Pembayaran Hutang</option>
                                    <option value="Laporan Jatuh Tempo">Laporan Jatuh Tempo</option>
                                    <option value="Laporan Stok Gudang">Laporan Stok Gudang</option>
                                    <!-- <option value="Laporan Barang Masuk">Laporan Barang Masuk</option>
                                    <option value="Laporan Barang Masuk">Laporan Barang Masuk</option> -->
                                </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Jangka Waktu</td>
                            <td>:</td>
                            <td>
                                <select class="form-control" name="jangka_waktu" id="jangka_waktu">
                                    <option value="">--Pilih Jangka Waktu--</option>
                                    <option value="Harian">Harian</option>
                                    <option value="Bulanan">Bulanan</option>
                                    <option value="Rentang Waktu">Rentang Waktu</option>
                                </select>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="hidden" name="btn_cek" id="btn_cek">
                              <input class="form-control datepicker" style="display:none;" type="text" name="lap_harian" id="lap_harian" readonly>
                              <input class="form-control" style="display:none;" type="text" name="lap_bulanan" id="lap_bulanan" readonly>
                              <div class="input-group mb-3" style="display:none;" id="tglgrup">
                                <input class="form-control datepicker" style="display:none;" type="text" name="lap_rtgwaktu1" id="lap_rtgwaktu1" readonly>
                                <span class="input-group-text">To</span>
                                <input class="form-control datepicker" style="display:none;" type="text" name="lap_rtgwaktu2" id="lap_rtgwaktu2" readonly>
                              </div>
                            </td>
                            <td>:</td>
                            <td>
                                <button class="btn btn-icon btn-primary btn-md btn_lihat" id="btn_lihat" style="display:none;" type="submit">
                                  <i class="fas fa-search"></i>
                                      Lihat
                                </button>
                                &nbsp;
                                <button class="btn btn-icon btn-primary btn-md btn_download" id="btn_download" style="display:none;" type="submit">
                                  <i class="fas fa-download"></i>
                                      Excel
                                </button>
                                &nbsp;
                            </td>
                          </tr>
                          
                      </table>
                    </div>
                    <div class="col-md-3">
                      &nbsp;
                    </div>
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
  <!-- <script src="<?php echo base_url(); ?>assets/modules/jquery.min.js"></script> -->
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
  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script> -->
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

<div class="modal fade" id="modal_tambahtransaksimasuk" role="dialog" aria-labelledby="modal_tambahtransaksimasuk" aria-hidden="true">
                  <div class="modal-dialog" style="min-width:100%;" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modal_tambahtransaksimasuk">Transaksi Masuk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <input type="hidden" name="id_transaksi" id="id_transaksi" value="">
                        <div class="panel-body">
                          <div class="row">
                            <div class="col-md-3"><p style="text-align: right;">Pilih nama rekanan : </p></div>
                            <div class="col-md-6">
                              <select class="form-control select2" style="width:100%" name="nama_rekanan" id="nama_rekanan">
                              <option>--Pilih Rekanan--</option>
                              <?php foreach($nama_rekanan as $rows):
                               echo '<option value="'.$rows->id.'">'.$rows->nama_rekanan.'</option>';
                              endforeach;
                              ?>
                            </select></div>
                          </div>
                          <br>
                          <div id="education_fields">
          
          </div>
                        <div class="row">
                        <!-- <div class="col-md-3">
                          <div class="form-group">
                          <select class="select2" style="width:100%" id="nama_barang" name="nama_barang[]">
                              
                              <option value="">--Pilih Barang--</option>
                              <?php foreach($nama_barang as $rows):
                               echo '<option value="'.$rows->id.'">'.$rows->nama_barang.'</option>';
                              endforeach;
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-3 nopadding">
                          <div class="form-group">
                          <select class="select2" style="width:100%" id="tipe_barang" name="tipe_barang[]">
                              
                              <option value="">--Merk--</option>
                              <?php foreach($nama_merk as $rows):
                               echo '<option value="'.$rows->id.'">'.$rows->nama_merk.'</option>';
                              endforeach;
                              ?>
                            </select>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-1 nopadding">
                          <div class="form-group">
                          <input type="text" class="form-control" name="tahun_barang[]" id="tahun_barang" placeholder="Tahun">
                          </div>
                        </div>
                        
                        <div class="col-sm-1 nopadding">
                          <div class="form-group">
                          <input type="text" class="form-control" name="seri_barang[]" id="seri_barang" placeholder="Seri">
                          </div>
                        </div>

                        <div class="col-sm-1 nopadding">
                          <div class="form-group">
                          <input type="text" class="form-control" name="kode_bulan[]" id="kode_bulan" placeholder="Bulan">
                          </div>
                        </div>

                        <div class="col-sm-1 nopadding">
                          <div class="form-group">
                          <input type="text" class="form-control" name="kode_urut[]" id="kode_urut" placeholder="Urut">
                          </div>
                        </div> -->
                        <div class="col-sm-9">&nbsp;</div>
                        <div class="col-sm-3 pull-right nopadding">
                          <div class="form-group">
                            <div class="input-group">
                              <input type="text" class="form-control" name="harga_total" id="harga_total" placeholder="Harga">
                              &nbsp; &nbsp;
                              <div class="input-group-btn">
                                <button class="btn btn-success" type="button"  onclick="education_fields();"> <span class="fa fa-plus" aria-hidden="true"></span> </button>
                              </div>
                            </div>
                          </div>
                        </div>
                        </div>
                      
                      </div>
                      <div class="clear"></div>
  
  </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="save_transaksimasuk" type="button" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus"></i>Tambah</button>
                      </div>
                    </div>
                  </div>
                </div>