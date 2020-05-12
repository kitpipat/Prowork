<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] 					= 'common/cMain';
$route['404_override'] 							= '';
$route['translate_uri_dashes'] 					= FALSE;

//Login
$route['Login'] 								= 'login/cLogin';
$route['CheckLogin'] 							= 'login/cLogin/FSxCCheckLogin';
$route['ForgetPassword'] 						= 'login/cLogin/FSxCForgetPassword';


//Logout
$route['Logout'] 								= 'login/cLogin/Logout';

//Mainpage
$route['Mainpage'] 								= 'common/cMain';

//อัพโหลดรูปภาพ
$route['ImageUpload'] 							= 'common/cMain/FSvCUploadimage';
$route['ImageUpload_zip'] 						= 'common/cMain/FSvCUploadimage_zip';

//หน้าจอ : ผู้ใช้ ( start : 04-04-2020 / done : 06-04-2020 )
$route['r_user'] 								= 'user/user/cUser/index';
$route['r_loaduser'] 							= 'user/user/cUser/FSwCUSRLoadDatatable';
$route['r_usercallpageInsertorEdit'] 			= 'user/user/cUser/FSwCUSRCallPageInsertorEdit';
$route['r_usereventinsert'] 					= 'user/user/cUser/FSwCUSREventInsert';
$route['r_usereventdelete'] 					= 'user/user/cUser/FSxCUSREventDelete';
$route['r_usereventedit'] 						= 'user/user/cUser/FSxCUSREventEdit';

//หน้าจอ : กลุ่มสิทธิ์ ( start : 06-04-2020 / done : 06-04-2020 )
$route['r_permission'] 							= 'user/permission/cPermission/index';
$route['r_permissionload'] 						= 'user/permission/cPermission/FSwCPERLoadDatatable';
$route['r_permissioncallpageInsertorEdit'] 		= 'user/permission/cPermission/FSwCPERCallPageInsertorEdit';
$route['r_permissioneventinsert'] 				= 'user/permission/cPermission/FSwCPEREventInsert';
$route['r_permissioneventdelete'] 				= 'user/permission/cPermission/FSxCPEREventDelete';
$route['r_permissioneventedit'] 				= 'user/permission/cPermission/FSxCPEREventEdit';

//หน้าจอ : กลุ่มราคา ( start : 07-04-2020 / done : 07-04-2020 )
$route['r_userprice'] 							= 'user/userprice/cUserPrice/index';
$route['r_userpriceload'] 						= 'user/userprice/cUserPrice/FSwCUPILoadDatatable';
$route['r_userpricecallpageInsertorEdit'] 		= 'user/userprice/cUserPrice/FSwCUPICallPageInsertorEdit';
$route['r_userpriceeventinsert'] 				= 'user/userprice/cUserPrice/FSwCUPIEventInsert';
$route['r_userpriceeventdelete'] 				= 'user/userprice/cUserPrice/FSxCUPIEventDelete';
$route['r_userpriceeventedit'] 					= 'user/userprice/cUserPrice/FSxCUPIEventEdit';

//หน้าจอ : ผู้จำหน่าย ( start : 08-04-2020 / done : 08-04-2020 )
$route['r_supplier'] 							= 'supplier/cSupplier/index';
$route['r_supplierload'] 						= 'supplier/cSupplier/FSwCSUPLoadDatatable';
$route['r_suppliercallpageInsertorEdit'] 		= 'supplier/cSupplier/FSwCSUPCallPageInsertorEdit';
$route['r_suppliereventinsert'] 				= 'supplier/cSupplier/FSwCSUPEventInsert';
$route['r_suppliereventdelete'] 				= 'supplier/cSupplier/FSxCSUPEventDelete';
$route['r_suppliereventedit'] 					= 'supplier/cSupplier/FSxCSUPEventEdit';

//ใบเสนอราคา
$route['r_quotation/(:num)'] 					= 'quotation/cQuotation/index/$1';
$route['r_quotationeventGetPdtList'] 			= 'quotation/cQuotation/FCaCQUOGetProductList';
$route['r_quotationcalldocheader'] 				= 'quotation/cQuotation/FCwCQUOCallDocHeader';
$route['r_quotationeventcallitemslist'] 		= 'quotation/cQuotation/FCaCQUOCallItemsList';
$route['r_quotationeventAddItems'] 				= 'quotation/cQuotation/FCaCQUOAddItem';
$route['r_quotationeventDelItems'] 				= 'quotation/cQuotation/FCxCQUODelItem';
$route['r_quotationeventEditItemsQty'] 			= 'quotation/cQuotation/FCxCQUOEditItemQty';
$route['r_quotationcallsqdoc'] 					= 'quotation/cQuotation/FCwCQUOCallDocPage';

