<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['add-role'] ='role/role_controller/add_role';
$route['role-list'] ='role/role_controller/role_list';
$route['save_role'] ='role/role_controller/save_role';
$route['edit_role'] ='role/role_controller/edit_role';
$route['delete_role'] ='role/role_controller/delete_role';

$route['role-management'] ='role/role_controller/role_management';
$route['fetch_role_config'] ='role/role_controller/fetch_role_config';
$route['save_role_config'] ='role/role_controller/save_role_config';

