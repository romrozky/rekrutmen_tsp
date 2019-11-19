<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
        parent::__construct();
		if(!$this->session->userdata('id_user')){
			redirect('Login/logout');
		}
		if($this->session->userdata('userlevel')==4){
			redirect('barang/main_barang');			
		}elseif($this->session->userdata('userlevel')==3){
			redirect('barang/main_jenis');			
		}
	}
	
	public function index(){
		$data['judul']	= 'Dashboard';
		
		//data
		$data['total_cabang']		= $this->get_total_cabang();
		$data['total_user'] 		= $this->get_total_user();
		$data['total_user_aktif'] 	= $this->get_total_user_aktif();
		$data['total_user_1'] 		= $this->get_total_user_userlevel(1);
		$data['total_user_2'] 		= $this->get_total_user_userlevel(2);
		$data['total_user_3'] 		= $this->get_total_user_userlevel(3);
		$data['total_user_4'] 		= $this->get_total_user_userlevel(4);
		$data['total_barang'] 		= $this->get_total_barang();
		$data['total_barang_1'] 	= $this->get_total_barang(1);
		$data['total_barang_2'] 	= $this->get_total_barang(2);
		$data['total_barang_3'] 	= $this->get_total_barang(3);
		$data['total_barang_4'] 	= $this->get_total_barang(4);
		
		//data
		
		$this->load->view('layout/header', $data);
		$this->load->view('dashboard');
		$this->load->view('layout/footer');
	}
	
	function get_total_cabang(){
		$a = $this->Db_model->get('master_cabang');
		return $a->num_rows();
	}
	
	function get_total_user(){
		$where= array();
		if($this->session->userdata('userlevel')>1){
			$where['cabang'] = $this->session->userdata('cabang');			
		}
		$a = $this->Db_model->get('user','id',$where);
		return $a->num_rows();
	}
	
	function get_total_user_aktif(){
		$where['status'] = 1;
		if($this->session->userdata('userlevel')>1){
			$where['cabang'] = $this->session->userdata('cabang');			
		}
		$a = $this->Db_model->get('user','id',$where);
		return $a->num_rows();
	}
	
	function get_total_user_userlevel($userlevel='-'){
		$where['userlevel'] = $userlevel;
		$where['status'] = 1;
		if($this->session->userdata('userlevel')>1){
			$where['cabang'] = $this->session->userdata('cabang');			
		}
		$a = $this->Db_model->get('user','id',$where);
		return $a->num_rows();
	}
	
	function get_total_barang($kondisi = '-'){
		$where = array();
		if($this->session->userdata('userlevel')>1){
			$where['user.cabang'] = $this->session->userdata('cabang');			
		}
		if($kondisi!='-'){
			$where['detail_barang.kondisi'] = $kondisi;						
		}
		$a = $this->Db_model->get('detail_barang','detail_barang.id',$where,'','','','',
				[
					['table' => 'user', 'on' => 'user.id = detail_barang.owner', 'pos' => 'left']
				]
				
				);
		return $a->num_rows();
	}

}