//ใบเสนอราคา เอกสาร Step2
$route['r_quodoccallitems'] 					= 'quotation/cQuotationDoc/FSvCQUODocItems';
$route['r_quodocgetdocheader'] 					= 'quotation/cQuotationDoc/FSaCQUODocHeader';
$route['r_quodocgetdoccst'] 					= 'quotation/cQuotationDoc/FSaCQUODocCst';
$route['r_quodocsavedoc'] 						= 'quotation/cQuotationDoc/FSxCQUODocSave';
$route['r_quoEditItemQty'] 						= 'quotation/cQuotationDoc/FSxCQUOEventEditQty';
$route['r_quoItemDiscount'] 					= 'quotation/cQuotationDoc/FSxCQUOEventItemDis';
$route['r_quoEditItemPrice'] 					= 'quotation/cQuotationDoc/FSxCQUOEventItemPri';
$route['r_quodeleteItem'] 						= 'quotation/cQuotationDoc/FSxCQUOEventDeleteItem';
$route['r_quoDocFootDiscount'] 					= 'quotation/cQuotationDoc/FSxCQUOEventFootDis';
$route['r_quoCancleDocument'] 					= 'quotation/cQuotationDoc/FSxCQUOEventCancleDocument';
$route['r_quoApproveDocument'] 					= 'quotation/cQuotationDoc/FSxCQUOEventApproveDocument';
$route['r_selectCustomer'] 						= 'quotation/cQuotationDoc/FSxCQUOSelectCustomer';
$route['r_quoPrintForm/(:any)'] 						= 'quotation/cQuotationDoc/FSaCQUODocPrintForm/$1';


//หน้าจอ : กลุ่มสินค้า ( start : 10-04-2020 / done : 10-04-2020 )
$route['r_groupproduct'] 						= 'product/groupproduct/cGroupproduct/index';
$route['r_groupproductload'] 					= 'product/groupproduct/cGroupproduct/FSwCGRPLoadDatatable';
$route['r_groupproductcallpageInsertorEdit'] 	= 'product/groupproduct/cGroupproduct/FSwCGRPCallPageInsertorEdit';
$route['r_groupproducteventinsert'] 			= 'product/groupproduct/cGroupproduct/FSwCGRPEventInsert';
$route['r_groupproducteventdelete'] 			= 'product/groupproduct/cGroupproduct/FSxCGRPEventDelete';
$route['r_groupproducteventedit'] 				= 'product/groupproduct/cGroupproduct/FSxCGRPEventEdit';

//หน้าจอ : ประเภทสินค้า ( start : 10-04-2020 / done : 10-04-2020 )
$route['r_typeproduct'] 						= 'product/typeproduct/cTypeproduct/index';
$route['r_typeproductload'] 					= 'product/typeproduct/cTypeproduct/FSwCTYPLoadDatatable';
$route['r_typeproductcallpageInsertorEdit'] 	= 'product/typeproduct/cTypeproduct/FSwCTYPCallPageInsertorEdit';
$route['r_typeproducteventinsert'] 				= 'product/typeproduct/cTypeproduct/FSwCTYPEventInsert';
$route['r_typeproducteventdelete'] 				= 'product/typeproduct/cTypeproduct/FSxCTYPEventDelete';
$route['r_typeproducteventedit'] 				= 'product/typeproduct/cTypeproduct/FSxCTYPEventEdit';

//หน้าจอ : รุ่นสินค้า ( start : 10-04-2020 / done : 10-04-2020 )
$route['r_modalproduct'] 						= 'product/modalproduct/cModalProduct/index';
$route['r_modalproductload'] 					= 'product/modalproduct/cModalProduct/FSwCMOPLoadDatatable';
$route['r_modalproductcallpageInsertorEdit'] 	= 'product/modalproduct/cModalProduct/FSwCMOPCallPageInsertorEdit';
$route['r_modalproducteventinsert'] 			= 'product/modalproduct/cModalProduct/FSwCMOPEventInsert';
$route['r_modalproducteventdelete'] 			= 'product/modalproduct/cModalProduct/FSxCMOPEventDelete';
$route['r_modalproducteventedit'] 				= 'product/modalproduct/cModalProduct/FSxCMOPEventEdit';

//หน้าจอ : ยี่ห้อสินค้า ( start : 10-04-2020 / done : 10-04-2020 )
$route['r_brandproduct'] 						= 'product/brandproduct/cBrandProduct/index';
$route['r_brandproductload'] 					= 'product/brandproduct/cBrandProduct/FSwCBAPLoadDatatable';
$route['r_brandproductcallpageInsertorEdit'] 	= 'product/brandproduct/cBrandProduct/FSwCBAPCallPageInsertorEdit';
$route['r_brandproducteventinsert'] 			= 'product/brandproduct/cBrandProduct/FSwCBAPEventInsert';
$route['r_brandproducteventdelete'] 			= 'product/brandproduct/cBrandProduct/FSxCBAPEventDelete';
$route['r_brandproducteventedit'] 				= 'product/brandproduct/cBrandProduct/FSxCBAPEventEdit';

