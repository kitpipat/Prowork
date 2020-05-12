<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once  APPPATH. 'libraries/spout/src/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

class cReport extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user/user/mUser');
		$this->load->model('report/mReport');
	}

	public function index(){
		$this->load->view('report/wReportMain');
	}

	public function FSwCREPLoadDatatable(){
		$this->load->view('report/wReportDatatable');
	}

	//ตัวกรองค้นหา
	public function FSwCREPPageDetail(){
		$tRptCode = $this->input->post('tRptCode');
		$tRptName = $this->input->post('tRptName');
		$aPackData = array(
			'aBCHList'	=> $this->mUser->FSaMUSRGetBranch(),
			'tRptCode' 	=> $tRptCode,
			'tRptName'	=> $tRptName
		);
		$this->load->view('report/wReportPageDetail',$aPackData);
	}

	//รายละเอียดแต่ละรายงาน
	public function FSwCREPLoadDetailDatatable(){
		$nPage 		= $this->input->post('nPage');
		$tBCHCode 	= $this->input->post('tBCHCode');  
		$tDateStart = $this->input->post('tDateStart');
		$tDateEnd 	= $this->input->post('tDateEnd');

		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10
		);

		$aDetailList 	= $this->mReport->FSaMREPGetData($aCondition);
		$aPackData 		= array(
			'aDetailList'	=> $aDetailList,
			'nPage'			=> $nPage
		);
		$this->load->view('report/wReportDetailDatatable',$aPackData);
	}

	//ส่งออก excel
	public function FSwCREPExportExcel(){
		$writer = WriterEntityFactory::createXLSXWriter();
		$writer->openToBrowser('1234.xlsx'); 

		$cells = [
			WriterEntityFactory::createCell('Carl'),
			WriterEntityFactory::createCell('is'),
			WriterEntityFactory::createCell('great!'),
		];

		$multipleRows = [];
		for($i=0; $i<=40000; $i++){
			$multipleRows[] = WriterEntityFactory::createRow($cells);
		}


		$writer->addRows($multipleRows); 

		$writer->close();
	}
}
