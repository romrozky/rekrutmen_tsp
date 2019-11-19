<script src="<?=base_url('assets/select2')?>/select2.min.js"></script>
<script src="<?=base_url('assets/')?>/mce/tinymce.min.js"></script>
<link rel="stylesheet" href="<?=base_url('assets/select2')?>/select2.min.css">
<script>tinymce.init({ selector:'textarea' });</script>
<div class='container'>
<div class="modal-dialog modal-lg">
		<div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">History Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
		<form id='xyz'>
        <div class="modal-body">
		<?php 	
		//print_r($detail_barang);
		?>
          <table border='0' width='100%'>
			<tr>
				<td>Jenis Barang</td>
				<td>
					<input type='text' class='form-control' readonly value='<?=isset($detail_barang->jenis_barang) ? $detail_barang->jenis_barang : '-'?>'>
				</td>
			</tr>
			<tr>
				<td>Nama Barang</td>
				<td>
					<input type='text' class='form-control' readonly value='<?=isset($detail_barang->nama_barang) ? $detail_barang->nama_barang : '-'?>'>
				</td>
			</tr>
			<tr>
				<td>Nomor Register</td>
				<td>
					<input type='text' class='form-control' readonly value='<?=isset($detail_barang->registered_number) ? $detail_barang->registered_number : '-'?>'>
				</td>
			</tr>			
			<tr>
				<td>Penanggung Jawab</td>
				<td>
					<input type='text' class='form-control' readonly value='<?=isset($detail_barang->username) ? $detail_barang->username : '-'?>'>
				</td>
			</tr>
			<tr>
				<td>Kondisi</td>
				<td>
					<input type='text' class='form-control' readonly value='<?=isset($detail_barang->kondisi) ? $detail_barang->kondisi : '-'?>'>					
				</td>
			</tr>
			<tr>
				<td>Pengisi Data</td>
				<td>
					<input type='text' class='form-control' readonly value='<?=isset($detail_barang->username2) ? $detail_barang->username2 : '-'?>'>					
				</td>
			</tr>
			<tr>
				<td>Tanggal Pengisian Data</td>
				<td>
					<input type='text' class='form-control' readonly value='<?=isset($detail_barang->tanggal) ? $this->convertion->mysql_date_2_views($detail_barang->tanggal) : '-'?>'>					
				</td>
			</tr>
			
			<tr valign='top'>
				<td>Catatan</td>
				<td>
					<?=isset($detail_barang->catatan) ? $detail_barang->catatan : ''?>
				</td>
			</tr>
			<tr valign='top'>
				<td>Upload Gambar</td>
				<td>
					<?=(isset($detail_barang->url_gambar) and $detail_barang->url_gambar!="")? "<img width='300px' height='auto' src='".$detail_barang->url_gambar."'>" : '-'?>
				</td>
			</tr>

		  </table>
        </div>
        <div class="modal-footer">
		  <input type='hidden' name='detail_barang' value='<?=$detail_barang->id?>'>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
		</form>
		
      </div>
      </div>
      </div>
	  <script>
		
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
	