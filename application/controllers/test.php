<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class test extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Pdf');
    }

    public function index()
    {

        // สร้าง object สำหรับใช้สร้าง pdf
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // กำหนดรายละเอียดของ pdf
        // $pdf->SetCreator(PDF_CREATOR);
        // $pdf->SetAuthor('Nicola Asuni');
        // $pdf->SetTitle('TCPDF Example 001');
        // $pdf->SetSubject('TCPDF Tutorial');
        // $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // กำหนดข้อมูลที่จะแสดงในส่วนของ header และ footer
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        $pdf->setPrintHeader(false);
				$pdf->setFooterData(array(0,64,0), array(0,64,128));

        // กำหนดรูปแบบของฟอนท์และขนาดฟอนท์ที่ใช้ใน header และ footer
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // กำหนดค่าเริ่มต้นของฟอนท์แบบ monospaced
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // กำหนด margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				
        // กำหนดการแบ่งหน้าอัตโนมัติ
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // กำหนดรูปแบบการปรับขนาดของรูปภาพ
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // กำหนดฟอนท์
        // ฟอนท์ freeserif รองรับภาษาไทย
        //$pdf->SetFont('freeserif', '', 14, '', true);
				$pdf->SetFont('THSarabunNew', '', 14, '', true);



        // เพิ่มหน้า pdf
        // การกำหนดในส่วนนี้ สามารถปรับรูปแบบต่างๆ ได้ ดูวิธีใช้งานที่คู่มือของ tcpdf เพิ่มเติม
        $pdf->AddPage();

        // กำหนดเงาของข้อความ
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));


		    $html = $this->load->view('test','',true);

		    // สร้างข้อเนื้อหา pdf ด้วยคำสั่ง writeHTMLCell()
		    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

		    // จบการทำงานและแสดงไฟล์ pdf
		    // การกำหนดในส่วนนี้ สามารถปรับรูปแบบต่างๆ ได้ เช่นให้บันทึกเป้นไฟล์ หรือให้แสดง pdf เลย ดูวิธีใช้งานที่คู่มือของ tcpdf เพิ่มเติม
		    $pdf->Output('example_001.pdf', 'I');

    }

}
?>
