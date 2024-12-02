<?php
session_start();

// Hapus semua session yang ada
session_unset();

// Hancurkan session
session_destroy();

// Jika ada cookie session, hapus juga cookie tersebut
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Redirect ke halaman login
header("Location: ../../login.php");
exit();
?>
