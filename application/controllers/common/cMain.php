<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cMain extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('zip');
		$this->load->library("session");
		if(@$_SESSION['tSesUsercode'] == true) { //มี session
			$this->load->model('common/mCommon');
			$this->load->model('product/product/mProduct');
		}else{//ไม่มี session
			redirect('Login', '');
			exit();
		}
	}

	public function index(){
		$aReturnMenu = array(
			'aMenuList' => $this->mCommon->FSaMGetListMenu($this->session->userdata('tSesUsercode'))
		);
		$this->load->view('common/wHeader',$aReturnMenu);
		$this->load->view('common/wContent');
		$this->load->view('common/wFooter');
	}

	//อัพโหลดรูปภาพ ภาพเดียว
	public function FSvCUploadimage(){
		$tPath = $this->input->post('path');

      if($_FILES['file']['name']!=''){
            if(!is_dir('./application/assets/'.$tPath)){
                mkdir('./application/assets/'.$tPath);
            }
            $tCaracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
            $tQuantidadeCaracteres = strlen($tCaracteres);
            $tHash=NULL;
            for($x=1;$x<=10;$x++){
                $tPosicao = rand(0,$tQuantidadeCaracteres);
                $tHash .= substr($tCaracteres,$tPosicao,1);
            }
            $tFilename = 'Img'.$tHash.date('Ymd');
            $aConfig = array(
                'file_name'     => $tFilename,
                'allowed_types' => '*',
                'upload_path'   => './application/assets/'.$tPath,
                'max_size'      => '1000000',
                'max_width'     => '1024000',
                'max_height'    => '768000',
            );
            $this->load->library('upload');
            $this->upload->initialize($aConfig);
            if(!$this->upload->do_upload('file')){
                $aData = array('error' => $this->upload->display_errors());
            }else{
                $aData = array('upload_data' => $this->upload->data());
                if(!empty($aData['upload_data']['file_name'])){
                    $aImageData = $aData['upload_data'];
                    $tStaResize = $this->FStCMPImgResize($aImageData);
                    if($tStaResize=="done"){
                        $tPath     = $aImageData['full_path'];
                        $raImageData = array(
                            'tImgName'     => $aImageData['file_name'],
                            'tImgType'     => $aImageData['image_type'],
                            'tImgFullPath' => $aImageData['full_path']
                        );
                    }
                }
                echo json_encode($raImageData);
            }
        }
    }

    //resize
    public function FStCMPImgResize($paImgUL=null){
        $this->load->library('image_lib');
        $config['image_library'] 	= 'gd2';
        $config['source_image'] 	= $paImgUL['full_path'];
        $config['create_thumb'] 	= FALSE;
        $config['maintain_ratio'] 	= TRUE;
        $config['width'] 			= 600;
        $config['height'] 			= 600;
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()){
            return $this->image_lib->display_errors();
        } else{
            return "done";
        }
	}
	
	//อัพโหลดรูปภาพ Zip , rar
	public function FSvCUploadimage_zip(){

		//ลบข้อมูลในตารางก่อนทุกครั้งที่มีการ อัพโหลด
		$this->mProduct->FSxMPDTImportImgPDTDelete();

		//ลบข้อมูลในโฟลเดอร์ก่อนทุกครั้งที่มีการ อัพโหลด
		array_map('unlink', array_filter((array) glob("./application/assets/images/products_temp/*")));

		//เงื่อนไขคือ : นามสกุล zip และ file ไม่เกิน 5 MB
		$tPath = $this->input->post('path');
		if($_FILES['file']['name'] != ''){ 
			// Set preference 
			$config['upload_path'] 		= './application/assets/'.$tPath; 
			$config['allowed_types'] 	= 'zip|rar'; 
			$config['max_size'] 		= '90000'; // max_size in kb (88.00 MB) 
			$config['file_name'] 		= $_FILES['file']['name'];
			$this->load->library('upload',$config); 
			if($this->upload->do_upload('file')){ 
				$uploadData = $this->upload->data(); 
				$filename 	= $uploadData['file_name'];
				$zip 		= new ZipArchive;
				$res 		= $zip->open('./application/assets/images/products_temp/'.$filename);
				if ($res === TRUE) {

					//แตกไฟล์
					$extractpath = "./application/assets/images/products_temp/";
					$zip->extractTo($extractpath);
					$zip->close();
					$tStatus = 'success';

					//เพิ่มข้อมูลลง TCNMPdt_ImgTmp
					$tFiles = glob("./application/assets/images/products_temp/".'*.jpg');
					foreach($tFiles as $tJpg){
						$aExplode = explode('products_temp/',$tJpg);
						$aExplode = explode('.',$aExplode[1]);

						$aResult = array(
							'FTPdtCode' 	=> $aExplode[0],
							'FTPathImgTmp' 	=> $tJpg
						);
						$this->mProduct->FSxMPDTImportImgPDTInsert($aResult);
					}

				} else {
					$tStatus = 'Failed to extract.';
				}
			}else{ 
				$tStatus = 'Failed to upload';
			} 
		}else{ 
			$tStatus = 'Failed to upload';
		} 

		return $tStatus;
	}
}
