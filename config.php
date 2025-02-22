<?php
    function db() {
        try{
            $connexion = new PDO("sqlite: dump.db");
            $connexion->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $connexion;
    }
?>