//หน้าจอ : ไซด์สินค้า ( start : 10-04-2020 / done : 10-04-2020 )
$route['r_sizeproduct'] 						= 'product/sizeproduct/cSizeproduct/index';
$route['r_sizeproductload'] 					= 'product/sizeproduct/cSizeproduct/FSwCSIZLoadDatatable';
$route['r_sizeproductcallpageInsertorEdit'] 	= 'product/sizeproduct/cSizeproduct/FSwCSIZCallPageInsertorEdit';
$route['r_sizeproducteventinsert'] 				= 'product/sizeproduct/cSizeproduct/FSwCSIZEventInsert';
$route['r_sizeproducteventdelete'] 				= 'product/sizeproduct/cSizeproduct/FSxCSIZEventDelete';
$route['r_sizeproducteventedit'] 				= 'product/sizeproduct/cSizeproduct/FSxCSIZEventEdit';

//หน้าจอ : สีของสินค้า ( start : 10-04-2020 / done : 10-04-2020 )
$route['r_colorproduct'] 						= 'product/colorproduct/cColorproduct/index';
$route['r_colorproductload'] 					= 'product/colorproduct/cColorproduct/FSwCCOPLoadDatatable';
$route['r_colorproductcallpageInsertorEdit'] 	= 'product/colorproduct/cColorproduct/FSwCCOPCallPageInsertorEdit';
$route['r_colorproducteventinsert'] 			= 'product/colorproduct/cColorproduct/FSwCCOPEventInsert';
$route['r_colorproducteventdelete'] 			= 'product/colorproduct/cColorproduct/FSxCCOPEventDelete';
$route['r_colorproducteventedit'] 				= 'product/colorproduct/cColorproduct/FSxCCOPEventEdit';

//หน้าจอ : ลูกค้า ( start : 11-04-2020 / done : 11-04-2020 )
$route['r_customer'] 							= 'customer/cCustomer/index';
$route['r_customerload'] 						= 'customer/cCustomer/FSwCCUSLoadDatatable';
$route['r_customercallpageInsertorEdit'] 		= 'customer/cCustomer/FSwCCUSCallPageInsertorEdit';
$route['r_customereventinsert'] 				= 'customer/cCustomer/FSwCCUSEventInsert';
$route['r_customereventdelete'] 				= 'customer/cCustomer/FSxCCUSEventDelete';
$route['r_customereventedit'] 					= 'customer/cCustomer/FSxCCUSEventEdit';

//หน้าจอ : สินค้า ( start : 12-04-2020 / done : 12-04-2020 )
$route['r_product'] 							= 'product/product/cProduct/index';
$route['r_productload'] 						= 'product/product/cProduct/FSwCPDTLoadDatatable';
$route['r_productcallpageInsertorEdit'] 		= 'product/product/cProduct/FSwCPDTCallPageInsertorEdit';
$route['r_producteventinsert'] 					= 'product/product/cProduct/FSwCPDTEventInsert';
$route['r_producteventdelete'] 					= 'product/product/cProduct/FSxCPDTEventDelete';
$route['r_producteventedit'] 					= 'product/product/cProduct/FSxCPDTEventEdit';
$route['r_productCallpageUplodeImage'] 			= 'product/product/cProduct/FSxCPDTCallpageUplodeImage';
$route['r_productCallpageUplodeFile'] 			= 'product/product/cProduct/FSxCPDTCallpageUplodeFile';
$route['r_producteventDeleteImgInTmp'] 			= 'product/product/cProduct/FSxCPDTEventDeleteImgInTmp';
$route['r_producteventAproveImgInTmp'] 			= 'product/product/cProduct/FSxCPDTEventAproveImgInTmp';
$route['r_producteventAproveDataInTmp'] 		= 'product/product/cProduct/FSxCPDTEventAproveDataInTmp';

