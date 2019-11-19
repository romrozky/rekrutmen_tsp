<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template {
	
	function sms_registrasi($text){
		return "Selamat, Pendaftaran Berhasil. ".$text." Silahkan bika email dan lakukan pembayaran Simpanan Pokok & Wajib.";
	}
	
	function sms_sukses_pokok_wajib($text){
		return "Selamat, Pembayaran Simp. Pokok&Wajib akun ".$text." Sukses. Silahkan buka Email dan lakukan upload & verifikasi data diri.";
	}
	
	function sms_verifikasi($text){
		return "Terimakasih, Registrasi & Verifikasi akun ".$text." telah disetujui. Salam Satu Jari Sejuta Transaksi - Koperasi Neo Mitra Usaha.";		
	}
	
	function sms_req_topup($username,$nominal){
		return "Terimakasih, Registrasi & Verifikasi akun ".$text." telah disetujui. Salam Satu Jari Sejuta Transaksi - Koperasi Neo Mitra Usaha.";		
	}
	
	function email_reg($email,$nama,$username,$password){
		return "
		<table border='0'>
			<tr>
				<td colspan='3'>
				Terimakasih telah melakukan pendaftaran sebagai pengguna Aplikasi Neo Mitra Usaha dengan data sebagai berikut: <br>					
				</td>
			</tr>
			<tr>
				<td width='5%'>
				</td>
				<td width='20%'>
					Email <br>
					Nama <br>
					Username <br>
					Password <br>					
				</td>
				<td>
					: $email <br>
					: $nama <br>
					: $username <br>
					: $password <br>
				</td>
			</tr>
			<tr>
				<td colspan='3'>
				Simpan baik-baik dan gunakan data tersebut diatas untuk melakukan login ke Aplikasi Neo Mitra Usaha					
				</td>
			</tr>
		</table>
		";
	}
	
	function email_reg($email,$nama,$username,$password){
		return "
		<table border='0'>
			<tr>
				<td colspan='3'>
				Terimakasih telah melakukan pendaftaran sebagai pengguna Aplikasi Neo Mitra Usaha dengan data sebagai berikut: <br>					
				</td>
			</tr>
			<tr>
				<td width='5%'>
				</td>
				<td width='20%'>
					Email <br>
					Nama <br>
					Username <br>
					Password <br>					
				</td>
				<td>
					: $email <br>
					: $nama <br>
					: $username <br>
					: $password <br>
				</td>
			</tr>
			<tr>
				<td colspan='3'>
				Simpan baik-baik dan gunakan data tersebut diatas untuk melakukan login ke Aplikasi Neo Mitra Usaha					
				</td>
			</tr>
		</table>
		";
	}
	
}
