<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct() {
        parent::__construct();
		if(!$this->session->userdata('userlevel')){
			redirect();							
		}
    }
	
	function ajax_list_nonaktif($level='-'){
		$this->load->model('User_model');
		$list = $this->User_model->get_datatables_nggak_aktif($level);
		$query = $this->db->last_query();

		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();
				
				$datahm = "
				<button class='btn btn-success detailxxx' id='".(md5($rows->id))."'>Detail Wallet</button> 
				";
				
			$status = 'Tidak Aktif';
			if($rows->status=='1'){
				$status = 'Aktif';
				$datahm = $datahm."<button class='btn btn-warning disabled' id='".sha1($rows->id)."'>Bekukan</button>";
			}elseif($rows->status=='2'){
				$status = 'Dibekukan';
				$datahm = $datahm."<button class='btn btn-success enabled' id='".sha1($rows->id)."'>Aktifkan</button>";
			}elseif($rows->status=='3'){
				$status = 'Belum diverifikasi';
				$datahm = $datahm."<button class='btn verif' id='".sha1($rows->id)."'>Verifikasi</button>";
			}
			if($this->session->userdata('userlevel')!=1){
					$datahm ="";
				}
			$arry_nggak = array(1,2,101,102);
			if(!in_array($rows->userlevel,$arry_nggak)){
			}
			$row[] = $no;
			$row[] = isset($rows->level_name) ? $rows->level_name : '-';
			if(!in_array($rows->userlevel,$arry_nggak)){
//				$row[] = isset($rows->username) ? "<button type='button' class='btn btn-success detail' id='".md5($rows->id)."'>".$rows->username."</button>" : '-';			
			}else{
			}
				$row[] = isset($rows->username) ? $rows->username : '-';							
		//	$row[] = $status." ".$rows->id;
			$row[] = $status;
			//$row[] = isset($rows->email) ? $rows->email: '-';


				$row[] = $datahm;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->User_model->count_all_nggak_aktif($level),
						"recordsFiltered" => $this->User_model->count_filtered_nggak_aktif($level),
						"data" => $data,
						//"query" => $query
				);
		echo json_encode($output);
	}
	
	function nonaktif(){
		$data['judul']	= 'Pengguna Non Aktif';

		$this->load->view('layout/header', $data);
		$this->load->view('user/main_nonaktif');
		$this->load->view('layout/footer');
	}
	
	function req_lupa_pin(){
		$data['judul']	= 'Pengguna';

		$this->load->view('layout/header', $data);
		$this->load->view('user/main');
		$this->load->view('layout/footer');
	}
	
	public function index() {
		$data['judul']	= 'Pengguna';

		$this->load->view('layout/header', $data);
		$this->load->view('user/main');
		$this->load->view('layout/footer');
	}
	
	function detailuser($x='-'){
		$array_boleh = array(3,4,5,6,98,99,103);
		if(in_array($this->session->userdata('id_level'),$array_boleh)){
			$x = md5($this->session->userdata('id_user'));
		}
		$z = $this->Db_model->get('user','id',array('md5(id)' => $x));
	//	echo $this->db->last_query();
		if($z->num_rows()<1){
			redirect('');
		}
	//	print_r($this->session->all_userdata());
		$q = $this->Db_model->get('user','user.username,user.email,user.nohp,data_pin_ref.wallet',array('user.id' => $z->row()->id),'','','','',
								array('table' => 'data_pin_ref', 'on' => 'data_pin_ref.id_user = user.id')
								);
//		echo $this->db->last_query();
		//print_r($q->row());
		$data['judul']	= 'Detail Pengguna';
		$data['x']		= $x;
		$data['q']		= $q->row();
		$this->load->view('layout/header', $data);
		$this->load->view('user/detail_user');
		$this->load->view('layout/footer');
	}
	
	function detailuserpoin($x='-'){
		$array_boleh = array(3,4,5,6,98,99,103);
		if(in_array($this->session->userdata('id_level'),$array_boleh)){
			$x = md5($this->session->userdata('id_user'));
		}
		$z = $this->Db_model->get('user','id',array('md5(id)' => $x));
	//	echo $this->db->last_query();
		if($z->num_rows()<1){
			redirect('');
		}
	//	print_r($this->session->all_userdata());
		$q = $this->Db_model->get('user','user.username,user.email,user.nohp,data_pin_ref.poin',array('user.id' => $z->row()->id),'','','','',
								array('table' => 'data_pin_ref', 'on' => 'data_pin_ref.id_user = user.id')
								);
//		echo $this->db->last_query();
		//print_r($q->row());
		$data['judul']	= 'Detail Pengguna';
		$data['x']		= $x;
		$data['q']		= $q->row();
		$this->load->view('layout/header', $data);
		$this->load->view('user/detail_userpoin');
		$this->load->view('layout/footer');
	}
	
	function disabled($iduser){
		$this->Db_model->update('user',array('status' => 2),array('sha1(id)' => $iduser));
		?>
		<script>
		alert('Pengguna berhasil dibekukan');
		window.location.href='<?=site_url('user')?>';
		</script>
		<?php
	}
	
	function resetdevice($iduser){
		$this->Db_model->update('user',array('device_id' => '', 'enkrip_token' => ''),array('sha1(id)' => $iduser));
		?>
		<script>
		alert('Device Pengguna berhasil direset');
		window.location.href='<?=site_url('user')?>';
		</script>
		<?php
	}
	
	function enabled($iduser){
		$this->Db_model->update('user',array('status' => 1),array('sha1(id)' => $iduser));
		?>
		<script>
		alert('Pengguna berhasil diaktifkan');
		window.location.href='<?=site_url('user/nonaktif')?>';
		</script>
		<?php
	}
	
	function ajax_trx_duit($level){
		$this->load->model('Trx_duit_model');
		$list = $this->Trx_duit_model->get_datatables($level);
		$query = $this->db->last_query();

		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'];
		}
		foreach ($list as $rows) {
			$row = array();
			$row[] = $no;
			$row[] = isset($rows->username) ? $rows->username : '-';
			$row[] = $this->convertion->rupiahs($rows->wallet_asal);
			$nominal = 0;
			if($rows->wallet_debit!=0){
				$nominal = "- ".$this->convertion->rupiahs($rows->wallet_debit);
			}else{
				$nominal = "".$this->convertion->rupiahs($rows->wallet_kredit);				
			}
			$row[] = $nominal;
			$row[] = isset($rows->wallet_akhir) ? $this->convertion->rupiahs($rows->wallet_akhir) : '-';
			$row[] = isset($rows->waktu) ? $rows->waktu : '-';
			$row[] = isset($rows->jenis) ? $rows->jenis : '-';
			$row[] = isset($rows->catatan) ? $rows->catatan : '-';
			
			//$row[] = isset($rows->email) ? $rows->email: '-';


//				$row[] = $datahm;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Trx_duit_model->count_all($level),
						"recordsFiltered" => $this->Trx_duit_model->count_filtered($level),
						"data" => $data,
						//"query" => $query
				);
		echo json_encode($output);
	}
	
	function ajax_trx_poin($level){
		$this->load->model('Trx_poin_model', 'Trx_duit_model');
		$list = $this->Trx_duit_model->get_datatables($level);
		$query = $this->db->last_query();

		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'];
		}
		foreach ($list as $rows) {
			$row = array();
			$row[] = $no;
			$row[] = isset($rows->username) ? $rows->username : '-';
			$row[] = $this->convertion->rupiahs($rows->poin_awal);
			$nominal = 0;
			if($rows->poin_debit!=0){
				$nominal = "- ".$this->convertion->rupiahs($rows->poin_debit);
			}else{
				$nominal = "".$this->convertion->rupiahs($rows->poin_kredit);				
			}
			$row[] = $nominal;
			$row[] = isset($rows->poin_akhir) ? $this->convertion->rupiahs($rows->poin_akhir) : '-';
			$row[] = isset($rows->waktu) ? $rows->waktu : '-';
			$row[] = isset($rows->jenis) ? $rows->jenis : '-';
			$row[] = isset($rows->catatan) ? $rows->catatan : '-';
			
			//$row[] = isset($rows->email) ? $rows->email: '-';


//				$row[] = $datahm;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Trx_duit_model->count_all($level),
						"recordsFiltered" => $this->Trx_duit_model->count_filtered($level),
						"data" => $data,
						//"query" => $query
				);
		echo json_encode($output);
	}
	
	
	function kembars($jenis = '-'){
		$username = $this->Db_model->get('user','username');
		$arr_username = array();
		$all_username = array();
		$kembar_username = array();
		foreach($username->result() as $z => $x){
			$usnm = $x->username;
			if(in_array($usnm,$arr_username)){
				$kembar_username[] = $usnm;
			}else{
				$arr_username[] = $usnm;
			}
			$all_username[] = $usnm;
		}
		//print_r($kembar_username);
		$username_sama = $kembar_username;
		
		$username = $this->Db_model->get('user','email');
		$arr_username = array();
		$all_username = array();
		$kembar_username = array();
		foreach($username->result() as $z => $x){
			$usnm = $x->email;
			if(in_array($usnm,$arr_username)){
				$kembar_username[] = $usnm;
			}else{
				$arr_username[] = $usnm;
			}
			$all_username[] = $usnm;
		}
	//	print_r($kembar_username);
		$email_sama = $kembar_username;
		
		
		$username = $this->Db_model->get('user','nohp');
		$arr_username = array();
		$all_username = array();
		$kembar_username = array();
		foreach($username->result() as $z => $x){
			$usnm = $x->nohp;
			if(in_array($usnm,$arr_username)){
				$kembar_username[] = $usnm;
			}else{
				$arr_username[] = $usnm;
			}
			$all_username[] = $usnm;
		}
//		print_r($kembar_username);
		$nohp_sama = $kembar_username;
		
		$uusseerr = "('".implode($username_sama,"','")."')";
		$eemmaaiill = "('".implode($email_sama,"','")."')";
		$nnoohhpp = "('".implode($nohp_sama,"','")."')";
		
		if($jenis == 'username'){
			$where = "username IN $uusseerr";			
			$order = "username DESC";			
		}elseif($jenis=='email'){
			$where = "email IN $eemmaaiill";						
			$order = "email DESC";			
		}elseif($jenis='nohp'){
			$where = "nohp IN $nnoohhpp";									
			$order = "nohp DESC";			
		}else{
			$where = "username IN $uusseerr OR email IN $eemmaaiill OR nohp IN $nnoohhpp";			
			$order = "username DESC";			
		}
		//get($tbl_name,$select='',$where='',$order='',$limit='',$start='0',$group='',$join='')
		$q = $this->Db_model->get('user','id,username,email,nohp,userlevel',$where,$order);
		//echo $this->db->last_query();
		$data['q'] = $q;
		$data['judul']	= 'Pengguna Kembar';

		$this->load->view('layout/header', $data);
		$this->load->view('user/kembar',$data);
		$this->load->view('layout/footer');	
	}
	
	function ubah_kembar($id_user){
		$q = $this->Db_model->get('user','user.*',array('(user.id)' => $id_user)
								);
		$data['isi'] = $q;
		$data['ref'] = $id_user;
		$this->load->view('user/form_kembar',$data);
	}
	
	function simpan_kembar(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('User/kembars');
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$nohp = $this->input->post('nohp');
		$id = $this->input->post('ref');
		
		if(!$username){
			$json['alert'] = "Username harus diisi";
			echo json_encode($json);
			exit;
		}
		
		if(strlen($username) < 6){
			$json['alert'] = "Username minimal 6 karakter";
			echo json_encode($json);
			exit;
		}
		
		$q = $this->Db_model->get('user','id',array('username' => $username, 'md5(id) <>' => $id));
		if($q->num_rows()>0){
			$json['alert'] = "Username sudah dipakai";
			echo json_encode($json);
			exit;
		}
		$data['username'] = $username;
		

		if(!$email OR !filter_var($this->input->post('email', TRUE), FILTER_VALIDATE_EMAIL) ){
			$json['alert'] = "Email harus diisi atau Format Email salah";
			echo json_encode($json);
			exit;
		}
		$q = $this->Db_model->get('user','id',array('email' => $email, 'md5(id) <>' => $id));
		if($q->num_rows()>0){
			$json['alert'] = "Email sudah dipakai";
			echo json_encode($json);
			exit;
		}
		$data['email'] = $email;
		
		if(!$nohp){
			$json['alert'] = "Nomor HP harus diisi";
			echo json_encode($json);
			exit;
		}
		
		$q = $this->Db_model->get('user','id',array('nohp' => $nohp, 'md5(id) <>' => $id));
		if($q->num_rows()>0){
			$json['alert'] = "Nomor HP sudah dipakai";
			echo json_encode($json);
			exit;
		}
		$data['nohp'] = $nohp;
		//print_r($data);exit;
		if($this->Db_model->update('user',$data,array('md5(id)' => $id))){
			$json['status'] = "berhasil";
			$json['alert'] = "Data berhasil disimpan";
			echo json_encode($json);
			exit;
		}
		
	}

	function modal_myform(){
		$id_user = $this->session->userdata('id_user');
		$q = $this->Db_model->get('user','user.*,userlevel.userlevel as nama_level',array('(user.id)' => $id_user),'','','','',
									array('table' => 'userlevel', 'on' => 'userlevel.id = user.userlevel')
								);
		$data['isi'] = $q;
		$this->load->view('user/form_user',$data);
	}

	function simpan_userku(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('login/logout');
		$ref			= $this->input->post('ref');
		$q = $this->Db_model->get('user','*',array('md5(id)' => $ref))->row();
		$password = sha1(sha1(md5($this->input->post('password'))));
		$data = array('status' => 1);
		$alert = "";
		if(!$this->input->post('username')){
			$json['alert'] 	= 'Username harus diisi';
			echo json_encode($json);
			exit;
		}
		
		$z = $this->Db_model->get('user','id',array('username' => $this->input->post('username'), 'md5(id) <>' => $ref));
		if($z->num_rows()>0){
			$json['alert'] 	= 'Username harus diisi';
			echo json_encode($json);
			exit;
		}
		$data['username']	= $this->input->post('username',true);
		
		if( $password != $q->password){
			$json['alert'] 	= 'Password sekarang tidak sesuai';
			echo json_encode($json);
			exit;
		}

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
		}
		
		if($this->Db_model->update('user',$data,array('md5(id)' => $ref))){
			$json['status'] = 'berhasil';
			$json['alert']  = "Data berhasil disimpan. ".$alert;
			echo json_encode($json);
			exit;				
		}
	}
	
	function simpan_user(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('User');
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
		
		if($this->input->post('nohp')){
			$z = $this->Db_model->get('user','id',array('md5(id) <>' => $ref, 'nohp' => $this->input->post('nohp')));
			if($z->num_rows()>0){
				$json['alert'] 	= 'No Hp sudah dipakai';
				echo json_encode($json);
				exit;
			}
			$data['nohp'] = $this->input->post('nohp');			
		}

		if($this->input->post('email')){
			$z = $this->Db_model->get('user','id',array('md5(id) <>' => $ref, 'email' => $this->input->post('email')));
			if($z->num_rows()>0){
				$json['alert'] 	= 'Email sudah dipakai';
				echo json_encode($json);
				exit;
			}
			$data['email'] = $this->input->post('email');
			
		}
			//print_r($data);exit;
			//print_r($this->input->post());exit;
		if($ref=='0'){
			if($this->Db_model->add('user',$data)){
						$json['status'] = 'berhasil';
						$json['alert']  = "Data berhasil disimpan";
						echo json_encode($json);
						exit;
					
			}
		}else{
			if($this->Db_model->update('user',$data,array('md5(id)' => $ref))){
				$this->Db_model->update('data_pin_ref',$userpinref,['md5(id_user)' => $ref]);
						$json['status'] = 'berhasil';
						$json['alert']  = "Data berhasil disimpan";
						echo json_encode($json);
						exit;
					
			}
			
		}
	}

	function simpan_verif(){
		$json['status'] = 'gagal';
		$json['alert'] 	= 'gagal';
		$json['link'] 	= site_url('user/verifikasi_user');
		$ref = $this->input->post('ref');
		$q = $this->Db_model->get('user','*',array('md5(id)' => $ref))->row();
		$email = $q->email;
		$data['status']			= 1;
		$data['status_email']	= null;
		$data['status_hp']		= null;
		$data['email_baru']		= null;
		$data['nohp_baru']		= null;
		if(($this->input->post('status_hp')) AND $this->input->post('status_hp') == '1'){
			$data['nohp'] = $this->input->post('nohp');
		}
		if(($this->input->post('status_email')) AND $this->input->post('status_email') == '1'){
			$data['email'] = $this->input->post('email');
			$email2 = $q->email;
			$email = $this->input->post('email');
		}
		if($this->Db_model->update('user',$data,array('md5(id)' => $ref))){
				$dataemail['kontent'] = "
				Dear pengguna, <br>
				Proses verifikasi perubahan data profil berhasil dilakukan.<br>
				Anda dapat mengakses akun anda kembali. <br>
				Terimakasih
				";
				$bodyemail = $this->load->view('template_email',$dataemail,true);
				$emailx['mail_to']			= $email;
				$emailx['title'] 			= "Verifikasi Berhasil";
				$emailx['date_created'] 	= date('Y-m-d H:i:s');
				$emailx['body'] 			= $bodyemail;
				$emailx['status'] 		= 0;
				if($this->Db_model->add('log_email',$emailx)){
					$json['status'] = 'berhasil';
					$json['alert']  = "Data berhasil disimpan.";
					echo json_encode($json);
					exit;
				}
		}
		print_r($data);
		print_r($this->input->post());
	}

	function ajax_list_verif($level='-'){
		$this->load->model('User_model');
		$list = $this->User_model->get_datatables_verif($level);
		$query = $this->db->last_query();

		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'];
		}
		foreach ($list as $rows) {
			$row = array();
			$status = 'Tidak Aktif';
			if($rows->status=='1'){
				$status = 'Aktif';
			}elseif($rows->status=='2'){
				$status = 'Dibekukan';
			}elseif($rows->status=='3'){
				$status = 'Belum diverifikasi';
			}
			$row[] = $no;
			$row[] = isset($rows->level_name) ? $rows->level_name : '-';
			$row[] = isset($rows->username) ? $rows->username : '-';
			$row[] = $status;
			//$row[] = isset($rows->email) ? $rows->email: '-';
				$datahm = "<button class='btn verif' id='".sha1($rows->id)."'>Verifikasi</button>";

				$row[] = $datahm;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->User_model->count_all_verif($level),
						"recordsFiltered" => $this->User_model->count_filtered_verif($level),
						"data" => $data,
						//"query" => $query
				);
		echo json_encode($output);
	}

	function ajax_list($level='-'){
		$this->load->model('User_model');
		$list = $this->User_model->get_datatables($level);
		$query = $this->db->last_query();

		$data = array();
		$no = 1;
		if($_POST['start']){
			$no = $_POST['start'] + 1;
		}
		foreach ($list as $rows) {
			$row = array();
				
				$datahm = "
				<button class='btn btn-info edit' id='".sha1($rows->id)."'>Edit</button>
				";
				
			$status = 'Tidak Aktif';
			if($rows->status=='1'){
				$status = 'Aktif';
				$datahm = $datahm."<button class='btn btn-warning disabled' id='".sha1($rows->id)."'>Bekukan</button>";
				if($rows->device_id!="" AND ($this->session->userdata('id_user')==890 OR $this->session->userdata('id_user')==1)){
					$datahm = $datahm." <button class='btn btn-warning resetdevice' id='".sha1($rows->id)."'>Reset Device</button>";					
				}

			}elseif($rows->status=='2'){
				$status = 'Dibekukan';
				$datahm = $datahm."<button class='btn btn-success enabled' id='".sha1($rows->id)."'>Aktifkan</button>";
			}elseif($rows->status=='3'){
				$status = 'Belum diverifikasi';
				$datahm = $datahm."<button class='btn verif' id='".sha1($rows->id)."'>Verifikasi</button>";
			}
			if($this->session->userdata('userlevel')!=1){
					$datahm ="";
				}
			$arry_nggak = array(1,2,101,102);
			if(!in_array($rows->userlevel,$arry_nggak)){
			}
			$row[] = $no;
			$row[] = isset($rows->level_name) ? $rows->level_name : '-';
			if(!in_array($rows->userlevel,$arry_nggak)){
//				$row[] = isset($rows->username) ? "<button type='button' class='btn btn-success detail' id='".md5($rows->id)."'>".$rows->username."</button>" : '-';			
			}else{
			}
				$row[] = isset($rows->username) ? $rows->username : '-';							
		//	$row[] = $status." ".$rows->id;
			$row[] = $status;
			//$row[] = isset($rows->email) ? $rows->email: '-';


				$row[] = $datahm;
			$data[] = $row;
			$no++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->User_model->count_all($level),
						"recordsFiltered" => $this->User_model->count_filtered($level),
						"data" => $data,
						//"query" => $query
				);
		echo json_encode($output);
	}

	function modal_form($id_user='-'){
		$q = $this->Db_model->get('user','user.*,userlevel.userlevel as nama_level',array('sha1(user.id)' => $id_user),'','','','',
									array('table' => 'userlevel', 'on' => 'userlevel.id = user.userlevel')
								);
		$data['ref'] = $q;
		$this->load->view('user/modal_user',$data);
	}
	
	function create_form(){
		$q = array();
		$data['ref'] = $q;
		$this->load->view('user/create_user',$data);
	}
	
	function simpan_create(){
		
	}

	function modal_verif($id_user){
		$q = $this->Db_model->get('user','user.*,userlevel.userlevel as nama_level',array('sha1(user.id)' => $id_user),'','','','',
									array('table' => 'userlevel', 'on' => 'userlevel.id = user.userlevel')
								);
		$data['ref'] = $q;
		$this->load->view('user/modal_verif',$data);
	}

	function create_koderef(){
		$id_user = $this->session->userdata('id_user');
		$current = strtotime(date('Y-m-d H:i:s'));
		$kode_ref = strtoupper(dechex($current + $id_user));
		echo $kode_ref;
	}

	function firstpin(){
		$where['id_user'] = $this->session->userdata('id_user');
		$q = $this->db->get_where('data_pin_ref',$where);
		if($q->row()->pin != ""){
			redirect();
		}
		$data['query'] = $q;
		$this->load->view('user/firstpin',$data);
	}

	function proses_firstpin(){
		$json['status'] 	= 'gagal';
		$json['alert']	 	= 'gagal';
		$json['link']	 	= site_url('user/firstpin');

		$capcay_post		= $this->input->post('capcay');
		$capcay_session 	= $this->session->userdata('capcay');
		if($capcay_post != $capcay_session){
			$json['alert']	= "Captcha Salah";
			echo json_encode($json);
			exit;
		}

		$datax['password']	= sha1(sha1(md5($this->input->post('password',true))));
		$datax['id'] 		= $this->session->userdata('id_user');
		if($this->User_model->cek_user($datax)->num_rows() < 1){
			$json['alert']	= "Password Salah";
			//$json['alert']	= $this->db->last_query();
			echo json_encode($json);
			exit;
		}
		//echo $this->db->last_query();
		$pin		= $this->input->post('pin');
		$pin2		= $this->input->post('pin2');
		if(strlen($pin) < 4){
			$json['alert']	= "Minimun Pin 4 karakter, maksimum 6 karakter";
			echo json_encode($json);
			exit;
		}

		if($pin!=$pin2){
			$json['alert']	= "Kombinasi PIN salah";
			echo json_encode($json);
			exit;
		}

		$data['pin'] = $pin;
		if($this->db->update('data_pin_ref',$data, array('id_user' => $this->session->userdata('id_user')))){
			$json['status']	= "berhasil";
			$json['link']	= site_url();
			$json['alert']	= "Pin Berhasil Dibuat";
			echo json_encode($json);
			exit;
		}

		//print_r($this->session->all_userdata());
		print_r($this->input->post());exit;
	}

	function formdata(){
		//print_r($this->session->all_userdata());
		$where['id'] = $this->session->userdata('id_user');
		$q = $this->db->get_where('user',$where);

		$datax = array();
		if($q->row()->userlevel == '99'){
			if($q->row()->ref != 0){
				$datax = $this->db->get_where('data_pelanggan',array('id' => $q->row()->ref))->row();
			}
		}
		$data['row'] = $datax;
		$data['query'] = $q;
		$this->load->view('user/formdata',$data);
	}

	function proses_formdata(){
		$json['status'] 	= 'gagal';
		$json['alert']	 	= 'gagal';
		$json['link']	 	= site_url('user/firstpin');
		$ref = $this->input->post('ref');

		$data = array('approved' => 0);
		if(!$this->input->post('nama')){
			$json['alert']	= "Nama lengkap belum diisi";
			echo json_encode($json);
			exit;
		}
		$data['nama_lengkap'] = $this->input->post('nama',true);

		if(!$this->input->post('no_ktp')){
			$json['alert']	= "NIK belum diisi";
			echo json_encode($json);
			exit;
		}

		if($this->db->get_where('data_pelanggan',array(
									'no_ktp' => $this->input->post('no_ktp'),
									'md5(id) <>' => $ref))
									->num_rows()
									>0){
			$json['alert']	= "NIK sudah dipakai";
			echo json_encode($json);
			exit;
		}
		$data['no_ktp'] = $this->input->post('no_ktp',true);

		if($this->input->post('jk')==""){
			$json['alert']	= "Jenis kelamin belum diisi";
			echo json_encode($json);
			exit;
		}
		$data['jk'] = $this->input->post('jk',true);

		if(!$this->input->post('agama')){
			$json['alert']	= "Agama belum diisi";
			echo json_encode($json);
			exit;
		}
		$data['agama'] = $this->input->post('agama',true);


		if(!$this->input->post('alamat')){
			$json['alert']	= "Alamat belum diisi";
			echo json_encode($json);
			exit;
		}
		$data['alamat_rumah'] = $this->input->post('alamat',true);

		if(!$this->input->post('agama')){
			$json['alert']	= "Agama belum diisi";
			echo json_encode($json);
			exit;
		}
		$data['agama'] = $this->input->post('agama',true);

		if(!$this->input->post('tempat')){
			$json['alert']	= "Tempat lahir belum diisi";
			echo json_encode($json);
			exit;
		}
		$data['tempat_lahir'] = $this->input->post('tempat',true);

		if(!$this->input->post('tanggal')){
			$json['alert']	= "Tanggal lahir belum diisi";
			echo json_encode($json);
			exit;
		}
		$data['tanggal_lahir'] = $this->convertion->normal2mysql($this->input->post('tanggal',true));


		if(!$this->input->post('pekerjaan')){
			$json['alert']	= "Pekerjaan belum diisi";
			echo json_encode($json);
			exit;
		}
		$data['id_pekerjaan'] = $this->input->post('pekerjaan',true);

		if($ref=='0'){
			$this->Db_model->add('data_pelanggan',$data);
			$id_pelanggan = $this->db->insert_id();
			$this->db->update('user',array('ref' => $id_pelanggan), array('id' => $this->session->userdata('id_user')));
			$this->session->set_userdata('ref',$id_pelanggan);
			$json['status']	= "berhasil";
			$json['alert']	= "Data berhasil disimpan";
			$json['link']	= site_url();
			echo json_encode($json);
			exit;
		}else{
			$this->db->update('data_pelanggan',$data,array('md5(id)' => $ref));
			$json['status']	= "berhasil";
			$json['alert']	= "Data berhasil disimpan";
			$json['link']	= site_url();
			echo json_encode($json);
			exit;
		}

		print_r($data);
	}

	function pekerjaan(){
		$key = $_GET['q'];
		$where = "pekerjaan LIKE '%".$key."%'";
		$xxx = $this->db->get_where('master_pekerjaan',$where);
		//echo $this->db->last_query();
		$data = array();
		foreach($xxx->result() as $isi){
			$row = array();
			$row['id'] = $isi->id_pekerjaan;
			$row['text'] = $isi->pekerjaan;
			$data[] = $row;
		}
		$output = array(
					$data
					);
		echo json_encode($data);
	}
	function bank(){
		$key = $_GET['q'];
		$where = "nama_bank LIKE '%".$key."%'";
		$xxx = $this->db->get_where('master_bank',$where);
		//echo $this->db->last_query();
		$data = array();
		foreach($xxx->result() as $isi){
			$row = array();
			$row['id'] = $isi->id_bank;
			$row['text'] = $isi->nama_bank;
			$data[] = $row;
		}
		$output = array(
					$data
					);
		echo json_encode($data);
	}

	function verifikasi_user(){
		$data['judul']	= 'Verifikasi data User';

		$this->load->view('layout/header', $data);
		$this->load->view('user/main_verif');
		$this->load->view('layout/footer');
	}
	
	
	function lupa_pin(){
		$data['judul']	= 'Permintaan Lupa PIN';
		$data['lupa_pin']	= $this->Db_model->get('data_pin_ref','id_data,id_user, user.username',array('flag_lupa_pin' => 1),'','','','',
								array('table' => 'user', 'user.id = data_pin_ref.id_user')
								);

		$this->load->view('layout/header', $data);
		$this->load->view('user/main_pin');
		$this->load->view('layout/footer');
	}
	
	function download_user(){
		$this->db->select('userlevel.userlevel as level_name, user.*');
		$this->db->from('user');
		$this->db->order_by('user.userlevel','ASC');
		$this->db->where('status <> 2',null);
		$this->db->where('user.id > 1',null);
		$this->db->join('userlevel','userlevel.id = user.userlevel');
		$q = $this->db->get();
		$data['member']	= $q->result();
		$view = $this->load->view('user/dl_user',$data,true);
		$namefile = "Data_User_".date('YmdHis').".xls";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;Filename=".$namefile);
		echo $view;
	}
}

?>
