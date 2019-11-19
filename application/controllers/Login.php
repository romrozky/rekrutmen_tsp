<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('User_model');
    }
	
	public function index() {
//		print_r($this->session->all_userdata());
		if($this->session->userdata('id_user')){
			redirect('dashboard');
		}
		$this->load->view('login');
		
	}
	
	function proses(){
		//print_r($this->input->post());
		//print_r($this->session->all_userdata());
		$json['status'] 	= 'gagal';
		$json['alert']	 	= 'gagal';
		$json['link']	 	= site_url('login');
		$capcay_post		= $this->input->post('capcay');
		$capcay_session 	= $this->session->userdata('capcay');
		if($capcay_post != $capcay_session){
			$json['alert']	= "Captcha Salah";
			echo json_encode($json);
			exit;
		}
		$data = array('username' => $this->input->post('username', TRUE),
					  'password' => sha1(sha1(md5($this->input->post('password', TRUE))))
		);
		//print_r($data);
		
		$hasil = $this->Db_model->get('user','*',$data);
		
		if($hasil->num_rows() < 1 ){
			$json['alert']	= "Kombinasi username dan password salah";
			echo json_encode($json);
			exit;
		}else{
			if($hasil->row()->status == '0'){
				$json['alert']	= "Akun belum aktif";
				echo json_encode($json);
				exit;
			}elseif($hasil->row()->status == '2'){
				$json['alert']	= "Akun dibekukan";
				echo json_encode($json);
				exit;
			}			/*
			elseif($hasil->row()->status == '3'){
				$json['alert']	= "Profil belum diverifikasi";
				echo json_encode($json);
				exit;
			}*/
			else{
				$session = array(
									'username' => $this->input->post('username'),
									'userlevel' => $hasil->row()->userlevel,
									'cabang' => $hasil->row()->cabang,
									'id_user' => $hasil->row()->id,
									);
				$this->session->set_userdata($session);
				$json['status']	= "berhasil";
				$json['link']	= site_url('Dashboard');
				$json['alert']	= "Selamat datang ".$this->input->post('username');
				echo json_encode($json);
				exit;
			}
		}
	}
	
	
	public function cek_login() {
		$data = array('email' => $this->input->post('username', TRUE),
					  'password' => sha1(sha1(md5($this->input->post('password', TRUE))))
		);

		$this->load->model('model_login'); // load model_login
		$hasil = $this->model_login->cek_user($data);
		if ($hasil->num_rows() == 1) {
			foreach ($hasil->result() as $sess) {
				$sess_data['id_user'] = $sess->id_user;
				$sess_data['email'] = $sess->email;
				$sess_data['id_level'] = $sess->id_level;
				$sess_data['status'] = $sess->status;
				$sess_data['id_ref'] = $sess->ref;
				$this->session->set_userdata($sess_data);
			}

			if($this->session->userdata('flag_aktif')=='0'){
				echo "<script>alert('Status Akun: Tidak Aktif!');history.go(-1);</script>";
			}else{
				redirect('Dashboard');
			}

		}
		else{
			echo "<script>alert('Gagal login: Cek username dan password Anda !');history.go(-1);</script>";
		}
	}
	
	
	public function logout() {
		//$this->session->unset_userdata('email');
		//$this->session->unset_userdata('id_level');
		//session_destroy();
		$this->session->sess_destroy();
		//redirect('');
		redirect('Login');
	}
	
	
	function capcay($id='-'){
		$text = substr(str_shuffle("123456789"), 0, 5);
		$this->session->set_userdata('capcay',$text);
		//$_SESSION['capcay'] = $text;
		$width = 50;
		$height = 20;
		$fontsize = 12;

		$img = imagecreate($width, $height);

		$black = imagecolorallocate($img, 0, 0, 0);
		imagecolortransparent($img, $black);

		$red = imagecolorallocate($img, 255, 0, 0);
		//$red = imagecolorallocate($img, 255, 255, 0);
		imagestring($img, $fontsize, 3, 2, $text, $red);

		header('Content-type: image/png');
		imagepng($img);
		imagedestroy($img);
	}
	
	function capcay2($id='-'){
		$text = substr(str_shuffle("123456789"), 0, 5);
		$this->session->set_userdata('capcay2',$text);
		//$_SESSION['capcay'] = $text;
		$width = 50;
		$height = 20;
		$fontsize = 12;

		$img = imagecreate($width, $height);

		$black = imagecolorallocate($img, 0, 0, 0);
		imagecolortransparent($img, $black);

		$red = imagecolorallocate($img, 255, 0, 0);
		//$red = imagecolorallocate($img, 255, 255, 0);
		imagestring($img, $fontsize, 3, 2, $text, $red);

		header('Content-type: image/png');
		imagepng($img);
		imagedestroy($img);
	}
	
	function cron_bagi2_duit(){
		//yang diproses adalah penyertaan modal yg berhasil pada hari sebelumnya
		//cron dieksekusi pada 00:05, diulang tiap hari
		//
		$q = $this->Db_model->get('log_penyertaan_modal','*',array('status' => 1));
		if($q->num_rows()>0){
			foreach($q->result() as $zz => $xx){
				$id_user = $xx->id_user;
				$qq = $this->Db_model->get('data_pin_ref','kode_ref',array('id_user' => $id_user))->row()->kode_ref;
				$ul = $this->Db_model->get('user','userlevel',array('id' => $id_user))->row()->userlevel;
				$z = $this->iterasi_upline_max5($qq,$ul);				
			}
			echo json_encode($z);
		}
		
	}
	
	function get_id_level($id_user){
		$username = $this->Db_model->get('user','userlevel',array('id' => $id_user));
		if($username->num_rows()>0){
			return $username->row()->userlevel;
		}else{
			return $koderef;
		}
	}
	
	function cron_modal_rdr(){
		$datenow = date('d') -1;
		$month = date('m');
		$q = $this->Db_model->get('log_penyertaan_modal','*',array('DAY(date_update)' => $datenow, 'status' => 1));
		$q = $this->Db_model->get('log_penyertaan_modal','*',array('status' => 1));
		foreach($q->result() as $a => $b){
			$nominal 	= $b->nominal;
			$jatah 		= 13;
			$min_level	= $this->convertion->get_userlevel_by_id($b->id_user);
			$min_level	= 7;
			$counter	= 0;
			$kode_ref	= $this->convertion->get_koderef_by_id_user($b->id_user);

			$kode_ref	= $this->convertion->get_koderef_upline_by_id_user($b->id_user);
		
			echo "ID = ".$b->id."<br>";
			echo "Nominal = ".$this->convertion->rupiah($nominal)."<br><br>";
			echo "Level = ".$min_level."<br><br>";
			$this->iterasi_modal($nominal,$jatah,$min_level,$counter,$kode_ref);
			echo "<br>-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=<br>";
		}
		//print_r($q->result());
	}
	
	function iterasi_modal($nominal,$jatah,$min_level,$counter,$kode_ref){
		$q = $this->Db_model->get('data_pin_ref','*',array('kode_ref' => $kode_ref));
		$counter = $counter+1;
		if($counter<6){
			if($q->num_rows()>0){
				foreach($q->result() as $a => $b){
					$cur_wallet = $b->wallet;
					$up_ref 	= $b->asal_ref;
					$cur_level	= $this->convertion->get_userlevel_by_id($b->id_user);
					//echo $cur_level."<br>";
					$pembagi	= $jatah;
					echo "jatah $jatah";
					if($cur_level<$min_level){
						$selisih	= $min_level - $cur_level;
						//echo "selisih".$selisih."x";
						if($jatah=='13'){
							if($cur_level=='6' OR $cur_level =='98'){
								if($cur_level=='6'){//WA
									$pembagi = 6;
								}
							}else{
								if($cur_level=='5'){//WM
									$pembagi = 4+6;
								}elseif($cur_level=='4'){
									$pembagi = 2+10;
								}elseif($cur_level=='3'){
									$pembagi = $jatah;
								}else{
									$pembagi = $jatah;
								}
							}
						}else{
							if($selisih>1){
								if($selisih==2 AND $cur_level==4){
									$pembagi = 4+2;
								}elseif($selisih==2 AND $cur_level==3){
									$pembagi = 2+1;
								}elseif($selisih==3 AND $cur_level==1){
									$pembagi = 13;
								}
																							
							}else{
								if($cur_level=='6'){//WA
									$pembagi = 6;
								}elseif($cur_level=='5'){//WM
									$pembagi = 4;								
								}elseif($cur_level=='4'){
									$pembagi = 2;							
								}elseif($cur_level=='3'){
									$pembagi = $jatah;
								}else{
									$pembagi = $jatah;
								}
							}
						}
						
						$min_level = $cur_level;
					}else{
						$pembagi = 0; // 
					}
					$level = $cur_level."_".$this->convertion->get_userlevel($cur_level);;
					$komisi = $this->convertion->rupiah($nominal/1000*$pembagi);
					$sisa = $jatah-$pembagi;
					$id_user = $b->id_user;
					for($zz=1;$zz<=$counter;$zz++){
						echo "-";
					}
					echo "	Komisi = $komisi
							Level = $level
							Id_user = $id_user
							Pembagi = $pembagi
							<br>";
					$this->iterasi_modal($nominal,$sisa,$min_level,$counter,$up_ref);					
				}					
			}else{
				$komisi = $this->convertion->rupiah($nominal/1000*$jatah);
				$level = "Manajemen";
				for($zz=1;$zz<=$counter;$zz++){
						echo "-";
					}
				echo "Komisi = $komisi Level = $level<br>";
			}			
		}elseif($jatah>0){
			$komisi = $this->convertion->rupiah($nominal/1000*$jatah);
			$level = "Manajemen";
			for($zz=1;$zz<=$counter+1;$zz++){
					echo "-";
				}
			echo "Komisi = $komisi Level = $level<br>";
		}

	}
	
	function iterasi_upline_max5($kode_ref,$max_level,$duit='13',$array_downline=array(),$counter='0'){
		$q = $this->Db_model->get('data_pin_ref','id_user,kode_ref,asal_ref',array('kode_ref' => $kode_ref));
				$counter = $counter+1;
		if($counter<=5){
			if($q->num_rows()>0){
				foreach($q->result() as $a => $b){
					$data = array(	'id_user' => $b->id_user,
									'counter' => $counter,
									'id_level' => $this->get_id_level($b->id_user),
									'children' => $this->iterasi_upline_max5($b->asal_ref,$array_downline,$counter));
					$array_downline[] = $data;
				}
					
			}else{
				
			}			
		}
		return $array_downline;		
	}
	
	function kirim_email(){
		$q = $this->Db_model->get('log_email','*',array('status' => 0),'',12);
		
		if($q->num_rows()>0){
			$qconfig = $this->Db_model->get('setting_email')->row();
			$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => $qconfig->smtp_host,
					'smtp_port' => $qconfig->smtp_port,
					'smtp_user' => $qconfig->smtp_user,
					'smtp_pass' => $qconfig->smtp_pass,					
					'mailtype'  => 'html', 
					//'charset'   => 'iso-8859-1'
					'charset'   => 'UTF-8'
			);
			$this->load->library('Email', $config);
			foreach($q->result() as $a => $isi){
				$id		= $isi->id;
				$judul	= $isi->title;
				$to		= $isi->mail_to;
				$body	= $isi->body;
				$alias	= $qconfig->alias;
				//$this->email->subject($judul);
	//			echo $judul."<br>";
				
				$this->email->initialize($config); 				
				$this->email->set_newline("\r\n");
				$this->email->from($alias); //nickname
				$this->email->to($to);  // email tujuan		
				$this->email->message($body);
				$this->email->subject($judul);
//				print_r($this->email);
	//			exit;
				if($this->email->send()){
					$data = array('status' => '1', 'date_sent' => date('Y-m-d H:i:s'));
					if($this->Db_model->update('log_email',
														$data,
																array('id' => $id)
																		)
																			)
																				{
					}else{
						return false;
					}
				}else{
					echo $this->email->print_debugger();
					return false;			
				}
				
			}
		}
	}
	
	function diemailkan($id='1'){
		$q = $this->Db_model->get('log_email','*',array('status' => 0, 'id' => $id));
		
		if($q->num_rows()>0){
			$qconfig = $this->Db_model->get('setting_email')->row();
			$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => $qconfig->smtp_host,
					'smtp_port' => $qconfig->smtp_port,
					'smtp_user' => $qconfig->smtp_user,
					'smtp_pass' => $qconfig->smtp_pass,					
					'mailtype'  => 'html', 
					'charset'   => 'iso-8859-1'
			);
			$this->load->library('Email', $config);
			foreach($q->result() as $a => $isi){
				$id		= $isi->id;
				$judul	= $isi->title;
				$to		= $isi->mail_to;
				$body	= $isi->body;
				$alias	= $qconfig->alias;
				//$this->email->subject($judul);
				$this->email->subject($judul);
				$this->email->initialize($config); 				
				$this->email->set_newline("\r\n");
				$this->email->from($alias); //nickname
				$this->email->to($to);  // email tujuan		
				$this->email->message($body);
				
				if($this->email->send()){
					$data = array('status' => '1', 'date_sent' => date('Y-m-d H:i:s'));
					if($this->Db_model->update('log_email',
														$data,
																array('id' => $id)
																		)
																			)
																				{
					}else{
						return false;
					}
				}else{
					echo $this->email->print_debugger();
					return false;			
				}
				
			}
		}
	}
	
	function testemail($x='1'){
			$qconfig = $this->Db_model->get('setting_email')->row();
			$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => $qconfig->smtp_host,
					'smtp_port' => $qconfig->smtp_port,
					'smtp_user' => $qconfig->smtp_user,
					'smtp_pass' => $qconfig->smtp_pass,					
					'mailtype'  => 'html', 
					'charset'   => 'iso-8859-1'
			);
			$this->load->library('Email', $config);
				$judul	= "Judul";
				if($x==1){
					$to		= "arditya@ptdes.net";					
				}elseif($x==2){
					$to		= "aditardit713@gmail.com";					
				}elseif($x==3){
					$to		= "romadhoni@ptdes.net";										
				}else{
					$to		= "romrozky@gmail.com";															
				}
				$body	= "Testemail";
				$alias	= $qconfig->alias;
				$this->email->subject($judul);
				$this->email->initialize($config); 				
				$this->email->set_newline("\r\n");
				$this->email->from($alias); // sender_address
				$this->email->to($to);  // email tujuan		
				$this->email->message($body);
				if($this->email->send()){
					echo "Ooke $to";
					}else{
					echo $this->email->print_debugger();
				}
			
	}
	
	function kirim_sms(){
		$q = $this->Db_model->get('log_sms','*',array('status' => 0, 'date_created >' => date('Y-m-d')),'',100);
		echo $this->db->last_query();
		if($q->num_rows()>0){
			foreach($q->result() as $a => $isi){
				$id		= $isi->id;
				$nohp	= $isi->nohp;
				$pesan	= $isi->sms;
				$userkey = '0lxn7q';
        		$passkey = 'Neo123**';
//				$ws = 'https://alpha.zenziva.net/apps/smsapi.php?userkey='.$userkey.'&passkey='.$passkey.'&nohp='.$nohp.'&pesan='.urlencode($pesan).'';
				$xxx = file_get_contents('https://alpha.zenziva.net/apps/smsapi.php?userkey='.$userkey.'&passkey='.$passkey.'&nohp='.$nohp.'&pesan='.urlencode($pesan).'');
				
				//$zzz =  explode(' ',file_get_contents($ws));
				//print_r($zzz);
				//if($zzz[20])
				//echo $ws;
				$this->Db_model->update('log_sms',array('status' => 1,'date_sent' => date('Y-m-d H:i:s')), array('id' => $id));
			}
		}
	}
}

?>
