<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	
	
	public function cek_user($data){
        $query = $this->db->get_where('user', $data);
        return $query;
    }
	
	public function reg_cek($data){		
			$query = $this->db->get_where('user', $data);
			return $query->num_rows();					
    }
	
	public function cek_user_level($data){
			$this->db->join();
			$query = $this->db->get_where('user', $data);
			return $query->num_rows();					
    }
	
	public function update_user($data,$where){
			$query = $this->db->get_where('user', $data);
			return $query->num_rows();			
		
    }
	
	//profil
	
	
	//nggak aktif
	private function _get_datatables_query_nggak_aktif($level='-')
	{	
		$this->db->select('userlevel.userlevel as level_name, user.username, user.userlevel, user.id, user.status');
		$this->db->from($this->table);
		if($level!='-'){
			$this->db->where('user.userlevel',$level);
		}
		$this->db->where('status',2);
		$this->db->where('user.id > 1',null);
		$this->db->join('userlevel','userlevel.id = user.userlevel');
		$i = 0;	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
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

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_nggak_aktif($level='-')
	{		
		$this->_get_datatables_query_nggak_aktif($level);		
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_nggak_aktif($level='-')
	{
		$this->_get_datatables_query_nggak_aktif($level);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_nggak_aktif($level='-')
	{
		//$this->db->from($this->table);
		$this->db->from($this->table);
		if($level!='-'){
			$this->db->where('userlevel',$level);
		}
		$this->db->where('user.id > 1',null);
		$this->db->where('status',2);
		$this->db->join('userlevel','userlevel.id = user.userlevel');
		$i = 0;
		return $this->db->count_all_results();
	}
}
