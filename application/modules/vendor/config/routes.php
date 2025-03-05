<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['vendor-list'] ='vendor/vendor_controller/vendor_list';
$route['add-vendor'] ='vendor/vendor_controller/add_vendor';
$route['save_vendor'] ='vendor/vendor_controller/save_vendor';
$route['edit-vendor/(:any)'] ="vendor/vendor_controller/edit_vendor/$1";
