<?php
require('../../../../wp-blog-header.php');

$to_include=$_GET['ajaxpage'];
unset($_GET['ajaxpage']);
$_GET['zlistpage']=$_GET['page'];
unset($_GET['page']);
$http=zing_mailz_http("phpmail",$to_include);
$news = new zHttpRequest($http,'mailz');
$output=$news->DownloadToString();
echo $output;
?>