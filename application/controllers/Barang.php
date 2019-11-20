<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barang extends CI_Controller {
	public function __construct() {
        parent::__construct();
		if(!$this->session->userdata('userlevel')){
			redirect();							
		}
    }
	
	
	function index() {
		redirect();
	}
	
	function main_jenis(){
		$data['judul'] = "Pengaturan Jenis Barang";
		$this->load->view('layout/header', $data);
		$this->load->view('barang/main_jenis',$data);
		$this->load->view('layout/footer');
	}
	
	
	function ajax_list_jenis(){
		$this->load->model('Barang_model');
		$list = $this->Barang_model->get_datatables_jenis();
		$data = array();
		$no = 1;
		if(isset($_POST['start'])){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();
				
				$datahm = "
				<button class='btn btn-info edit' id='".sha1($rows->id)."'>Edit</button>
				";
				if($this->session->userdata('userlevel')==4){
					$datahm = "-";
				}
				if($this->session->userdata('userlevel')==2){
					$datahm = "<button class='btn btn-success detail' id='".sha1($rows->id)."'>Detail</button>
				";
				}
				
			$row[] = $no;
			$row[] = isset($rows->jenis_barang) ? $rows->jenis_barang : '-';
			$row[] = $datahm;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => isset($_POST['draw']) ? $_POST['draw'] : 0,
						"recordsTotal" => $this->Barang_model->count_all_jenis(),
						"recordsFiltered" => $this->Barang_model->count_filtered_jenis(),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
	function form_jenis($idjenis='0'){
		$q = $this->Db_model->get('master_jenis_barang','*',['sha1(id)' => $idjenis]);
		$data['isi'] = $q->row();
		$data['ref'] = $idjenis;
		$this->load->view('barang/form_jenis',$data);
	}
	
	function simpan_jenis(){
		$json['status']	= "gagal";
		$json['alert']	= "gagal";
		$json['link']	= site_url('barang/main_jenis');
		$ref = $this->input->post('ref');
		if(!$this->input->post('jenis_barang')){
			$json['alert']	= "Jenis barang harus diisi";
			echo json_encode($json);exit;
		}
		$data['jenis_barang']	= $this->input->post('jenis_barang',true);
		$where = array_merge($data,['sha1(id) <>' => $ref]);
		$q = $this->Db_model->get('master_jenis_barang','id',$where);
		if($q->num_rows()>0){
			$json['alert']	= "Jenis barang sudah ada";
			echo json_encode($json);exit;
		}
		if($ref==0){
			if($this->Db_model->add('master_jenis_barang',$data)){
				$json['status']	= "berhasil";
				$json['alert']	= "Jenis barang berhasil ditambah";
				echo json_encode($json);exit;
			}
		}else{
			if($this->Db_model->update('master_jenis_barang',$data,['sha1(id)' => $ref])){
				$json['status']	= "berhasil";
				$json['alert']	= "Jenis barang berhasil diubah";
				echo json_encode($json);exit;
			}
		}		
	}
	
	function detail_jenis($idjenis='-'){
		$q = $this->Db_model->get('master_jenis_barang','*',['sha1(id)' => $idjenis]);
		if($q->num_rows()<1){
			?>
			<script>
			alert('Data tak ditemukan');
			window.location.href='<?=site_url('barang/main_jenis')?>';
			</script>
			<?php
		}
		$data['hash']	= $q->row()->id;
		$data['judul'] = "Detail Jenis Barang";
		$this->load->view('layout/header', $data);
		$this->load->view('barang/detail_jenis',$data);
		$this->load->view('layout/footer');
	}
	
	function ajax_list_barang(){
//		print_r($this->session->all_userdata());
		$this->load->model('Barang_model');
		$list = $this->Barang_model->get_datatables_barang();
		$query = $this->db->last_query();
		$data = array();
		$no = 1;
		if(isset($_POST['start'])){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();
				
				$datahm = "
				<button class='btn btn-info edit' id='".sha1($rows->id)."'>Edit</button>
				<button class='btn btn-success detail' id='".sha1($rows->id)."'>Detail</button>
				";
				if($this->session->userdata('userlevel')==4){
					$datahm = "<button class='btn btn-success detail' id='".sha1($rows->id)."'>Detail</button>
				";
				}
				if($this->session->userdata('userlevel')==2){
					$datahm = "<button class='btn btn-success detail' id='".sha1($rows->id)."'>Detail</button>
				";
				}
				
//				if($this->session->userdata(''))
			$row[] = $no;
			$row[] = isset($rows->jenis_barang) ? $rows->jenis_barang : '-';
			$row[] = isset($rows->nama_barang) ? $rows->nama_barang : '-';
			$row[] = $datahm;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"query" => $query,
						"draw" => isset($_POST['draw']) ? $_POST['draw'] : 0,
						"recordsTotal" => $this->Barang_model->count_all_barang(),
						"recordsFiltered" => $this->Barang_model->count_filtered_barang(),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
	function form_barang($idjenis='0',$idbarang='0'){
		$q = $this->Db_model->get('barang','*',['sha1(id)' => $idbarang]);
		$data['isi'] = $q->row();
		$data['idjenis'] = $idjenis;
		$data['ref'] = $idbarang;
		if($idjenis==0){
			$data['opsi_jenis']	= $this->Db_model->get('master_jenis_barang');			
		}else{
			$data['opsi_jenis']	= $this->Db_model->get('master_jenis_barang','*',['id' => $idjenis]);						
		}
		$this->load->view('barang/form_barang',$data);
	}
	
	function simpan_barang(){
		$json['status']	= "gagal";
		$json['alert']	= "gagal";
		$idjenis = $this->input->post('idjenis');
		if($idjenis==0){
			$json['link']	= site_url('barang/main_barang');			
		}else{
			$json['link']	= site_url('barang/detail_jenis/'.sha1($idjenis));						
		}
		$ref = $this->input->post('ref');
		if(!$this->input->post('id_jenis')){
			$json['alert']	= "Jenis barang harus dipilih";
			echo json_encode($json);exit;
		}
		$data['id_jenis_barang']	= $this->input->post('id_jenis',true);
		
		if(!$this->input->post('nama_barang')){
			$json['alert']	= "Nama barang harus diisi";
			echo json_encode($json);exit;
		}
		$data['nama_barang']	= $this->input->post('nama_barang',true);
		
		$where = array_merge($data,['sha1(id) <>' => $ref]);
		$q = $this->Db_model->get('barang','id',$where);
		if($q->num_rows()>0){
			$json['alert']	= "Barang sudah ada";
			echo json_encode($json);exit;
		}
		
		if(!$this->input->post('deskripsi')){
			$json['alert']	= "Deskripsi barang harus diisi";
			echo json_encode($json);exit;
		}
		$data['deskripsi']	= $this->input->post('deskripsi',true);		
		
		if($ref==0){
			if($this->Db_model->add('barang',$data)){
				$json['status']	= "berhasil";
				$json['alert']	= "Barang berhasil ditambah";
				echo json_encode($json);exit;
			}
		}else{
			if($this->Db_model->update('barang',$data,['sha1(id)' => $ref])){
				$json['status']	= "berhasil";
				$json['alert']	= "Barang berhasil diubah";
				echo json_encode($json);exit;
			}
		}
	}
	
	function main_barang(){		
		$data['judul'] = "Data Barang";
		$this->load->view('layout/header', $data);
		$this->load->view('barang/main_barang',$data);
		$this->load->view('layout/footer');
	}
	
	function detail_barang($idbarang='-'){		
		$q = $this->Db_model->get('barang','*',['sha1(id)' => $idbarang]);
		if($q->num_rows()<1){
			?>
			<script>
			alert('Data tak ditemukan');
			window.location.href='<?=site_url('barang/main_barang')?>';
			</script>
			<?php
		}
		$data['hash']	= $q->row()->id;
		$data['judul'] = "Data Inventory Barang";
		$this->load->view('layout/header', $data);
		$this->load->view('barang/detail_barang',$data);
		$this->load->view('layout/footer');
	}
	
	function ajax_list_detail_barang(){
		//print_r($this->input->post());
		$this->load->model('Barang_model');
		$list = $this->Barang_model->get_datatables_barang_detail();
		$query = $this->db->last_query();
//		print_r($list);
		$data = array();
		$no = 1;
		if(isset($_POST['start'])){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();
				
				$datahm = "
				<button class='btn btn-info edit' id='".sha1($rows->id)."'>Edit</button>
				";
				if($this->session->userdata('userlevel')==4){
					$datahm = "-";
				}
				if($this->session->userdata('userlevel')==2){
					$datahm = "<button class='btn btn-success detailreg' id='".sha1($rows->id)."'>Detail</button>
				";
				}
			$row[] = $no;
			$row[] = isset($rows->nama_barang) ? $rows->nama_barang : '-';
			$row[] = isset($rows->registered_number) ? "<span class='detailreg' style='cursor: pointer;' id='".sha1($rows->id_detail_barang)."'>".$rows->registered_number."</span>" : '-';
			$row[] = isset($rows->username) ? "<span class='detailuser' style='cursor: pointer;' id='".sha1($rows->id_user)."'>".$rows->username."</span>" : '-';			
			$row[] = isset($rows->kondisi) ? $rows->kondisi : '-';
			$row[] = $datahm;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"query" => $query,
						"draw" => isset($_POST['draw']) ? $_POST['draw'] : 0,
						"recordsTotal" => $this->Barang_model->count_all_barang_detail(),
						"recordsFiltered" => $this->Barang_model->count_filtered_barang_detail(),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
	function form_barang_detail($idbarang='0',$iddetail='0'){
		$q = $this->Db_model->get('detail_barang','*',['sha1(id)' => $iddetail]);
		$data['isi'] = $q->row();
		$data['idbarang'] = $idbarang;
		$data['ref'] = $iddetail;
		if($idbarang==0){
			$data['opsi_barang']	= $this->Db_model->get('barang');			
		}else{
			$data['opsi_barang']	= $this->Db_model->get('barang','*',['id' => $idbarang]);						
		}
		$data['opsi_kondisi']	= $this->Db_model->get('kondisi');			
		$this->load->view('barang/form_barang_detail',$data);
	}
	
	function simpan_barang_detail(){
		$json['status']	= "gagal";
		$json['alert']	= "gagal";
		$idbarang = $this->input->post('idbarang');
		if($idbarang==0){
			$json['link']	= site_url('barang/main_barang');			
		}else{
			$json['link']	= site_url('barang/detail_barang/'.sha1($idbarang));						
		}
		$ref = $this->input->post('ref');
		
		if(!$this->input->post('id_barang')){
			$json['alert'] = "Barang harus dipilih";
			echo json_encode($json);exit;
		}
		$data['id_barang']	= $this->input->post('id_barang');
		
		if(!$this->input->post('registered_number')){
			$json['alert'] = "Nomor Register harus diisi";
			echo json_encode($json);exit;
		}
		$q = $this->Db_model->get('detail_barang','id',['registered_number' => $this->input->post('registered_number'), 'sha1(id) <>' => $ref]);
		if($q->num_rows()>0){
			$json['alert'] = "Nomor Register sudah dipakai";
			echo json_encode($json);exit;
		}
		$data['registered_number'] = $this->input->post('registered_number');
		
		if(!$this->input->post('kondisi')){
			$json['alert'] = "Kondisi harus dipilih";
			echo json_encode($json);exit;
		}
		$data['kondisi']	= $this->input->post('kondisi');
		$data2['kondisi']	= $this->input->post('kondisi');
		
		if(!$this->input->post('deskripsi')){
			$json['alert'] = "Catatan harus diisi";
			echo json_encode($json);exit;
		}
		$data['catatan']	= $this->input->post('deskripsi');
		$data['last_update']	= date('Y-m-d H:i:s');
		
		$data2['catatan']	= $this->input->post('deskripsi');
		$data2['tanggal`']	= date('Y-m-d H:i:s');
		$data2['id_user`']	= $this->session->userdata('id_user');		
		if($ref==0){
			if($this->Db_model->add('detail_barang',$data)){
				$id_detail_barang = $this->db->insert_id();
				$data2['id_detail_barang'] = $id_detail_barang;
				if($this->Db_model->add('log_detail_barang',$data2)){
					$json['status']	= 'berhasil';
					$json['alert']	= 'Data berhasil ditambah';
					echo json_encode($json);exit;
				}
			}
		}else{
			if($this->Db_model->update('detail_barang',$data,['sha1(id)' => $ref])){
				$id_detail_barang = $this->Db_model->get('detail_barang','id',['sha1(id)' => $ref])->row()->id;
				$data2['id_detail_barang'] = $id_detail_barang;
				if($this->Db_model->add('log_detail_barang',$data2)){
					$json['status']	= 'berhasil';
					$json['alert']	= 'Data berhasil diubah';
					echo json_encode($json);exit;
				}
			}
		}
	}
	
	function main_history(){
		$data['judul'] = "History Barang";
		$this->load->view('layout/header', $data);
		$this->load->view('barang/main_history',$data);
		$this->load->view('layout/footer');
	}
	
	function form_history(){
		$data['opsi_kondisi']	= $this->Db_model->get('kondisi');			
		$this->load->view('barang/form_history',$data);
	}
	
	
	function ajax_list_history(){
		$this->load->model('Barang_model');
		$list = $this->Barang_model->get_datatables_barang_history();
		$query = $this->db->last_query();
//		print_r($list);
		$data = array();
		$no = 1;
		if(isset($_POST['start'])){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();
				
				$datahm = "
				<button class='btn btn-success detail' id='".sha1($rows->id)."'>Detail</button>
				";
				
			$row[] = $no;
			$row[] = isset($rows->nama_barang) ? $rows->nama_barang : '-';
			$row[] = isset($rows->registered_number) ? "<span class='detailreg' style='cursor: pointer;' id='".sha1($rows->id_detail_barang)."'>".$rows->registered_number."</span>" : '-';
			$row[] = isset($rows->username) ? "<span class='detailuser' style='cursor: pointer;' id='".sha1($rows->id_user)."'>".$rows->username."</span>" : '-';
			$row[] = isset($rows->kondisi) ? $rows->kondisi : '-';
			$row[] = isset($rows->tanggal) ? $rows->tanggal : '-';
			$row[] = $datahm;
			$data[] = $row;
			$no++;
		}
		$output = array(
	//					"query" => $query,
						"draw" => isset($_POST['draw']) ? $_POST['draw'] : 0,
						"recordsTotal" => $this->Barang_model->count_all_barang_history(),
						"recordsFiltered" => $this->Barang_model->count_filtered_barang_history(),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
	function detailreg($reg='-'){
		$this->db->select('barang.nama_barang, detail_barang.id, detail_barang.registered_number, detail_barang.id id_detail_barang, user.username, user.id id_user, kondisi.kondisi');
		$this->db->where('sha1(detail_barang.id)',$reg);
		$this->db->join('barang','barang.id = detail_barang.id_barang');
		$this->db->join('master_jenis_barang','master_jenis_barang.id = barang.id_jenis_barang');
		$this->db->join('user','user.id = detail_barang.owner','left');
		$this->db->join('kondisi','kondisi.id = detail_barang.kondisi','left');
		$a = $this->db->get('detail_barang');
		//$a = $this->Db_model->get('detail_barang','*',['sha1(detail_barang.id)' => $reg]);
		if($a->num_rows()<1){
			?>
			<script>
			alert('Data tak ditemukan');
			window.location.href='<?=site_url('barang/main_barang')?>';
			</script>
			<?php
		}
		$data['hash']	= $a->row()->id;
		$data['barang']	= $a->row();
		$data['judul'] = "Data Inventory Barang";
		$this->load->view('layout/header', $data);
		$this->load->view('barang/detailreg',$data);
		$this->load->view('layout/footer');
	}
	
	function form_barang_history($id_detail_barang){
		$data['detail_barang'] = $this->Db_model->get('detail_barang','*',['id' => $id_detail_barang])->row();
		$data['opsi_kondisi']	= $this->Db_model->get('kondisi');					
		$this->load->view('barang/form_barang_history',$data);
	}
	
	function load_jenis_barang(){
		$key = $_GET['q'];
		$where = "jenis_barang LIKE '%".$key."%'";
		$xxx = $this->Db_model->get('master_jenis_barang','id,jenis_barang',$where);
//		echo $this->db->last_query();
		$data = array();
		foreach($xxx->result() as $isi){
			$row = array();
			$row['id'] = $isi->id;
			$row['text'] = $isi->jenis_barang;
			$data[] = $row;
		}
		$output = array(
					$data
					);
		echo json_encode($data);
	}
	
	function load_barang($idjenis){
		$key = $_GET['q'];
		$where = "nama_barang LIKE '%".$key."%' AND id_jenis_barang = ".$idjenis."";
		$xxx = $this->Db_model->get('barang','id,nama_barang',$where);
//		echo $this->db->last_query();
		$data = array();
		foreach($xxx->result() as $isi){
			$row = array();
			$row['id'] = $isi->id;
			$row['text'] = $isi->nama_barang;
			$data[] = $row;
		}
		$output = array(
					$data
					);
		echo json_encode($data);
	}
	
	function load_detail_barang($iddetail){
		$key = $_GET['q'];
		$where = "registered_number LIKE '%".$key."%' AND id_barang =".$iddetail." ";
		$xxx = $this->Db_model->get('detail_barang','id,registered_number',$where);
		$data = array();
		foreach($xxx->result() as $isi){
			$row = array();
			$row['id'] = $isi->id;
			$row['text'] = $isi->registered_number;
			$data[] = $row;
		}
		$output = array(
					$data
					);
		echo json_encode($data);
	}
	
	function load_username(){
		$key = $_GET['q'];
		$where = "username LIKE '%".$key."%' AND userlevel = 4 AND cabang = ".$this->session->userdata('cabang')."";
		$xxx = $this->Db_model->get('user','id,username',$where);
		$data = array();
		foreach($xxx->result() as $isi){
			$row = array();
			$row['id'] = $isi->id;
			$row['text'] = $isi->username;
			$data[] = $row;
		}
		$output = array(
					$data
					);
		echo json_encode($data);
	}
	
	function simpan_barang_history(){
		
		$json['status'] = 'gagal';
		$json['alert']	= 'gagal';
		$ref = $this->input->post('detail_barang'); 		
		$json['link']	= site_url('barang/detailreg/'.sha1($ref));
		
		$data2['id_detail_barang'] = $ref;
		$where['id'] = $ref;
		
		if(!$this->input->post('owner')){
			$json['alert'] = "Penanggung Jawab harus diisi";
			echo json_encode($json);exit;
		}
		$data['owner']	= $this->input->post('owner');
		$data2['owner']	= $this->input->post('owner');
		
		if(!$this->input->post('kondisi')){
			$json['alert'] = "Kondisi harus diisi";
			echo json_encode($json);exit;
		}
		$data['kondisi']	= $this->input->post('kondisi');
		$data2['kondisi']	= $this->input->post('kondisi');
		
		if(!$this->input->post('deskripsi')){
			$json['alert'] = "Catatan harus diisi";
			echo json_encode($json);exit;
		}
		$data['catatan']	= $this->input->post('deskripsi',true);
		$data2['catatan']	= $this->input->post('deskripsi',true);
		
		$data['last_update']	= date('Y-m-d H:i:s');
		$data2['tanggal']		= date('Y-m-d H:i:s');
		$data2['id_user']		= $this->session->userdata('id_user');
		
		//uploadimage
		$file = $_FILES['userImage'];
		if($file['name']){
			$path = "uploads/inventory/".date('Y').'/'.date('m');
			if(!is_dir($path)){
				mkdir($path,0777,TRUE);
				fopen($path."/index.php", "w");
			}
			$xxxx = explode('.',$file['name']);
			$ext = end($xxxx);
			$name = date('YmdHis')."".$ref."_inventory.".$ext;
			$config['file_name']		= $name;
			$config['upload_path']      = $path;
			$config['allowed_types']    = array('jpg','jpeg','gif','png');
			$config['max_size']         = 5000;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if($this->upload->do_upload('userImage')){
				$data2['url_gambar'] = base_url()."".$path.'/'.$name;
			}else{
				$json['alert'] = $this->upload->display_errors();
				echo json_encode($json);
				exit;
			}			
		}
		
		if($this->Db_model->update('detail_barang',$data,$where)){
			if($this->Db_model->add('log_detail_barang',$data2)){
				$json['status'] = 'berhasil';
				$json['alert'] 	= "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
		}	
	}
	
	function simpan_barang_history2(){
		
		$json['status'] = 'gagal';
		$json['alert']	= 'gagal';
		$json['link']	= site_url('barang/main_history/');
		
		
		if(!$this->input->post('id_detail_barang')){
			$json['alert'] = "Detail Barang harus diisi";
			echo json_encode($json);exit;
		}
		
		$ref = $this->input->post('id_detail_barang'); 		
		$data2['id_detail_barang'] = $ref;
		$where['id'] = $ref;
		
		if(!$this->input->post('owner')){
			$json['alert'] = "Penanggung Jawab harus diisi";
			echo json_encode($json);exit;
		}
		$data['owner']	= $this->input->post('owner');
		$data2['owner']	= $this->input->post('owner');
		
		if(!$this->input->post('kondisi')){
			$json['alert'] = "Kondisi harus diisi";
			echo json_encode($json);exit;
		}
		$data['kondisi']	= $this->input->post('kondisi');
		$data2['kondisi']	= $this->input->post('kondisi');
		
		if(!$this->input->post('deskripsi')){
			$json['alert'] = "Catatan harus diisi";
			echo json_encode($json);exit;
		}
		$data['catatan']	= $this->input->post('deskripsi',true);
		$data2['catatan']	= $this->input->post('deskripsi',true);
		
		$data['last_update']	= date('Y-m-d H:i:s');
		$data2['tanggal']		= date('Y-m-d H:i:s');
		$data2['id_user']		= $this->session->userdata('id_user');
		
		//uploadimage
		$file = $_FILES['userImage'];
		if($file['name']){
			$path = "uploads/inventory/".date('Y').'/'.date('m');
			if(!is_dir($path)){
				mkdir($path,0777,TRUE);
				fopen($path."/index.php", "w");
			}
			$xxxx = explode('.',$file['name']);
			$ext = end($xxxx);
			$name = date('YmdHis')."".$ref."_inventory.".$ext;
			$config['file_name']		= $name;
			$config['upload_path']      = $path;
			$config['allowed_types']    = array('jpg','jpeg','gif','png');
			$config['max_size']         = 5000;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if($this->upload->do_upload('userImage')){
				$data2['url_gambar'] = base_url()."".$path.'/'.$name;
			}else{
				$json['alert'] = $this->upload->display_errors();
				echo json_encode($json);
				exit;
			}			
		}
		
		if($this->Db_model->update('detail_barang',$data,$where)){
			if($this->Db_model->add('log_detail_barang',$data2)){
				$json['status'] = 'berhasil';
				$json['alert'] 	= "Data berhasil disimpan";
				echo json_encode($json);
				exit;
			}
		}	
	}
	
	function detail_log($sha1idlog='-'){
		$this->db->select('	barang.nama_barang,
							detail_barang.id,
							detail_barang.id id_detail_barang,
							detail_barang.registered_number,
							user.username,
							user2.username username2,
							user.id id_user,
							log_detail_barang.tanggal tanggal,
							log_detail_barang.catatan,
							log_detail_barang.url_gambar,
							kondisi.kondisi,
							master_jenis_barang.jenis_barang,
							'
							);
		$this->db->where('sha1(log_detail_barang.id)',$sha1idlog);				
		$this->db->join('detail_barang','detail_barang.id = log_detail_barang.id_detail_barang');
		$this->db->join('barang','barang.id = detail_barang.id_barang');
		$this->db->join('master_jenis_barang','master_jenis_barang.id = barang.id_jenis_barang');
		$this->db->join('user','user.id = log_detail_barang.owner','left');
		$this->db->join('user user2','user2.id = log_detail_barang.id_user','left');
		$this->db->join('kondisi','kondisi.id = log_detail_barang.kondisi','left');
		$data['detail_barang'] = $this->db->get('log_detail_barang')->row();
		$this->load->view('barang/detail_log',$data);
	}
	
	function detailuser($reg='-'){
	//	print_r($this->session->all_userdata());
		if($this->session->userdata('userlevel')==4){
			$reg = sha1($this->session->userdata('id_user'));
		}
//		echo $reg;
		$a = $this->Db_model->get('user','id',['sha1(id)' => $reg]);
		if($a->num_rows()>0){
			$iduser = $a->row()->id;
		}else{
			$iduser = "-";			
		}
		$data['hash']	= $iduser;
		$data['judul'] = "Data Inventory Barang";
		$this->load->view('layout/header', $data);
		$this->load->view('barang/detailuser',$data);
		$this->load->view('layout/footer');
	}
	
	function downloadstatus($kondisi='-',$jenisbarang='-',$iduser='-'){		
		$this->db->select('barang.nama_barang, detail_barang.id, detail_barang.registered_number, detail_barang.id id_detail_barang, user.username, user.id id_user, kondisi.kondisi');
		if($kondisi!='-'){
			$this->db->where('detail_barang.kondisi',$kondisi);
		}
		if($jenisbarang!='-'){
			$this->db->where('barang.id_jenis_barang',$jenisbarang);
		}
		if($iduser!='-'){
			$this->db->where('detail_barang.owner',$iduser);
		}
		
		$this->db->where('user.cabang',$this->session->userdata('cabang'));
		$this->db->join('barang','barang.id = detail_barang.id_barang');
		$this->db->join('master_jenis_barang','master_jenis_barang.id = barang.id_jenis_barang');
		$this->db->join('user','user.id = detail_barang.owner','left');
		$this->db->join('kondisi','kondisi.id = detail_barang.kondisi','left');
		$this->db->from('detail_barang');
		$a = $this->db->get();
		$data['barang']	= $a->result();
		$view = $this->load->view('barang/xls_barang',$data,true);
		$namefile = "Data_Barang_".date('YmdHis').".xls";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=".$namefile);

		echo $view;exit;
		//print_r($a->result());
	}
	
	function downloadhistory($iddetail='',$iduser='-'){	
		$this->db->select('	barang.nama_barang,
							log_detail_barang.id,
							detail_barang.id id_detail_barang,
							detail_barang.registered_number,
							user.username,
							user.id id_user,
							log_detail_barang.tanggal tanggal,
							kondisi.kondisi');	
		if($iddetail!='-'){
			$this->db->where('log_detail_barang.id_detail_barang',$iddetail);
		}
		if($this->session->userdata('userlevel')==4){
			$this->db->where('log_detail_barang.owner',$this->session->userdata('id_user'));
		}
		if($iduser!='-'){
			$this->db->where('log_detail_barang.owner',$iduser);			
		}		
		$this->db->join('detail_barang','detail_barang.id = log_detail_barang.id_detail_barang');
		$this->db->join('barang','barang.id = detail_barang.id_barang');
		$this->db->join('user','user.id = log_detail_barang.owner','left');
		$this->db->join('kondisi','kondisi.id = log_detail_barang.kondisi','left');
		$this->db->from('log_detail_barang');	
		
		$a = $this->db->get();
		$data['barang']	= $a->result();
		$view = $this->load->view('barang/history',$data,true);
		echo $view;exit;
		$namefile = "Data_Barang_".date('YmdHis').".xls";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=".$namefile);

		echo $view;exit;
		//print_r($a->result());
	}
	
	
}

?>
