<?php
session_start();

// Tanggalin lahat ng session variables
$_SESSION = array();

// Kung gumagamit ng session cookie, sirain din ang cookie sa browser
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// SIrain ang session sa server
session_destroy();

// I-redirect ang user pabalik sa login page
header("Location: index.php");
exit();
