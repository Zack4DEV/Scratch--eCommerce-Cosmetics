<?php
function db() {
    try {
        $connexion = new PDO("sqlite: database/session.db");
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connexion;
    } catch (PDOException $exception) {
        die("Connection error: " . $exception->getMessage());
    }
}
?>