//หน้าจอใบปรับราคา ( start : 18-04-2020 / done : 19-04-2020 )
$route['r_adjprice'] 							= 'adjprice/cAdjprice/index';
$route['r_adjpriceload'] 						= 'adjprice/cAdjprice/FSwCAJPLoadDatatable';
$route['r_adjpricecallpageInsertorEdit'] 		= 'adjprice/cAdjprice/FSwCAJPCallPageInsertorEdit';
$route['r_adjpriceeventinsert'] 				= 'adjprice/cAdjprice/FSwCAJPEventInsert';
$route['r_adjpriceeventdelete'] 				= 'adjprice/cAdjprice/FSxCAJPEventDelete';
$route['r_adjpriceeventedit'] 					= 'adjprice/cAdjprice/FSxCAJPEventEdit';
$route['r_adjpriceloadtableDTTmp'] 				= 'adjprice/cAdjprice/FSxCAJPLoadTableDTTmp';
$route['r_adjpriceloadPDT']                   	= 'adjprice/cAdjprice/FSvCAJPLoadPDT';
$route['r_adjpriceInsPDTToTmp']   				= 'adjprice/cAdjprice/FSvCAJPInsPDTToTmp';
$route['r_adjpricePDTDeleteInTmp']   			= 'adjprice/cAdjprice/FSvCAJPDeletePDTInTmp';
$route['r_adjpricePDTUpdateInlineInTmp']   		= 'adjprice/cAdjprice/FSvCAJPUpdateInlinePDTInTmp';
$route['r_adjpricePDTCallpageUplodeFile'] 		= 'adjprice/cAdjprice/FSxCAJPCallpageUplodeFile';
$route['r_adjpriceCancleDocument'] 				= 'adjprice/cAdjprice/FSxCAJPCancleDocument';
$route['r_adjpriceAprove'] 						= 'adjprice/cAdjprice/FSxCAJPAproveDocument';

//หน้าจอใบปรับต้นทุน ( start : 21-04-2020 / done : 23-04-2020 )
$route['r_adjcost'] 							= 'adjcost/cAdjcost/index';
$route['r_adjcostload'] 						= 'adjcost/cAdjcost/FSwCAJCLoadDatatable';
$route['r_adjcostcallpageInsertorEdit'] 		= 'adjcost/cAdjcost/FSwCAJCCallPageInsertorEdit';
$route['r_adjcosteventinsert'] 					= 'adjcost/cAdjcost/FSwCAJCEventInsert';
$route['r_adjcosteventdelete'] 					= 'adjcost/cAdjcost/FSxCAJCEventDelete';
$route['r_adjcosteventedit'] 					= 'adjcost/cAdjcost/FSxCAJCEventEdit';
$route['r_adjcostloadtableDTTmp'] 				= 'adjcost/cAdjcost/FSxCAJCLoadTableDTTmp';
$route['r_adjcostloadPDT']                   	= 'adjcost/cAdjcost/FSvCAJCLoadPDT';
$route['r_adjcostInsPDTToTmp']   				= 'adjcost/cAdjcost/FSvCAJCInsPDTToTmp';
$route['r_adjcostPDTDeleteInTmp']   			= 'adjcost/cAdjcost/FSvCAJCDeletePDTInTmp';
$route['r_adjcostPDTUpdateInlineInTmp']   		= 'adjcost/cAdjcost/FSvCAJCUpdateInlinePDTInTmp';
$route['r_adjcostPDTCallpageUplodeFile'] 		= 'adjcost/cAdjcost/FSxCAJCCallpageUplodeFile';
$route['r_adjcostCancleDocument'] 				= 'adjcost/cAdjcost/FSxCAJCCancleDocument';
$route['r_adjcostAprove'] 						= 'adjcost/cAdjcost/FSxCAJCAproveDocument';

//หน้าข้อมูลใบเสนอราคา ( start : 24-04-2020 / done : 25-04-2020 )
$route['r_quotationList'] 						= 'quotationList/cQuotationList/index';
$route['r_quotationListload'] 					= 'quotationList/cQuotationList/FSwCPILLoadDatatable';
$route['r_quotationListPageEdit'] 				= 'quotationList/cQuotationList/FSwCPILCallPageEdit';
$route['r_quotationListDelete'] 				= 'quotationList/cQuotationList/FSwCPILEventDelete';

//หน้าตรวจสอบใบเสนอราคา ( start : 24-04-2020 / done : 26-04-2020 )
$route['r_quotationcheck'] 						= 'quotationcheck/cQuotationcheck/index';
$route['r_quotationcheckload'] 					= 'quotationcheck/cQuotationcheck/FSwCCPILoadDatatable';
$route['r_quotationcheckUpdate'] 				= 'quotationcheck/cQuotationcheck/FSwCCPIUpdateRecord';

//หน้าบัญชีส่วนตัว ( start : 30-04-2020 / done : 30-04-2020 )
$route['r_information'] 						= 'information/cInformation/index';
$route['r_informationquotationListByUser'] 		= 'information/cInformation/FSwCINMLoadDatatable';

//รายงาน
$route['r_report'] 								= 'report/cReport/index';
$route['r_reportListLoad'] 						= 'report/cReport/FSwCREPLoadDatatable';
$route['r_reportPageDetail'] 					= 'report/cReport/FSwCREPPageDetail';
$route['r_reportTable'] 						= 'report/cReport/FSwCREPLoadDetailDatatable';
$route['r_reportExcel'] 						= 'report/cReport/FSwCREPExportExcel';

