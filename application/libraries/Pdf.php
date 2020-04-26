<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."/third_party/tcpdf/tcpdf.php";
class Pdf extends TCPDF
{
    public function __construct() {
        parent::__construct();
    }
    // public function Footer()
    // {
    //      parent::Footer();
    //      $this->SetY(-13);
    //      //$this->SetFont( 'helvetica', 'I', 8 );
    //      $this->Cell(0, 10, $this->footerText, 0, false, 'L', 0, '', 0, false, 'T', 'M');
    //  }
}
?>
