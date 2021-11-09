<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// panggil autoload dompdf nya
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
class Pdfgenerator {
    
    public function generate($html, $filename='', $paper = '', $orientation = '', $stream=TRUE)
    {   
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->set_base_path(base_url().'>assets/');
        $dompdf->render();

        if ($stream) {
            $dompdf->stream($filename.".pdf", array("Attachment" => 0)); // 0 preview, 1 download otomatis
        } else {
            return $dompdf->output();
        }
    }

    public function generate_download($html, $filename='', $paper = '', $orientation = '', $stream=TRUE)
    {   
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->set_base_path(base_url().'>assets/');
        $dompdf->render();
        if ($stream) {
            $dompdf->stream($filename.".pdf", array("Attachment" => 1)); // 0 preview, 1 download otomatis
        } else {
            return $dompdf->output();
        }
    }

    public function generate_email($email,$html, $filename='', $paper = '', $orientation = '', $stream=TRUE)
    {   
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->set_base_path(base_url().'>assets/');
        $dompdf->render();
        $dompdf->get_canvas()->get_cpdf()->setEncryption('pawit','pawit123',array('copy','print'));
        if ($stream) {
            $dompdf->stream($filename.".pdf", array("Attachment" => 0)); // 0 preview, 1 download otomatis
        } else {
            return $dompdf->output();
        }
        $targetPath = 'assets/document/payslip/'.$filename;
        $output = $dompdf->output();
        file_put_contents($targetPath.".pdf", $output);
        $file=$targetPath.".pdf";
        email($email,$filename,$file);
        unlink($targetPath.".pdf");
    }

    
}