

<?php

//Služi za ukidanje trenutne sesije.

include 'paths.php';

session_start();
$_SESSION = array();
session_destroy();
header('Location: ' . HOME);

exit;

?>
