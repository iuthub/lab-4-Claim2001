<?php
#[Pure] function sizing($size)
{
    if ($size > 0 && $size < 1024) {
        $size = round($size, -2) . " Bytes";
    } elseif ($size >= 1024 && $size < 1048576) {
        $size = $size / 1024;
        $size = round($size, 2) . " Kb";
    } elseif ($size >= 1048576) {
        $size = $size / 1048576;
        $size = round($size, 2) . " Mb";
    }
    return $size;

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
        "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Music Viewer</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <link href="viewer.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<div id="header">
    <h1><a href="index.php">HOME</a></h1>

    <?php
    if (isset($_GET["shuffle"])) {
        if ($_GET["shuffle"] == "off") {
            ?>
            <h2 id="shuffle"><a href="?shuffle=on">SHUFFLE: OFF</a></h2>
        <?php } elseif ($_GET["shuffle"] == "on") { ?>
            <h2 id="shuffle"><a href="?shuffle=off">SHUFFLE: ON</a></h2>
            <?php ?>
            <?php
        }
    } else {
        ?>
        <h2 id="shuffle"><a href="?shuffle=on">SHUFFLE: OFF</a></h2>
    <?php }
    ?>


    <h1>190M Music Playlist Viewer</h1>
    <h2>Search Through Your Playlists and Music</h2>
</div>


<div id="listarea">
    <?php
    if (isset($_GET["playlist"])) {
        $aa = $_GET["playlist"];
        $ll_names = file("songs/{$aa}");

        foreach ($ll_names as $ll_name) {
            if ($ll_name[0] == "#") {
                continue;
            }
            $ll_name = trim($ll_name);
            $size = filesize("songs/$ll_name");

            ?>
            <li class="mp3item">
                <a href="<?= "songs/$ll_name" ?>"><?= $ll_name . " (" . sizing($size) . ")" ?></a>
            </li>

            <?php
        }
        ?>
        <?php
    } else {
        ?>
        <ul id="musiclist">
            <?php
            $mp3s = glob("songs/*.mp3");
            if (isset($_GET["shuffle"])) {
                if ($_GET["shuffle"] == "on") {
                    shuffle($mp3s);
                }
            }
            foreach ($mp3s as $mp3) {
                $size = filesize("$mp3");
                $mp3name = basename($mp3);
                ?>
                <li class="mp3item">
                    <a href="<?= $mp3 ?>"><?= $mp3name . " (" . sizing($size) . ")" ?></a>
                </li>
                <?php
            }
            ?>

            <?php
            $playlists = glob("songs/*.m3u");
            foreach ($playlists as $playlist) {
                $list_name = basename($playlist);
                ?>
                <li class="playlistitem">
                    <a href="<?= "?playlist=" . $list_name ?>"><?= $list_name ?> </a>
                </li>
                <?php
            }
            ?>
        </ul>

        <?php
    }
    ?>
</div>
</body>
</html>

