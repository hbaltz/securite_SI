<?php
echo "<h1>Distinguished Name</h1>";
echo $_SERVER["SSL_CLIENT_S_DN"];

echo "<h1>Common Name</h1>";
echo $_SERVER["SSL_CLIENT_S_DN_CN"];
?>

