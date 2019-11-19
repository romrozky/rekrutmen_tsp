<?php

class Email {
    function __construct(){
		$this->_ci = &get_instance();
    }
    
	public function send_mail($data = []){
    	$this->_ci->config->load('mail', TRUE);
        $mail = $this->_ci->config->item('mail');

        $config = Array(
            'protocol'  => $mail['protocol'],
            'smtp_host' => $mail['smtp_host'],
            'smtp_crypto'	=> $mail['smtp_crypto'],
            'smtp_port' => $mail['smtp_port'],
            'smtp_user' => $mail['smtp_user'],
            'smtp_pass' => $mail['smtp_pass'],
            'mailtype'  => $mail['mailtype'],
            'charset'   => $mail['charset'],
        );

        $this->_ci->load->library('Email');
        $this->_ci->email->initialize($config);  
        $this->_ci->email->set_newline($mail['new_line']);

        $txt = $this->_ci->load->view('mail/template', $data, true);

        $this->_ci->email->from($mail['smtp_user'], 'ptdes.net');
        $this->_ci->email->to($data['mail_receiver']);
        $this->_ci->email->subject($data['mail_subject']);
        $this->_ci->email->message($txt);
        if(isset($data['mail_attachment'])){
        	$this->_ci->email->attach($data['mail_attachment']);
    	}

        $result = $this->_ci->email->send();
        if($result){
            $r = true;
        }else{
            $r = false;
        }
        $emis = [
                'id_email'		=> '',
                'id_ref'        => $data['data']['id_karyawan'],
        		'receiver'	    => $data['mail_receiver'],
        		'type_email'    => $data['mail_type'],
        		'content'	    => $txt,
        		'status'	    => $r,
        		];
        $this->_ci->db->insert('log_email', $emis);

        return $r;
    }
}