<?php 
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "onthefly";

    try {
        $conn = new PDO ("mysql:host=$host;dbname=$dbname",$username,$password);
    } catch(PDOException $ex) {
        echo "verbinding mislukt!";
    }



?>