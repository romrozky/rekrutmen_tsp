<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Convertion {
	
	function file_ada_nggak($file){
		if($file==""){
			return false;
		}else{
			$file_headers = get_headers($file);
			if ($file_headers[0] == 'HTTP/1.1 200 OK') {
				return true;
			} else {
				return false;
			}			
		}
	}
	
	function mysql_date_2_views($datetime){
		$timestamp = strtotime($datetime);
		//$day = $this->konversi_hari(date('D', $timestamp));
		
		$date = explode(' ',$datetime)[0];
		$time = explode(' ',$datetime)[1];
//		print_r($date);
		$tgl = explode('-',$date)[2];
		$bulan = $this->konversi_bulan(explode('-',$date)[1]);
		$tahun = explode('-',$date)[0];
		$tanggal_waktu = "$tgl $bulan $tahun $time";
		//$tanggal_waktu = "$tgl $bulan $tahun";
		return $tanggal_waktu;  
	}
	
	function datetime_no_time($datetime){
		$timestamp = strtotime($datetime);
		//$day = $this->konversi_hari(date('D', $timestamp));
		
		$date = explode(' ',$datetime)[0];
		$time = explode(' ',$datetime)[1];
		$tgl = explode('-',$date)[2];
//		$bulan = $this->konversi_bulan(explode('-',$date)[1]);
		$bulan = (explode('-',$date)[1]);
		$tahun = explode('-',$date)[0];
		$tanggal_waktu = "$tgl-$bulan-$tahun";
		return $tanggal_waktu;  
	}
	
	function mysql_date_2_date($date){
		$tgl = explode('-',$date)[2];
		$bulan = $this->konversi_bulan(explode('-',$date)[1]);
		$tahun = explode('-',$date)[0];
		$tanggal_waktu = "$tgl $bulan $tahun";
		//$tanggal_waktu = "$tgl $bulan $tahun";
		if($tahun=='0000'){
			return "-";
		}else{
			return $tanggal_waktu;  			
		}
	}
	
	function konversi_bulan($bulan){
		switch ($bulan) {
            case '01' : return 'Januari';
                break;
            case '02' : return 'Februari';
                break;
            case '03' : return 'Maret';
                break;
            case '04' : return 'April';
                break;
			case '05' : return 'Mei';
                break;
			case '06' : return 'Juni';
                break;
			case '07' : return 'Juli';
                break;
			case '08' : return 'Agustus';
                break;
			case '09' : return 'September';
                break;
			case '10' : return 'Oktober';
                break;
			case '11' : return 'November';
                break;
			case '12' : return 'Desember';
                break;
            default : return '-';
                break;
        }
	}
	
	
	function konversi_hari($hari){
		switch ($hari) {
            case 'Sun' : return 'Ahad';
                break;
            case 'Mon' : return 'Senin';
                break;
            case 'Tue' : return 'Selasa';
                break;
            case 'Wed' : return 'Rabu';
                break;
			case 'Thu' : return 'Kamis';
                break;
			case 'Fri' : return 'Jum`at';
                break;
			case 'Sat' : return 'Sabtu';
                break;
            default : return '-';
                break;
        }
	}
	
	function normal_2_mysql($dates){
		$date	= explode(' ',$dates)[0];
		$time	= explode(' ',$dates)[1];
		$tgl	= explode('-',$date);
		return $tgl[2]."-".$tgl[1]."-".$tgl[0]." ".$time;
	}
	
	function normal2mysql($dates){
		$tgl	= explode('-',$dates);
		return $tgl[2]."-".$tgl[1]."-".$tgl[0];
	}
	
	function mysql2normal($dates){
		$tgl	= explode('-',$dates);
		return $tgl[2]."-".$tgl[1]."-".$tgl[0];
		//return $tgl;
	}
	
	
	
	
	function mysql_date_2_biasa($datetime){
		$timestamp = strtotime($datetime);
		//$day = $this->konversi_hari(date('D', $timestamp));
		
		$date = explode(' ',$datetime)[0];
		//$time = explode(' ',$datetime)[1];
//		print_r($date);
		$tgl = explode('-',$date)[2];
		$bulan = $this->konversi_bulan(explode('-',$date)[1]);
		$tahun = explode('-',$date)[0];
		$tanggal_waktu = "$tgl $bulan $tahun";
		//$tanggal_waktu = "$tgl $bulan $tahun";
		return $tanggal_waktu;  
	}
	
	function rupiah($rp){
		return "Rp. ".number_format($rp,2,",",".");		
	}
	
	function rupiahs($rp){
		if(is_numeric($rp)){
			return "".number_format($rp,0,",",".");					
		}else{
			return "-";
		}
	}
	
	
	function mysql_datetime_2_view($datetime){
		$timestamp = strtotime($datetime);
		$day = $this->konversi_hari(date('D', $timestamp));
		
		$date = explode(' ',$datetime)[0];
		$time = explode(' ',$datetime)[1];
//		print_r($date);
		$tgl = explode('-',$date)[2];
		$bulan = $this->konversi_bulan(explode('-',$date)[1]);
		$tahun = explode('-',$date)[0];
		$tanggal_waktu = "$day, $tgl $bulan $tahun  <span>$time</span> WIB";
		return $tanggal_waktu; 
	}
	
	
	
}
