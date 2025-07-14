<?php
session_start();
session_unset();
session_destroy();

header("Location: ../Student/index.php"); 
exit();
?>

