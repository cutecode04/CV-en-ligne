<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli("localhost", "root", "", "moncv_db");
    $conn->set_charset("utf8");
} catch (mysqli_sql_exception $e) {
    die("Erreur BD : " . htmlspecialchars($e->getMessage()));
}