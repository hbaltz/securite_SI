<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "front/blog";
$route['404_override'] = '';

// Articles
$route['dashboard/articles'] = 'admin/dashboard/articles';
$route['dashboard/articles/edit/(:num)'] = 'admin/dashboard/manage_article/$1';
$route['dashboard/articles/delete/(:num)'] = 'admin/dashboard/delete_article/$1';
$route['dashboard/articles/add'] = 'admin/dashboard/manage_article';

// Catégories
$route['dashboard/categories'] = 'admin/dashboard/categories';
$route['dashboard/categories/edit/(:num)'] = 'admin/dashboard/manage_categorie/$1';
$route['dashboard/categories/delete/(:num)'] = 'admin/dashboard/delete_categorie/$1';
$route['dashboard/categories/add'] = 'admin/dashboard/manage_categorie';

// Frontend
$route['page/(:num)'] = $route['default_controller'] . '/index/$1';
$route['search'] = $route['default_controller'] . '/search';
$route['get_uploaded_picture/(:any)'] = $route['default_controller'] . '/get_uploaded_picture/$1';
$route['(:any)/(:any)'] = $route['default_controller'] . '/view/$1/$2';
$route['(:any)'] = $route['default_controller'] . '/view/$1';

// Authentification
$route['register'] = 'authentication/register';
$route['activation'] = 'authentication/activation';
$route['login'] = 'authentication/login';
$route['logout'] = 'authentication/logout';

// Admin
$route['dashboard'] = 'admin/dashboard';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
