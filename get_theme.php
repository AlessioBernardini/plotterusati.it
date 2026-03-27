<?php
$mysqli = new mysqli("89.46.111.211", "Sql1450861", "524818o2t0", "Sql1450861_3");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
$res = $mysqli->query("SELECT value FROM ycpm_config WHERE name='theme' LIMIT 1");
if ($res && $row = $res->fetch_assoc()) {
    echo "THEME NAME: " . $row['value'];
}
else {
    echo "Could not find theme.";
}
$res2 = $mysqli->query("SELECT name, value FROM ycpm_config WHERE name LIKE '%recaptcha%' OR name LIKE '%captcha%' OR name LIKE '%akismet%'");
if ($res2) {
    echo "\nCONFIGS:\n";
    while ($row = $res2->fetch_assoc()) {
        echo $row['name'] . ": " . $row['value'] . "\n";
    }
}
$mysqli->close();
?>
