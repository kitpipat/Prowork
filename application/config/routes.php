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
$route['r_user'] 							= 'user/user/cUser/index';
$route['r_loaduser'] 						= 'user/user/cUser/FSwCUSRLoadDatatable';
$route['r_usercallpageInsertorEdit'] 		= 'user/user/cUser/FSwCUSRCallPageInsertorEdit';
$route['r_usereventinsert'] 				= 'user/user/cUser/FSwCUSREventInsert';
$route['r_usereventdelete'] 				= 'user/user/cUser/FSxCUSREventDelete';
$route['r_usereventedit'] 					= 'user/user/cUser/FSxCUSREventEdit';

//หน้าจอ : กลุ่มสิทธิ์ ( start : 06-04-2020 / done : 06-04-2020 )
$route['r_permission'] 						= 'user/permission/cPermission/index';
$route['r_permissionload'] 					= 'user/permission/cPermission/FSwCPERLoadDatatable';
$route['r_permissioncallpageInsertorEdit'] 	= 'user/permission/cPermission/FSwCPERCallPageInsertorEdit';
$route['r_permissioneventinsert'] 			= 'user/permission/cPermission/FSwCPEREventInsert';
$route['r_permissioneventdelete'] 			= 'user/permission/cPermission/FSxCPEREventDelete';
$route['r_permissioneventedit'] 			= 'user/permission/cPermission/FSxCPEREventEdit';

//หน้าจอ : กลุ่มราคา ( start : 07-04-2020 / done : 07-04-2020 )
$route['r_userprice'] 						= 'user/userprice/cUserPrice/index';
$route['r_userpriceload'] 					= 'user/userprice/cUserPrice/FSwCUPILoadDatatable';
$route['r_userpricecallpageInsertorEdit'] 	= 'user/userprice/cUserPrice/FSwCUPICallPageInsertorEdit';
$route['r_userpriceeventinsert'] 			= 'user/userprice/cUserPrice/FSwCUPIEventInsert';
$route['r_userpriceeventdelete'] 			= 'user/userprice/cUserPrice/FSxCUPIEventDelete';
$route['r_userpriceeventedit'] 				= 'user/userprice/cUserPrice/FSxCUPIEventEdit';

//หน้าจอ : ผู้จำหน่าย ( start : 08-04-2020 / done : 08-04-2020 )
$route['r_supplier'] 						= 'supplier/cSupplier/index';
$route['r_supplierload'] 					= 'supplier/cSupplier/FSwCSUPLoadDatatable';
$route['r_suppliercallpageInsertorEdit'] 	= 'supplier/cSupplier/FSwCSUPCallPageInsertorEdit';
$route['r_suppliereventinsert'] 			= 'supplier/cSupplier/FSwCSUPEventInsert';
$route['r_suppliereventdelete'] 			= 'supplier/cSupplier/FSxCSUPEventDelete';
$route['r_suppliereventedit'] 				= 'supplier/cSupplier/FSxCSUPEventEdit';

//ใบเสนอราคา
$route['r_quotation'] 		= 'quotation/cQuotation/index';
$route['r_quotationeventGetPdtList'] 		= 'quotation/cQuotation/FCaCQUOGetProductList';
$route['r_quotationcalldocheader'] 		= 'quotation/cQuotation/FCwCQUOCallDocHeader';
$route['r_quotationeventcallitemslist'] 		= 'quotation/cQuotation/FCaCQUOCallItemsList';
$route['r_quotationeventAddItems'] 		= 'quotation/cQuotation/FCaCQUOAddItem';
$route['r_quotationeventDelItems'] 		= 'quotation/cQuotation/FCxCQUODelItem';
$route['r_quotationeventEditItemsQty'] 		= 'quotation/cQuotation/FCxCQUOEditItemQty';
