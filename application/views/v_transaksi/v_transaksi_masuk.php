
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
                    <li class="nav-item"><a href="<?= base_url('');?>Home/transaksi_keluar" class="nav-link">Penjualan</a></li>
                    <li class="nav-item active"><a href="#" class="nav-link">Barang Masuk</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>Home/stok_barang" class="nav-link">Pengelolaan Stok</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>Home/retur_jual" class="nav-link">Retur Penjualan</a></li>
                    <li class="nav-item"><a href="<?= base_url('');?>Home/retur_supplier" class="nav-link">Retur Supplier</a></li>
                    <li class="nav-item "><a href="<?= base_url('');?>Home/transaksi_hutang" class="nav-link">Pembayaran Hutang</a></li>
                    <li class="nav-item "><a href="<?= base_url('');?>Home/transaksi_klaim" class="nav-link">Klaim Garansi</a></li>
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
            <h1>Transaksi Masuk</h1>
          </div>

          <div class="section-body">
            <div class="card">
              <div class="card-header">
                <h4>TRANSAKSI MASUK</h4>
              </div>
              <div class="card-body">
                <div class="row">
                <div class="col-md-4"><button id="tambah_transaksimasuk" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus"></i> Tambah </button></div>
                </div>
              
                
                <br>
                <div class="table-responsive">
                      <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                          Tanggal Transaksi : <input class="form-control datepicker" type="text" name="tgl_transaksi" id="tgl_transaksi">
                        </div>
                        <div class="col-md-4"></div>
                      </div>
                      <table class="table table-striped" id="table-1">
                        <thead>                                 
                          <tr>
                            <th class="text-center" style="width:10px;">
                              No
                            </th>
                            <th class="text-center"  style="width:20px;">Act</th>
                            <th class="text-center">Kode Transaksi</th>
                            <th class="text-center">Rekanan</th>
                            <th class="text-center">Tgl Transaksi</th>
                            <th class="text-center">Print</th>
                          </tr>
                        </thead>
                        <tbody id="data_transaksimasuk" style="text-align: center;">                                 
                         
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
                        <button id="save_transaksimasuk" type="button" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus"></i>Simpan</button>
                      </div>
                    </div>
                  </div>
                </div>




                <div class="modal fade" id="modal_editbrg" role="dialog" aria-labelledby="modal_editbrg" aria-hidden="true">
                  <div class="modal-dialog" style="min-width:100%;" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modal_editbrg">Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <input type="hidden" name="id_transaksi" id="id_transaksi" value="">
                        <div class="panel-body">
                        <table class="table table-striped" id="table-2">
                        <thead>                                 
                          <tr>
                            <th class="text-center" style="width:10px;">
                              No
                            </th>
                            <th class="text-center" style="width:300px;">Kode Transaksi</th>
                            <th class="text-center">Barang</th>
                            <th class="text-center"style="width:150px;">Harga</th>
                            <th class="text-center"style="width:100px;">Tgl</th>
                            <th class="text-center" style="width:100px;">Act</th>
                          </tr>
                        </thead>
                        <tbody id="data_barangmsk" style="text-align: center;">                                 
                         
                        </tbody>
                      </table>
                      <br><br>
                      <input type="hidden" name="id_brgedit" id="id_brgedit">
                        <div class="hidetable" style="display: none;">
                          <table class="table table-striped" id="table-3">
                          <thead>  
                            <tr>
                              <th colspan="10" style="background-color: aquamarine;text-align:center;" ><h1>==== EDIT BARANG ====</h1></th>
                            </tr>                               
                            <tr>
                              <th class="text-center" style="width: 100px;">Nama Barang</th>
                              <th class="text-center" style="width: 50px;">Merk</th>
                              <th class="text-center" style="width: 100px;">Tahun Barang</th>
                              <th class="text-center" style="width: 150px;">Seri Barang</th>
                              <th class="text-center" style="width: 50px;" >Kode Bulan</th>
                              <th class="text-center" style="width: 120px;">Kode Urut</th>
                              <th class="text-center" style="width: 100px;">Jenis Barang</th>
                              <th class="text-center" style="width: 100px;">Kualitas</th>
                              <th class="text-center" style="width: 150px;">Harga Masuk</th>
                              <th class="text-center" style="width: 20px;">Act</th>
                            </tr>
                          </thead>
                          <tbody id="editdatafinal" style="text-align: center;">    
                            <tr>
                              <td>
                                <select name="edit_namabrg" id="edit_namabrg" style="width:100%">
                                  <option value="">--Pilih--</option>
                                  <?php 
                                    foreach($nama_barang as $row): ?>
                                    <option value="<?= $row -> id;?>"><?= $row -> nama_barang;?></option>
                                    <?php endforeach;?>
                                </select>
                              </td>
                              <td>
                                <select name="edit_merkbrg" id="edit_merkbrg" style="width:100%">
                                  <option value="">--Pilih--</option>
                                  <?php 
                                    foreach($nama_merk as $row): ?>
                                    <option value="<?= $row -> id;?>"><?= $row -> nama_merk;?></option>
                                    <?php endforeach;?>
                                </select>
                              </td>
                              <td>
                                <input type="text" name="edit_tahunbrg" id="edit_tahunbrg" class="form-control">
                              </td>
                              <td>
                                <input type="text" name="edit_seribrg" id="edit_seribrg" class="form-control">
                              </td>
                              <td>
                                <input type="text" name="edit_kodebln" id="edit_kodebln" class="form-control">
                              </td>
                              <td>
                                <input type="text" name="edit_kodeurut" id="edit_kodeurut" class="form-control">
                              </td>
                              <td>
                                <select class="select2" name="edit_jenisbrg" id="edit_jenisbrg" style="width:100%">
                                  <option value="">--Pilih--</option>
                                  <option value="Jasa">Jasa</option>
                                  <option value="Panas">Panas</option>
                                  <option value="Dingin">Dingin</option>
                                  <option value="Overtread">Overtread</option>
                                  <option value="Afkir">Afkir</option>
                                  <option value="Baru">Baru</option>
                                  <option value="Ori">Ori</option>
                                  <option value="Tebelan">Tebelan</option>
                                </select>
                              </td>
                              <td>
                                <select class="select2" name="edit_kualitas" id="edit_kualitas" style="width:100%">
                                  <option value="">--Pilih--</option>
                                  <option value="AA">AA</option>
                                  <option value="AA MOTIF">AA MOTIF</option>
                                  <option value="AA FULL ALS">AA FULL ALS</option>
                                  <option value="AA FULL KSR">AA FULL KSR</option>
                                  <option value="AA TOP ALS">AA TOP ALS</option>
                                  <option value="AA TOP KSR">AA TOP KSR</option>
                                  <option value="AA HQ">AA HQ</option>
                                  <option value="BB">BB</option>
                                  <option value="BB MOTIF">BB MOTIF</option>
                                  <option value="BB FULL ALS">BB FULL ALS</option>
                                  <option value="BB FULL KSR">BB FULL KSR</option>
                                  <option value="BB TOP ALS">BB TOP ALS</option>
                                  <option value="BB TOP KSR">BB TOP KSR</option>
                                  <option value="BB HQ">BB HQ</option>
                                  <option value="CC">CC</option>
                                  <option value="CC MOTIF">CC MOTIF</option>
                                  <option value="CC FULL ALS">CC FULL ALS</option>
                                  <option value="CC FULL KSR">CC FULL KSR</option>
                                  <option value="CC TOP ALS">CC TOP ALS</option>
                                  <option value="CC TOP KSR">CC TOP KSR</option>
                                  <option value="CC HQ">CC HQ</option>
                                  <option value="DD">DD</option>
                                  <option value="DD MOTIF">DD MOTIF</option>
                                  <option value="DD FULL ALS">DD FULL ALS</option>
                                  <option value="DD FULL KSR">DD FULL KSR</option>
                                  <option value="DD TOP ALS">DD TOP ALS</option>
                                  <option value="DD TOP KSR">DD TOP KSR</option>
                                  <option value="DD HQ">DD HQ</option>
                                </select>
                              </td>
                              <td>
                                <input type="text" name="edit_hargabrg" id="edit_hargabrg" class="form-control">
                              </td>
                              <td>
                                <button type="button" class="btn btn-warning btn-icon btn-small" id="save_editbrg"><i class="fa fa-save"></i>
                                </button>
                              </td>
                            </tr>   
                          </tbody>
                        </table>
                        </div>
                         </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>