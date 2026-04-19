<?php
session_start();
session_destroy();
header('Location: pg_inicial.php');
exit();
?>