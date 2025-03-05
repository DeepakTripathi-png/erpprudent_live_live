<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function close_db_connection()
{
    $CI =& get_instance();
    $CI->db->close();
}

// Register the hook
$hook['post_controller'] = array(
    'function' => 'close_db_connection',
    'filename' => 'database_hooks.php',
    'filepath' => 'hooks'
);
