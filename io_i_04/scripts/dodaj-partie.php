<?php

    session_start();

    require_once("connection_data.php");
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }
    $conn -> set_charset("utf8");

    if (isset($_POST) && $_POST['kod-partii'] != "") {
        
        $kodPartii = $_POST['kod-partii'];
        $wartoscPartii = $_POST['wartosc-partii'];
        $ilosc = $_POST['ilosc'];
        $dataProdukcji = $_POST['data-produkcji'];
        $nazwaTowaru = $_POST['nazwa-towaru'];
        $cenaZaSztuke = $wartoscPartii / $ilosc;
        $waga = $_POST['waga-szt'];
        $dataDostawy = $_SESSION['data_dostawy'];
        $dostawaId = $_SESSION['id_dostawa'];

        $stmt_partia = $conn->prepare("INSERT INTO `partie` (`id_partia`, `wartosc`, `ilosc`, `data_przyjecia`, `dostawa_id`) VALUES (NULL, ?, ?, ?, ?)");
        $stmt_partia->bind_param("disi", $wartoscPartii, $ilosc, $dataDostawy, $dostawaId);
        $stmt_partia->execute();

        $last_id = $conn->insert_id;
        $partiaId = $last_id;

        $stmt_towar = $conn->prepare("INSERT INTO `towary` (`id_towar`, `nazwa_towar`, `cena_towar`, `waga`, `partia_id`, `data_produkcji`) VALUES (NULL, ?, ?, ?, ?, ?)");
        $stmt_towar->bind_param("sddis", $nazwaTowaru, $cenaZaSztuke, $waga, $partiaId, $dataProdukcji);
        $stmt_towar->execute();

        $_SESSION['error'] = "Dodano partię.";
        header("Location: ../przyjecie-towaru.php");

    }
    else {
        $_SESSION['error'] = "Błąd podczas tworzenia nowej partii.";
        header("Location: ../przyjecie-towaru.php");
    }
    

    $conn->close();

?>