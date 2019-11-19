<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model {

	var $table_cabang = 'master_cabang';
	var $column_order_cabang = array('master_cabang.id','master_cabang.nama_cabang','master_cabang.alamat_cabang','master_cabang.id'); //set column field database for datatable orderable
	var $column_search_cabang = array('master_cabang.nama_cabang','master_cabang.alamat_cabang'); //set column field database for datatable searchable 
	var $order_cabang = array('master_cabang.id' => 'ASC'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query_cabang()
	{	
		$this->db->from($this->table_cabang);
		$i = 0;	
		foreach ($this->column_search_cabang as $item) // loop column 
		{
			if(isset($_POST['search']['value'])) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search_cabang) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order_cabang[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order_cabang))
		{
			$order = $this->order_cabang;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_cabang($level='-')
	{		
		$this->_get_datatables_query_cabang($level);		
		if(isset($_POST['length']) != -1)
		$this->db->limit(isset($_POST['length']), isset($_POST['start']));
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_cabang($level='-')
	{
		$this->_get_datatables_query_cabang($level);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_cabang($level='-')
	{
		//$this->db->from($this->table);
		$this->db->from($this->table_cabang);
		return $this->db->count_all_results();
	}
	
	
	
	//penggunan
	var $table_pengguna = 'user';
	var $column_order_pengguna = array('user.id','user.username','user.userlevel','user.cabang','user.id'); //set column field database for datatable orderable
	var $column_search_pengguna = array('user.username','userlevel.userlevel','master_cabang.nama_cabang'); //set column field database for datatable searchable 
	var $order_pengguna = array('user.id' => 'ASC'); // default order 

	private function _get_datatables_query_pengguna()
	{	
		$this->db->select('user.id,user.username,userlevel.userlevel,master_cabang.nama_cabang,user.status');
		$this->db->from($this->table_pengguna);
		if(($this->input->post('cabang'))){
			$this->db->where('user.cabang', $this->input->post('cabang'));
		}
		$this->db->where('user.id > 1', null);
		if(($this->input->post('userlevel'))){
			$this->db->where('user.userlevel', $this->input->post('userlevel'));
		}
		if($this->session->userdata('userlevel')!=1){
			$this->db->where('user.userlvel', $this->session->userdata('userlevel'));			
			$this->db->where('user.cabang', $this->session->userdata('cabang'));			
		}
		
		$this->db->join('userlevel','userlevel.id = user.userlevel');
		$this->db->join('master_cabang','master_cabang.id = user.cabang','left');
		$i = 0;	
		foreach ($this->column_search_pengguna as $item) // loop column 
		{
			if(isset($_POST['search']['value'])) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search_pengguna) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order_pengguna[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order_pengguna))
		{
			$order = $this->order_pengguna;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_pengguna($level='-')
	{		
		$this->_get_datatables_query_pengguna($level);		
		if(isset($_POST['length']) != -1)
		$this->db->limit(isset($_POST['length']), isset($_POST['start']));
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_pengguna($level='-')
	{
		$this->_get_datatables_query_pengguna($level);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_pengguna($level='-')
	{
		$this->db->from($this->table_pengguna);
		if(($this->input->post('cabang'))){
			$this->db->where('user.cabang', $this->input->post('cabang'));
		}
		if(($this->input->post('userlevel'))){
			$this->db->where('user.userlevel', $this->input->post('userlevel'));
		}
		$this->db->where('user.id > 1', null);
		if($this->session->userdata('userlevel')!=1){
			$this->db->where('user.userlvel', $this->session->userdata('userlevel'));			
			$this->db->where('user.cabang', $this->session->userdata('cabang'));			
		}
		$this->db->join('userlevel','userlevel.id = user.userlevel');
		$this->db->join('master_cabang','master_cabang.id = user.cabang','left');		
		return $this->db->count_all_results();
	}
	
	


	
	
}
