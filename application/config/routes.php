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

//หน้าจอ : ผู้ใช้ ( start : 04-04-2020 / done : 06-04-2020 )
$route['r_user'] 						= 'user/user/cUser/index';
$route['r_loaduser'] 					= 'user/user/cUser/FSwUSRLoadDatatable';
$route['r_usercallpageInsertorEdit'] 	= 'user/user/cUser/FSwUSRCallPageInsertorEdit';
$route['r_usereventinsert'] 			= 'user/user/cUser/FSwUSREventInsert';
$route['r_usereventdelete'] 			= 'user/user/cUser/FSxUSREventDelete';
$route['r_usereventedit'] 				= 'user/user/cUser/FSxUSREventEdit';

//หน้าจอ : กลุ่มสิทธิ์ ( start : 06-04-2020 / done : xx-xx-2020 )
$route['r_permission'] 						= 'user/permission/cPermission/index';
$route['r_permissionload'] 					= 'user/permission/cPermission/FSwPERLoadDatatable';
$route['r_permissioncallpageInsertorEdit'] 	= 'user/permission/cPermission/FSwPERCallPageInsertorEdit';
$route['r_permissioneventinsert'] 			= 'user/permission/cPermission/FSwPEREventInsert';
$route['r_permissioneventdelete'] 			= 'user/permission/cPermission/FSxPEREventDelete';
$route['r_permissioneventedit'] 			= 'user/permission/cPermission/FSxPEREventEdit';

//ใบเสนอราคา
$route['r_quotation'] 		= 'quotation/cQuotation/index';
$route['r_quotationeventGetPdtList'] 		= 'quotation/cQuotation/FCaCQUOGetProductList';
