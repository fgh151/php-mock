<?php
include 'php-mock.php';
echo '<pre>';
$server = new mockserver\MockServer();
$server->run();
echo '</pre>';
?>