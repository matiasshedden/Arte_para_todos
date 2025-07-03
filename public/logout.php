<?php
session_start();
session_destroy();
header('Location: /Arte_para_todos/templates/login.twig');
exit;
?>
