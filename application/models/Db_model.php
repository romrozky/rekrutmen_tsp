<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db_model extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	public function get($tbl_name,$select='',$where='',$order='',$limit='',$start='0',$group='',$join=''){
		if(!empty($select)) $this->db->select($select,false);
		if(!empty($where)) $this->db->where($where);
		if(!empty($order)) $this->db->order_by($order);
		if(!empty($limit)) $this->db->limit($limit,$start);
		if(!empty($group)) $this->db->group_by($group);
		if(!empty($join)&&is_array($join)){
			if(!empty($join['table']) && !empty($join['on'])) {
				$join = array($join);
			}
			
			foreach($join as $item){
				if(!empty($item['table']) && !empty($item['on'])) {
					if(!empty($item['pos'])){
						$this->db->join($item['table'],$item['on'],$item['pos']);
					}else{
						$this->db->join($item['table'],$item['on']);
					}
				}
			}
		}
		
		return $this->db->get($tbl_name);
	}
	
	function add($tbl_name,$data){
		if(is_array($data)){
			return $this->db->insert($tbl_name,$data);			
		}		
		return false;
	}
	
	public function update($tbl_name,$data,$where){
		if(is_array($data)){
			return $this->db->update($tbl_name,$data,$where);
		}
		return false;
	}
	
	public function delete($tbl_name,$where){
		return $this->db->delete($tbl_name,$where);
		
	}
	
        public function query($query=''){
            if(!empty($query)){
                $query = $this->db->query($query);
                return $query;
            }else{
                return false;
            }
        }
}