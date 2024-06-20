<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Zničíme všechny session proměnné
$_SESSION = array();

// Pokud je session používána s cookies, zničíme také cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Zničíme session
session_destroy();

// Přesměrování na domovskou stránku
header("Location: index.php");
exit();
?>
