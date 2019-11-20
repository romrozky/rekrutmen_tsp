<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master extends CI_Controller {
	public function __construct() {
        parent::__construct();
		if(!$this->session->userdata('userlevel')){
			redirect();							
		}
		if($this->session->userdata('userlevel')==4){
			redirect();										
		}
    }
	
	
	public function index() {
		redirect();
	}
	
	
	function hapus_cabang($iduser){
		$this->Db_model->update('user',array('status' => 2),array('sha1(id)' => $iduser));
		?>
		<script>
		alert('Pengguna berhasil dibekukan');
		window.location.href='<?=site_url('user')?>';
		</script>
		<?php
	}
	
	function main_cabang(){
		if($this->session->userdata('userlevel') != 1){
			redirect();
		}
		$data['judul'] = "Pengaturan Data Cabang";
		$this->load->view('layout/header', $data);
		$this->load->view('master/main_cabang',$data);
		$this->load->view('layout/footer');
	}
	
	
	function ajax_list_cabang(){
		$this->load->model('Master_model');
		$list = $this->Master_model->get_datatables_cabang();
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
	//			<button class='btn btn-success detail' id='".sha1($rows->id)."'>Detail</button>
//				<button class='btn btn-danger hapus' id='".sha1($rows->id)."'>Hapus</button>
				
			$row[] = $no;
			$row[] = isset($rows->nama_cabang) ? $rows->nama_cabang : '-';
			$row[] = isset($rows->alamat_cabang) ? $rows->alamat_cabang : '-';							
			$row[] = $datahm;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => isset($_POST['draw']) ? $_POST['draw'] : 0,
						"recordsTotal" => $this->Master_model->count_all_cabang(),
						"recordsFiltered" => $this->Master_model->count_filtered_cabang(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	function form_cabang($id_cabang='0'){
		$q = $this->Db_model->get('master_cabang','*',['sha1(id)' => $id_cabang]);
		$data['isi'] = $q->row();
		$data['ref'] = $id_cabang;
		$this->load->view('master/modal_cabang',$data);
	}
	
	function simpan_cabang(){
		$json['status']	= "gagal";
		$json['alert']	= "gagal";
		$json['link']	= site_url('Master/main_cabang');
		$ref			= $this->input->post('ref');
		if(!$this->input->post('nama_cabang')){
			$json['alert']	= "Nama cabang harus diisi";
			echo json_encode($json);exit;	
		}
		$master_cabang['nama_cabang']	= $this->input->post('nama_cabang',true);
		$where = array_merge($master_cabang,['sha1(id) <>' => $ref]);
		$z = $this->Db_model->get('master_cabang','id',$where);
		if($z->num_rows()>0){
			$json['alert']	= "Nama cabang sudah ada";
			echo json_encode($json);exit;
		}
		if(!$this->input->post('alamat_cabang')){
			$json['alert']	= "Alamat cabang harus diisi";
			echo json_encode($json);exit;
		}
		$master_cabang['alamat_cabang']	= $this->input->post('alamat_cabang',true);
		if($ref==0){
			if($this->Db_model->add('master_cabang',$master_cabang)){
				$json['status']	= "berhasil";
				$json['alert']	= "Data cabang berhasil ditambahkan";		
				echo json_encode($json);exit;
			}			
		}else{
			if($this->Db_model->update('master_cabang',$master_cabang,['sha1(id)' => $ref])){
				$json['status']	= "berhasil";
				$json['alert']	= "Data cabang berhasil diubah";		
				echo json_encode($json);exit;
			}
		}
	}
	
	function main_pengguna(){
		$data['judul'] = "Pengaturan Pengguna";
		$this->load->view('layout/header', $data);
		$this->load->view('master/main_pengguna',$data);
		$this->load->view('layout/footer');
	}
	
	function ajax_list_pengguna(){
		$this->load->model('Master_model');
		$list = $this->Master_model->get_datatables_pengguna();
		//$query = $this->db->last_query();
		$data = array();
		$no = 1;
		if(isset($_POST['start'])){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();
				
				$datahm = "
				<button class='btn btn-info edit' id='".md5($rows->id)."'>Edit</button>
				";
				if($rows->userlevel=='User'){
					$datahm = $datahm."<button class='btn btn-success detail' id='".sha1($rows->id)."'>Detail Inventory</button>
				";					
				}
			if($rows->status==1){
				$datahm = $datahm."<button class='btn btn-danger hapus' id='".md5($rows->id)."'>Non Aktifkan</button>";
			}else{
				$datahm = $datahm."<button class='btn btn-warning nyala' id='".md5($rows->id)."'>Aktifkan</button>";				
			}
			if($this->session->userdata('userlevel')>1){
				if($rows->userlevel=='User'){
					$datahm = "<button class='btn btn-success detail' id='".sha1($rows->id)."'>Detail Inventory</button>";					
				}else{
					$datahm = "-";										
				}
			}	
			$row[] = $no;
			$row[] = isset($rows->username) ? $rows->username : '-';
			$row[] = isset($rows->userlevel) ? $rows->userlevel : '-';							
			$row[] = isset($rows->nama_cabang) ? $rows->nama_cabang : '-';							
			$row[] = $datahm;
			$data[] = $row;
			$no++;
		}
		$output = array(
						//"query" => $query,
						"draw" => isset($_POST['draw']) ? $_POST['draw'] : 0,
						"recordsTotal" => $this->Master_model->count_all_pengguna(),
						"recordsFiltered" => $this->Master_model->count_filtered_pengguna(),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
	function form_pengguna($id_user='0'){
		$q = $this->Db_model->get('user','*',['md5(id)' => $id_user]);
		$data['isi'] = $q->row();
		$data['ref'] = $id_user;
		$data['opsi_cabang'] = $this->Db_model->get('master_cabang');
		$data['opsi_userlevel'] = $this->Db_model->get('userlevel','*',['id > ' => 1]);
		$this->load->view('master/modal_pengguna',$data);
	}
	
	function simpan_pengguna(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('master/main_pengguna');
		$ref			= $this->input->post('ref');
		if($ref!=0){
			$q = $this->Db_model->get('user','*',array('md5(id)' => $ref))->row();			
		}
		$password = sha1(sha1(md5($this->input->post('password'))));
		$data = array('status' => $this->input->post('status'));
		$data['userlevel'] = $this->input->post('userlevel');
		
		if($this->input->post('password1')){
			if(strlen($this->input->post('password1')) < 6){
				$json['alert'] 	= 'Panjang password baru minimal 6 karakter';
				echo json_encode($json);
				exit;
			}
			if($this->input->post('password2') !=  $this->input->post('password1')){
				$json['alert'] 	= 'Kombinasi password baru tidak sama';
				echo json_encode($json);
				exit;
			}
			$data['password'] = sha1(sha1(md5($this->input->post('password1'))));
			$userpinref['flag_lupa_pin'] = 0;
			$userpinref['salah_pin'] = 0;

		}

		if($this->input->post('username')){
			$z = $this->Db_model->get('user','id',array('md5(id) <>' => $ref, 'username' => $this->input->post('username')));
			if($z->num_rows()>0){
				$json['alert'] 	= 'Username sudah dipakai';
				echo json_encode($json);
				exit;
			}
			$data['username'] = $this->input->post('username');			
		}else{
			$json['alert'] 	= 'Username harus diisi';
			echo json_encode($json);
			exit;
		}
		
		if(!$this->input->post('userlevel')){
			$json['alert'] 	= 'Userlevel harus diisi';
			echo json_encode($json);
			exit;
		}
		$data['userlevel'] = $this->input->post('userlevel');

	if(!$this->input->post('cabang')){
			$json['alert'] 	= 'Cabang harus diisi';
			echo json_encode($json);
			exit;
		}
		$data['cabang'] = $this->input->post('cabang');		
		
		if(!$this->input->post('status')){
			$json['alert'] 	= 'Status harus diisi';
			echo json_encode($json);
			exit;
		}
		if($ref=='0'){
			if($this->Db_model->add('user',$data)){
						$json['status'] = 'berhasil';
						$json['alert']  = "Data berhasil disimpan";
						echo json_encode($json);
						exit;
					
			}
		}else{
			if($this->Db_model->update('user',$data,array('md5(id)' => $ref))){
				//$this->Db_model->update('data_pin_ref',$userpinref,['md5(id_user)' => $ref]);
						$json['status'] = 'berhasil';
						$json['alert']  = "Data berhasil disimpan";
						echo json_encode($json);
						exit;
					
			}
			
		}
	}
	
	function hapus_pengguna($md5iduser){
		$this->Db_model->update('user',array('status' => 2),array('md5(id)' => $md5iduser));
		?>
		<script>
		alert('Pengguna berhasil dibekukan');
		window.location.href='<?=site_url('master/main_pengguna')?>';
		</script>
		<?php
	}
	
	function nyalakan_pengguna($md5iduser){
		$this->Db_model->update('user',array('status' => 1),array('md5(id)' => $md5iduser));
		?>
		<script>
		alert('Pengguna berhasil diaktifkan');
		window.location.href='<?=site_url('master/main_pengguna')?>';
		</script>
		<?php
	}
	
	
	
}

?>
