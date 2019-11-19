<script src="<?=base_url('assets/select2')?>/select2.min.js"></script>
<script src="<?=base_url('assets/')?>/mce/tinymce.min.js"></script>
<link rel="stylesheet" href="<?=base_url('assets/select2')?>/select2.min.css">
<script>tinymce.init({ selector:'textarea' });</script>
<div class='container'>
<div class="modal-dialog modal-lg">
		<div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Pengguna</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
		<form id='xyz'>
        <div class="modal-body">
          <table border='0' width='100%'>
			<tr>
				<td>Username</td>
				<td>
					<input type='text' name='username' id='username' placeholder='Username. hanya alfanumeric' value='<?=isset($isi->username) ? $isi->username : ''?>' class='form-control' pattern="[a-zA-Z0-9\s]+">
				</td>
			</tr>
			<tr>
				<td>Userlevel</td>
				<td>
					<select class='form-control' name='userlevel' id='userlevel'>
						<option value='0'> Pilih Userlevel </option>
						<?php
						
						foreach($opsi_userlevel->result() as $aaa => $bbb){
							?>
							<option value='<?=$bbb->id?>' <?=(isset($isi->userlevel) AND ($isi->userlevel == $bbb->id)) ? 'selected' : ''?>> <?=$bbb->userlevel?> </option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Cabang</td>
				<td>
					<select class='form-control' name='cabang'>
						<option value='0'> Pilih Cabang </option>
						<?php
						
						foreach($opsi_cabang->result() as $aa => $bb){
							?>
							<option value='<?=$bb->id?>' <?=(isset($isi->cabang) AND ($isi->cabang == $bb->id)) ? 'selected' : ''?>> <?=$bb->nama_cabang?> </option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Password Baru</td>
				<td>
					<input type='password' name='password1' placeholder='Password Baru' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Konfirmasi Password Baru</td>
				<td>
					<input type='password' name='password2' placeholder='Konfirmasi Password Baru' class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Status</td>
				<td>
					<select class='form-control' name='status'>
						<option value='0'> Pilih Status </option>
						<option value='1' <?=(isset($isi->status) AND ($isi->status == 1)) ? 'selected' : ''?>> Aktif </option>
						<option value='2' <?=(isset($isi->status) AND ($isi->status == 2)) ? 'selected' : ''?>> Tidak Aktif </option>
					</select>
				</td>
			</tr>
		  </table>
        </div>
        <div class="modal-footer">
		  <input type='hidden' name='ref' value='<?=$ref?>'>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info" id='simpan'>Simpan</button>
        </div>
		</form>
		<script>
		$('#username').bind('keypress', function (event) {
			var regex = new RegExp("^[a-zA-Z0-9\b]+$");
			var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
			if (!regex.test(key)) {
			   event.preventDefault();
			   return false;
			}
		});
	$(document).ready(function (e) {
		
	$("#xyz").on('submit',(function(e) {
		$("#modal_loader").show();
		e.preventDefault();
		$.ajax({
        	url: "<?=site_url()?>/Master/simpan_pengguna",
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
	