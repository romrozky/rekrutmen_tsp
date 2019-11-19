<!-- Custom CSS -->
 <link href="<?= base_url() ?>assets/unit-carausel.css" rel="stylesheet">
<script src="<?=base_url('assets/datatable')?>/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="<?=base_url('assets/datatable')?>/dataTables.bootstrap.min.css">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
	
  <!-- Row -->
  <div class="row">
      <!-- Column -->
      <div class="col-lg-12 col-md-12">
          <div class="card">
              <div class="card-body">
                  <div class="row">
                      <div class="col-12">
                        <div class="d-flex flex-wrap">
						  <div>
							  <h4 class="card-title"><?=$judul?></h4>
						  </div>
						</div>
                      </div>
					  <?php
					  if($this->session->userdata('userlevel')=='1'){
						  ?>
					  <div class="col-3"><button type='button' class='btn btn-info tambah' >Tambah Inventory Barang</button></div>					  
					  <div class="col-9"></div>
						  <?php
					  }
					 // print_r($barang);
					  //print_r($this->session->all_userdata());
					  ?>
					  <div class="col-12"></div>
						<hr>					  
						<div class="col-2">Nama Barang</div>					  
							<div class="col-4"><?=$barang->nama_barang?></div>					  
						<div class="col-2">Nomor Registrasi</div>					  
							<div class="col-4"><?=$barang->registered_number?></div>					  
						<div class="col-2">Kondisi</div>					  
							<div class="col-4"><?=$barang->kondisi?></div>					  
						<div class="col-2">Penanggung Jawab</div>					  
							<div class="col-4"><?=isset($barang->username) ? $barang->username : '-	'?></div>					  
						
					  <input type='hidden' id='id_detail_barang' value='<?=$barang->id_detail_barang?>'>
					  <div class="col-12">
                          <table id='datatableberita' class="table table-bordered table-striped" width='100%'>		
							<thead>
								<tr>
									<th align='center' width='5%'>No</th>	
									<th align='center' width='20%'>Nama Barang</th>
									<th align='center' width='15%'>No Register</th>
									<th align='center' width='20%'>Penanggung Jawab</th>
									<th align='center' width='25%'>Kondisi</th>
									<th align='center'  width='30%'>Tanggal</th>
									<th align='center'  width='30%'>Detail</th>
									<!--<th align='center'  width='30%'>Detail</th>-->
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						<script>
						$(document).ready(function() {
						   table = $('#datatableberita').DataTable({
								"processing": true, //Feature control the processing indicator.
							"serverSide": true, //Feature control DataTables' server-side processing mode.
							"order": [], //Initial no order.

							// Load data for the table's content from an Ajax source
								"ajax": {
								"url": "<?=site_url('Barang/ajax_list_history')?>",
								"type": "POST",
								"data": function ( d ) {
									d.id_detail_barang = $("#id_detail_barang").val();
								}
							},

							//Set column definition initialisation properties.
							"columnDefs": [
							{ 
								"targets": [ 0 ], //first column / numbering column
								"orderable": false, //set not orderable
							},
							],
							});
							
							
						});
						</script>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
<div id="modal_form" class="modal" data-width="600">
	<div id="tampil_form"></div>
</div>

<script>				
	$(document).on('click','.tambah',function(){
					$('#tampil_form').load("<?=site_url()?>/Barang/form_barang_history"+ "/"+ $("#id_detail_barang").val(),function(){
					$('#modal_form').modal('show');
					});
				});
	$(document).on('click','.detail',function(){
		$('#tampil_form').load("<?=site_url()?>/Barang/detail_log/"+ $(this).attr('id'),function(){
			$('#modal_form').modal('show');
		});
	});
	
	$(document).on('click', '.detailuser', function () {
		location.href = '<?= site_url() ?>/Barang/detailuser/'  + $(this).attr('id');
	});
	$(document).on('click', '.detailreg', function () {
		location.href = '<?= site_url() ?>/Barang/detailreg/'  + $(this).attr('id');
	});
	
</script>