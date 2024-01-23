  $(document).ready(function () {
    $("#table-1").dataTable({
    });
  
    $('#tambah_barang').on('click', function() {
      $('#modal_tambahbarang').modal('show');
    })
  });