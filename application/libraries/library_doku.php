<?php

class library_doku {

	protected $ci;

	function __construct(){
		$this->ci = &get_instance();

		$this->ci->config->load('doku', TRUE);
		$this->doku = $this->ci->config->item('doku');
	}

	public function request_va($timex = '')
	{
		$no_trans = '085712834903';
		$no_va = $this->doku['CIMB_PREFIX'].$no_trans;

		$payment_channel = '05';
		$durasi['15'] = '21600'; // 21600 menit atau 15 hari
		$durasi['30'] = '43200'; // 43200 menit atau 30 hari
		$durasi['7'] = '10080'; // 10080 menit atau 7 hari
		$durasi['1'] = '1440'; // 10080 menit atau 1 hari

		$minutes_to_add = (int)$durasi['1'] ;
		$dt = date('Y-m-d H:i:s');

		$time = new DateTime($dt);
		$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
		$expire = $time->format('Y-m-d H:i');


		$item = 'TOP UP , 100000.00 , 1 , 100000.00;';
		$jumlah = '100000';

		$time_request = ($timex != '') ? $timex : date('YmdHis');

		$data = [
				'amount'			=> $jumlah,
				'transaction_id'	=> rand(10000000, 99999999),
				'name'				=> 'Danang Pras',
				'phone'				=> '01801812',
				'email'				=> 'pras@email.com',
				'address'			=> 'Jl. ABC',
				'item'				=> $item,
				'date'				=> $time_request,
				'channel'			=> $payment_channel,
				'session_id'		=> sha1($time_request),
				'expiry_va'			=> $expire,
				];

		return $this->generate_payment_code($data);
	}

	public function generate_payment_code($data)
	{
		require_once(APPPATH.'libraries/doku/core/Doku.php');
		date_default_timezone_set('Asia/Jakarta');

		Doku_Initiate::$sharedKey 		= $this->doku['SHARED_KEY'];
		Doku_Initiate::$mallId 			= $this->doku['MALL_ID'];

		$ammount 	= $data['amount'].'.00';
		$trans_id 	= $data['transaction_id'];
		$currency	= '360';

		$params = 	[
						'amount'	=> $data['amount'],
						'invoice'	=> $data['transaction_id'],
						'currency'	=> $currency,
					];
		$words 	= Doku_library::doCreateWords($params);

		$customer = [
						'name'			=> $data['name'],
						'data_phone'	=> $data['phone'],
						'data_email'	=> $data['email'],
						'data_address'	=> $data['address'],
					];
		$dataPayment = [
						'req_mall_id' 			=> Doku_Initiate::$mallId,
						'req_chain_merchant' 	=> 'NA',
						'req_amount' 			=> $params['amount'],
						'req_words' 			=> $words,
						'req_trans_id_merchant' => $trans_id,
						'req_purchase_amount' 	=> $params['amount'],
						'req_request_date_time' => $data['date'],
						'req_session_id' 		=> $data['session_id'],
						'req_email'				=> $customer['data_email'],
						'req_name' 				=> $customer['name'],
						'req_basket' 			=> $data['item'],
						'req_address' 			=> $customer['data_address'],
						'req_mobile_phone' 		=> $customer['data_phone'],
						'req_expiry_time' 		=> $data['expiry_va'],
						];

		$response = Doku_api::doGeneratePaycode($dataPayment);
		
	
		if($response->res_response_code == '0000')
		{
			return ['respon' => $response, 'data_payment' => $dataPayment];
		}else{
			return false;
		}
	}
	
}