<?php

    session_start();

    require_once("connection_data.php");
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }
    $conn -> set_charset("utf8");

    if (isset($_POST) && $_POST['dostawca'] != "" && $_POST['wartosc-dostawy'] != "" && $_POST['data-dostawy'] != "") {
        
        $dostawca = $_POST['dostawca'];
        $wartoscDostawy = $_POST['wartosc-dostawy'];
        $dataDostawy = $_POST['data-dostawy'];

        $sql = "INSERT INTO `dostawa` (`id_dostawa`, `dostawca`, `wartosc`, `data_dost`) VALUES (NULL, '$dostawca', '$wartoscDostawy', '$dataDostawy');";

        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            $_SESSION['id_dostawa'] = $last_id;
            $_SESSION['data_dostawy'] = $dataDostawy;
            header("Location: ../przyjecie-towaru.php");
        } else {
            $_SESSION['error'] = "Nie można wstawić dostawy do bazy danych.";
            header("Location: ../nowa-dostawa.php");
        }
    }
    else {
        $_SESSION['error'] = "Błąd podczas tworzenia nowej dostawy.";
        header("Location: ../nowa-dostawa.php");
    }
    

    $conn->close();

?>