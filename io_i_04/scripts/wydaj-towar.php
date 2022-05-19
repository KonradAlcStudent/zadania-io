<?php

    session_start();

    require_once("connection_data.php");
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }
    $conn -> set_charset("utf8");

    if (isset($_POST) && $_POST['id_partia'] != "" && $_POST['ilosc'] != "") {
        
        // ID partii, z której ma zostać odjęty towar
        $id_partia = $_POST['id_partia'];
        $ilosc = $_POST['ilosc'];

        $sql = "UPDATE partie SET `ilosc` = ilosc - $ilosc WHERE id_partia = $id_partia;";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['error'] = "Wydano towar z magazynu.";
            header("Location: ../wydaj-towar.php");
        } 
        else {
            $_SESSION['error'] = "Wydawanie towaru nie powiodło się.";
            header("Location: ../wydaj-towar.php");
        }
    }
    else {
        $_SESSION['error'] = "Błąd podczas wydawania towaru.";
        header("Location: ../wydaj-towar.php");
    }
    

    $conn->close();

?>