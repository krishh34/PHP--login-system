
<?php
session_start();

// Session ki saari information delete karo
session_unset();

// Session destroy karo
session_destroy();

// Login page par bhejo
header("Location: login.php");
exit;
?>
