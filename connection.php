<?php

require_once("config.php");

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
} catch (PDOException $e) {
    return $e->getMessage();
}