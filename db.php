<?php

    $db_host = "localhost";
    $db_name = "moviestar";
    $db_user = "root";
    $db_pass = "password";

    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    //habilitar erros PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);