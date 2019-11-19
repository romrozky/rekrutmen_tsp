<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	//--------------------------------------------------------jenis barang--------------------------------------------------------//
	
	var $table_jenis = 'master_jenis_barang';
	var $column_order_jenis = array('master_jenis_barang.id','master_jenis_barang.jenis_barang','master_jenis_barang.id'); //set column field database for datatable orderable
	var $column_search_jenis = array('master_jenis_barang.jenis_barang'); //set column field database for datatable searchable 
	var $order_jenis = array('master_jenis_barang.id' => 'ASC'); // default order 


	private function _get_datatables_query_jenis()
	{	
		$this->db->from($this->table_jenis);
		$i = 0;	
		foreach ($this->column_search_jenis as $item) // loop column 
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

				if(count($this->column_search_jenis) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order_jenis[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order_jenis))
		{
			$order = $this->order_jenis;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_jenis($level='-')
	{		
		$this->_get_datatables_query_jenis($level);		
		if(isset($_POST['length']) != -1)
		$this->db->limit(isset($_POST['length']), isset($_POST['start']));
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_jenis($level='-')
	{
		$this->_get_datatables_query_jenis($level);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_jenis($level='-')
	{
		//$this->db->from($this->table);
		$this->db->from($this->table_jenis);
		return $this->db->count_all_results();
	}
	
	
	
	//--------------------------------------------------------barang--------------------------------------------------------//	
	var $table_barang = 'barang';
	var $column_order_barang = array('barang.id','barang.id_jenis_barang','barang.nama_barang','barang.id'); //set column field database for datatable orderable
	var $column_search_barang = array('barang.nama_barang','master_jenis_barang.jenis_barang'); //set column field database for datatable searchable 
	var $order_barang = array('barang.id' => 'ASC'); // default order 


	private function _get_datatables_query_barang()
	{	
		$this->db->select('barang.id,barang.nama_barang,master_jenis_barang.jenis_barang');
		if($this->input->post('id_jenis_barang')){
			$this->db->where('barang.id_jenis_barang',$this->input->post('id_jenis_barang'));
		}
		if($this->session->userdata('userlevel') == '4'){
			$this->db->where('detail_barang.owner',$this->session->userdata('id_user'));
			$this->db->join('detail_barang','detail_barang.id_barang = barang.id');
		}
		$this->db->join('master_jenis_barang','master_jenis_barang.id = barang.id_jenis_barang');
		$this->db->group_by('barang.id');
		
		$this->db->from($this->table_barang);
		$i = 0;	
		foreach ($this->column_search_barang as $item) // loop column 
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

				if(count($this->column_search_barang) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order_barang[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order_barang))
		{
			$order = $this->order_barang;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_barang($level='-')
	{		
		$this->_get_datatables_query_barang($level);		
		if(isset($_POST['length']) != -1)
		$this->db->limit(isset($_POST['length']), isset($_POST['start']));
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_barang($level='-')
	{
		$this->_get_datatables_query_barang($level);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_barang($level='-')
	{
		$this->db->select('barang.id,barang.nama_barang,master_jenis_barang.jenis_barang');
		if($this->input->post('id_jenis_barang')){
			$this->db->where('barang.id_jenis_barang',$this->input->post('id_jenis_barang'));
		}
		if($this->session->userdata('userlevel') == 4){
			$this->db->where('detail_barang.owner',$this->session->userdata('id_user'));
			$this->db->join('detail_barang','detail_barang.id_barang = barang.id');
		}
		$this->db->join('master_jenis_barang','master_jenis_barang.id = barang.id_jenis_barang');
				$this->db->group_by('barang.id');

		$this->db->from($this->table_barang);
		return $this->db->count_all_results();
	}
	
	
	
	
	//--------------------------------------------------------detail barang--------------------------------------------------------//
	var $table_barang_detail = 'detail_barang';
	var $column_order_barang_detail_detail = array('detail_barang.id','detail_barang.id_barang','detail_barang.registered_number','detail_barang.kondisi'); //set column field database for datatable orderable
	var $column_search_barang_detail = array('barang.nama_barang','user.username','detail_barang.registered_number'); //set column field database for datatable searchable 
	var $order_barang_detail = array('detail_barang.last_update' => 'ASC'); // default order 


	private function _get_datatables_query_barang_detail()
	{	
		$this->db->select('barang.nama_barang, detail_barang.id, detail_barang.registered_number, detail_barang.id id_detail_barang, user.username, user.id id_user, kondisi.kondisi');
		if($this->input->post('id_barang')){
			$this->db->where('detail_barang.id_barang',$this->input->post('id_barang'));
		}
		if($this->input->post('iduser')){
			$this->db->where('detail_barang.owner',$this->input->post('iduser'));
		}
		if($this->session->userdata('userlevel') == 4){
			$this->db->where('detail_barang.owner',$this->session->userdata('id_user'));
		}		
		
		$this->db->join('barang','barang.id = detail_barang.id_barang');
		$this->db->join('master_jenis_barang','master_jenis_barang.id = barang.id_jenis_barang');
		$this->db->join('user','user.id = detail_barang.owner','left');
		$this->db->join('kondisi','kondisi.id = detail_barang.kondisi','left');
		$this->db->from($this->table_barang_detail);
		$i = 0;	
		foreach ($this->column_search_barang_detail as $item) // loop column 
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

				if(count($this->column_search_barang_detail) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order_barang_detail_detail[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order_barang_detail))
		{
			$order = $this->order_barang_detail;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_barang_detail($level='-')
	{		
		$this->_get_datatables_query_barang_detail($level);		
		if(isset($_POST['length']) != -1)
		$this->db->limit(isset($_POST['length']), isset($_POST['start']));
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_barang_detail($level='-')
	{
		$this->_get_datatables_query_barang_detail($level);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_barang_detail($level='-')
	{
		$this->db->select('barang.nama_barang, detail_barang.id, detail_barang.registered_number, detail_barang.id id_detail_barang, user.username, user.id id_user, kondisi.kondisi');
		if($this->input->post('id_barang')){
			$this->db->where('detail_barang.id_barang',$this->input->post('id_barang'));
		}
		if($this->input->post('iduser')){
			$this->db->where('detail_barang.owner',$this->input->post('iduser'));
		}
		if($this->session->userdata('userlevel') == 4){
			$this->db->where('detail_barang.owner',$this->session->userdata('id_user'));
		}		
		
		$this->db->join('barang','barang.id = detail_barang.id_barang');
		$this->db->join('master_jenis_barang','master_jenis_barang.id = barang.id_jenis_barang');
		$this->db->join('user','user.id = detail_barang.owner','left');
		$this->db->join('kondisi','kondisi.id = detail_barang.kondisi','left');
		$this->db->from($this->table_barang_detail);	
		return $this->db->count_all_results();
	}
	
	//
	var $table_barang_history = 'log_detail_barang';
	var $column_order_barang_detail_history = array('detail_barang.id','detail_barang.id_barang','detail_barang.registered_number','detail_barang.kondisi'); //set column field database for datatable orderable
	var $column_search_barang_history = array('barang.nama_barang','user.username','detail_barang.registered_number'); //set column field database for datatable searchable 
	var $order_barang_history = array('log_detail_barang.tanggal' => 'DESC'); // default order 


	private function _get_datatables_query_barang_history()
	{	
		$this->db->select('	barang.nama_barang,
							log_detail_barang.id,
							detail_barang.id id_detail_barang,
							detail_barang.registered_number,
							user.username,
							user.id id_user,
							log_detail_barang.tanggal tanggal,
							kondisi.kondisi');
		if($this->input->post('id_detail_barang')){
			$this->db->where('log_detail_barang.id_detail_barang',$this->input->post('id_detail_barang'));
		}
		if($this->session->userdata('userlevel')==4){
			$this->db->where('log_detail_barang.owner',$this->session->userdata('id_user'));
		}		
		$this->db->join('detail_barang','detail_barang.id = log_detail_barang.id_detail_barang');
		$this->db->join('barang','barang.id = detail_barang.id_barang');
		$this->db->join('user','user.id = log_detail_barang.owner','left');
		$this->db->join('kondisi','kondisi.id = log_detail_barang.kondisi','left');
		$this->db->from($this->table_barang_history);		
		
		$i = 0;	
		foreach ($this->column_search_barang_history as $item) // loop column 
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

				if(count($this->column_search_barang_history) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order_barang_history[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order_barang_history))
		{
			$order = $this->order_barang_history;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_barang_history($level='-')
	{		
		$this->_get_datatables_query_barang_history($level);		
		if(isset($_POST['length']) != -1)
		$this->db->limit(isset($_POST['length']), isset($_POST['start']));
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_barang_history($level='-')
	{
		$this->_get_datatables_query_barang_history($level);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_barang_history($level='-')
	{
		if($this->input->post('id_detail_barang')){
			$this->db->where('log_detail_barang.id_detail_barang',$this->input->post('id_detail_barang'));
		}
		if($this->session->userdata('userlevel')==4){
			$this->db->where('log_detail_barang.owner',$this->session->userdata('id_user'));
		}		
		$this->db->join('detail_barang','detail_barang.id = log_detail_barang.id_detail_barang');
		$this->db->join('barang','barang.id = detail_barang.id_barang');
		$this->db->join('user','user.id = log_detail_barang.owner','left');
		$this->db->join('kondisi','kondisi.id = log_detail_barang.kondisi','left');
		$this->db->from($this->table_barang_history);			
		return $this->db->count_all_results();
	}

	
	
}
