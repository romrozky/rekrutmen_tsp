<table border='1'>
	<tr>
		<td align='center'><b>No</b></td>
		<td align='center'><b>Nama Barang</b></td>
		<td align='center'><b>Register Number</b></td>
		<td align='center'><b>Penanggung Jawab</b></td>
		<td align='center'><b>Kondisi</b></td>
		<td align='center'><b>Tanggal</b></td>
	</tr>
	<?php
	$no = 1;
	foreach($barang as $aa => $bb){
		?>
		<tr>
			<td><?=$no?></td>
			<td><?=$bb->nama_barang?></td>
			<td><?=$bb->registered_number?></td>
			<td><?=$bb->username?></td>
			<td><?=$bb->kondisi?></td>
			<td><?=$bb->tanggal?></td>
		</tr>
		<?php
		$no++;
	}
	?>
</table>