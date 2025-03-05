<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH."config/mode.php");
/*$config['root']='./uploads/';*/
$config['file_extensions']='png|PNG|jpg|JPG|jpeg|JPEG|pdf|PDF|xls|XLS|xlsx|XLSX|csv|CSV|zip|ZIP|rar|RAR|Webm|wmv|Mkv|Flv|Avi|mp4';

$config['thumb_allowed_file_extensions']='png|PNG|jpg|JPG|jpeg|JPEG|bmp|BMP|gif|GIF';

$config['file_size']='30'; //Single file upload size in mb

$config['mode'] = $mode;//test, live,live-test,

$config['route_path']['live']='/home/onlinedemo/hashtag_private_live'; // online live
$config['route_path']['test']='/home/onlinedemo/unicus_private_test'; // online test

$config['route_path']['local']='./img/site/'; // local 

$config['blog']= array(
							'folder'=>'blog_images',
						  	'compress'=>true,
						 	'thumb_size'  =>array(
											array('height'=>243,'width'=>325),
											array('width'=>890)
										  ),
						 	'thumb_folder'=>'thumbnails',
						 	'folder_prefix'=>'b_',
						 	'tablename'=>'tbl_blog_attachment',
						 	'key'=>'id',
						 	'restricted'=>array('width'=>890)
				   		);