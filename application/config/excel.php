<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| Mode: F:for file O: for output to download
| File_path: path to save file on server, donot add at start/ and end, can be left blank if file should be saved on  | root folder but not recommanded
| f_append:File name will be append with the date time format
| f_prepend:file name will be prepended with the given date and time format
| 
*/

$config['file_path']='attachments_excel/excel';
$config['f_append']=array('format'=>'DMhis');
$config['f_prepend']=array();
