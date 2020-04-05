<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'common/cMain';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Login
$route['Login'] 		= 'login/cLogin';
$route['CheckLogin'] 	= 'login/cLogin/FSxCCheckLogin';

//Logout
$route['Logout'] 		= 'login/cLogin/Logout';

//Mainpage
$route['Mainpage'] 		= 'common/cMain';

//อัพโหลดรูปภาพ
$route['ImageUpload'] 					= 'common/cMain/FSvCUploadimage';

//หน้าจอ : ผู้ใช้
$route['r_user'] 						= 'user/user/cUser/index';
$route['r_loaduser'] 					= 'user/user/cUser/FSwUSRLoadDatatable';
$route['r_usercallpageInsertorEdit'] 	= 'user/user/cUser/FSwUSRCallPageInsertorEdit';
$route['r_usereventinsert'] 			= 'user/user/cUser/FSwUSREventInsert';
$route['r_usereventdelete'] 			= 'user/user/cUser/FSxUSREventDelete';

//ใบเสนอราคา
$route['r_quotation'] 		= 'quotation/cQuotation/index';
$route['r_quotationeventGetPdtList'] 		= 'quotation/cQuotation/FCaCQUOGetProductList';
