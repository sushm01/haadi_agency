<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['admin-login']=$route['default_controller'].'/adminLogin';
$route['logout'] = $route['default_controller'] . '/A_logout_sessionDestroy';
$route['dashboard']=$route['default_controller'].'/dashboard_page';
$route['admin-user-approval']=$route['default_controller'].'/userapproval_page';
$route['category']=$route['default_controller'].'/category_page';
$route['items']=$route['default_controller'].'/item_page';
$route['purchase-view']=$route['default_controller'].'/purchase_view';
$route['view-details']=$route['default_controller'].'/view_details';
$route['confirmed-details']=$route['default_controller'].'/confirmed_details';
$route['order-list']=$route['default_controller'].'/orderlist_page';


$route['registration']=$route['default_controller'].'/index';
$route['signIn']=$route['default_controller'].'/signin_page';
$route['sales-dashboard']=$route['default_controller'].'/sales_dashboard';
$route['add-purchase']=$route['default_controller'].'/addpurchase_page';
$route['view-order']=$route['default_controller'].'/viewReqOrder_page';
$route['add-sales']=$route['default_controller'].'/addsales_page';
$route['cash-denomination']=$route['default_controller'].'/cashdenomination_page';
$route['voucher']=$route['default_controller'].'/voucher_page';
$route['imps-bank']=$route['default_controller'].'/impsBank_page';
$route['saleslogout'] = $route['default_controller'] . '/S_logout_sessionDestroy';


$route['sales-report']=$route['default_controller'].'/sales_report_page';
$route['all-sales-bills']=$route['default_controller'].'/sales_bill_page';
$route['category-wise-report']=$route['default_controller'].'/category_wise_report';
$route['product-wise-report']=$route['default_controller'].'/product_wise_report';
$route['sales-payment']=$route['default_controller'].'/payment_report';
$route['confirm-order-list']=$route['default_controller'].'/cofirm_order_list';
