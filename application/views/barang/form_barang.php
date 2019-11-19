<script src="<?=base_url('assets/select2')?>/select2.min.js"></script>
<script src="<?=base_url('assets/')?>/mce/tinymce.min.js"></script>
<link rel="stylesheet" href="<?=base_url('assets/select2')?>/select2.min.css">
<script>tinymce.init({ selector:'textarea' });</script>
<div class='container'>
<div class="modal-dialog modal-lg">
		<div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Jenis Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
		<form id='xyz'>
        <div class="modal-body">
		<?php
		//print_r($row);
		?>
          <table border='0' width='100%'>
			<tr>
				<td>Jenis Barang</td>
				<td>
					<select class='form-control' name='id_jenis'>
						<option value='0'> Pilih Jenis</option>
						<?php
						foreach($opsi_jenis->result() as $aa => $bb){
							?>
							<option value='<?=$bb->id?>' <?=(isset($isi->id_jenis_barang) OR $idjenis!=0) ? 'selected' : ''?>> <?=$bb->jenis_barang?></option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Nama Barang</td>
				<td>
					<input type='text' name='nama_barang' placeholder='Nama Barang' class='form-control' value='<?=isset($isi->nama_barang) ? $isi->nama_barang : ''?>' >
				</td>
			</tr>
			<tr>
				<td>Deskripsi</td>
				<td>
					<textarea name='deskripsi'><?=isset($isi->deskripsi) ? $isi->deskripsi : ''?>
					</textarea>
				</td>
			</tr>
			

		  </table>
        </div>
        <div class="modal-footer">
		  <input type='hidden' name='ref' value='<?=$ref?>'>
		  <input type='hidden' name='idjenis' value='<?=$idjenis?>'>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info" id='simpan'>Simpan</button>
        </div>
		</form>
		<script>
	$(document).ready(function (e) {
	$("#xyz").on('submit',(function(e) {
		$("#modal_loader").show();
		e.preventDefault();
		$.ajax({
        	url: "<?=site_url()?>/Barang/simpan_barang",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			dataType: 'json',
			processData:false,
			success: function(respon){
				if (respon.status == 'berhasil') {
                            alert(respon.alert);
							window.location.href = respon.link;
                     
                        } else {
                            alert(respon.alert);
							$("#modal_loader").hide();
                        }
				},
		  	error: function() 
	    	{
				alert('Gagal simpan data');
				$("#modal_loader").hide();
	    	}	        
	   });
	}));
	});
	</script>
      </div>
      </div>
      </div>
	  <script>
		$(document).on('change','#jenis',function(){
						$('#asw').load("<?=site_url('News/opsi_sasaran')?>/" + $('#jenis').val() + "/",function(){
							 $("#asw").html(data);
						});					
					});	  
	</script>
	<div id="modal_loader" class="modal" data-width="600">
		<div class="loader"></div>
	<style>
#modal_loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
	