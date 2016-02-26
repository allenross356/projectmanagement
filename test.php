<?php

//ini_set('post_max_size', '64M');
//ini_set('upload_max_filesize', '64M');

//phpinfo();

// Show all errors
//error_reporting(E_ALL);
//ini_set('display_errors', true);
//ini_set('html_errors', true);

session_start();


//phpinfo();
// default scale : 3
bcscale(3);
$p=111;
$d=111;
echo bcmul("1.399999", "1",2); // 16.007

// this is the same without bcscale()
//echo bcdiv('105', '6.55957', 3); // 16.007
?>


