
<?php $this->load->view('v_main/header.php'); 
foreach($user as $row):
    $nama = $row -> nama_user;
endforeach;
?>

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
            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, <?= $nama;?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Logged in <?= $last_activity;?> min ago</div>
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
            <li class="nav-item active">
              <a href="#" data-toggle="dropdown" class="nav-link"><i class="fas fa-fire"></i><span>Home</span></a>
            </li>
            <li class="nav-item dropdown">
              <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i class="far fa-star"></i><span>Master data</span></a>
                  <ul class="dropdown-menu">
                    <li class="nav-item"><a href="<?= base_url('');?>home/master_barang" class="nav-link">Master Barang</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>home/master_rekanan" class="nav-link">Master Rekanan</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>home/master_harga" class="nav-link">Master Harga</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>Home/master_satuan" class="nav-link">Master Satuan</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>Home/master_merk" class="nav-link">Master Merk</a></li>
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
            <h1>Selamat Datang <?= $nama;?></h1>
          </div>

          <div class="section-body">
            <div class="card">
              <div class="card-header">
                <h4>Pengelolaan transaksi gudang CV ABS</h4>
              </div>
              <div class="card-body">
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
  <script src="<?php echo base_url(); ?>assets/modules/jquery.min.js"></script>
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

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
</body>