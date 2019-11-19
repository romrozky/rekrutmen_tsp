<?php
defined('BASEPATH') OR exit ('No direct sciprt access allowed');

require_once('assets/dompdf/autoload.inc.php');
use Dompdf\Dompdf;

class Mypdf {

	protected $ci;

	public function __construct(){
		$this->ci =& get_instance();
	}

	public function generate($view, $data = array(), $filename = 'Slip_Gaji', $paper = 'A4', $orientation = 'portrait') {
		$dompdf = new Dompdf();
		$html = $this->ci->load->view($view, $data, TRUE);
		$dompdf->loadHtml($html);
		$dompdf->setPaper($paper, $orientation);
		// Render the HTML as pdf
		$dompdf->render();
			$dompdf->stream($filename.'.pdf', array("Attachment" => FALSE));
			
		$options = new Options();
		$options->set('isRemoteEnabled', true);
		$dompdf = new Dompdf($options);
	}

}
	
?>