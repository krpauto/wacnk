<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'dashboards/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['home'] = 'dashboards/index';
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
$route['device/(:num)'] = 'dashboards/device';
$route['device/delete/(:num)'] = 'dashboards/device_delete';
$route['autoresponder'] = 'dashboards/autoresponder';
$route['autoresponder/view/(:num)'] = 'dashboards/autoresponder_view';
$route['autoresponder/del/(:num)'] = 'dashboards/autoresponder_del';
$route['contacts'] = 'dashboards/contacts';
$route['getcontacts'] = 'dashboards/get_contacts';
$route['contacts/del'] = 'dashboards/contacts_del';
$route['blast'] = 'dashboards/blast';
$route['blast/del'] = 'dashboards/blast_del';
$route['blast/resend/(:any)'] = 'dashboards/blast_resend';
$route['schedule'] = 'dashboards/schedule';
$route['schedule/del'] = 'dashboards/schedule_del';
$route['send'] = 'dashboards/send';
$route['broadcast'] = 'dashboards/broadcast';
$route['api'] = 'dashboards/api';
$route['settings'] = 'dashboards/settings';
$route['users'] = 'dashboards/users';
$route['users/edit/(:num)'] = 'dashboards/users_edit';
$route['users/del/(:num)'] = 'dashboards/users_del';
$route['settings/global'] = 'dashboards/settings_post';
$route['report/single'] = 'reports/single';
$route['report/single/del'] = 'reports/single_del';
$route['report/received'] = 'reports/received';
$route['report/received/del'] = 'reports/received_del';
$route['report/api'] = 'reports/api';
$route['report/api/del'] = 'reports/api_del';

$route['api/send-message'] = 'api/send_message';
$route['api/send-media'] = 'api/send_media';
$route['api/send-button'] = 'api/send_button';
$route['api/callback'] = 'api/callback';

$route['excel/export'] = 'excel/export_number';
$route['excel/import'] = 'excel/import_number';

$route['file/get'] = 'file/get_media';
$route['file/upload'] = 'file/upload';
