<?
//php defined('SYSPATH') or die('No direct script access.');
//$Id: export.php 7292 2013-01-31 08:22:03Z ruanchao $

header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=$fileName");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Accept-Ranges: bytes");
header("Content-Length: $downloadSize");
header("Pragma: public");
echo iconv('utf-8','gb2312',$sendBack);
exit;