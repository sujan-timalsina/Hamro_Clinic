<?php
$file = $_GET['file'];
header("Content-Disposition: attachment; filename=" . urlencode($file));

$fb = fopen($file, "r");
while (!feof($fb)) {
    echo fread($fb, 8192);
    flush();
}
fclose($fb);
