<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['user-list'] ='user/user_controller/user_list';
$route['add-user'] ='user/user_controller/add_user';
$route['save_user'] ='user/user_controller/save_user';
$route['edit_user/(:any)'] ='user/user_controller/edit_user/$1';
$route['delete_user'] ='user/user_controller/delete_user';
$route['active_user_status'] ='user/user_controller/active_user_status';
$route['block_user_status'] ='user/user_controller/block_user_status';


