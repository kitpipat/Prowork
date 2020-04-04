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

//หน้าจอ : ผู้ใช้
$route['R_User'] 		= 'user/user/cUser/index';
$route['R_LoadUser'] 	= 'user/user/cUser/FSwUSRLoadDatatable';

//ใบเสนอราคา
$route['r_quotation'] 		= 'quotation/cQuotation/index';