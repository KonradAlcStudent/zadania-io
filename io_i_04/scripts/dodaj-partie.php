<?php

    session_start();

    require_once("connection_data.php");
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }
    $conn -> set_charset("utf8");

    if (isset($_POST) && $_POST['ilosc'] != "") {
        
        $wartoscPartii = $_POST['wartosc-partii'];
        $ilosc = $_POST['ilosc'];
        $dataProdukcji = $_POST['data-produkcji'];
        $cenaZaSztuke = $wartoscPartii / $ilosc;
        $waga = $_POST['waga-szt'];
        $dataDostawy = $_SESSION['data_dostawy'];
        $dostawaId = $_SESSION['id_dostawa'];

        if ($_POST['nazwa-towaru-select'] != "empty") {
            $nazwaTowaru = $_POST['nazwa-towaru-select'];
        }
        else {
            $nazwaTowaru = $_POST['nazwa-towaru'];
            echo $nazwaTowaru;
        }

        $sql = "SELECT * FROM towary WHERE nazwa_towar='$nazwaTowaru';";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if ($cenaZaSztuke != $row['cena_towar'] || $waga != $row['waga']) {
                    $stmt_towar = $conn->prepare("INSERT INTO `towary` (`nazwa_towar`, `cena_towar`, `waga`) VALUES (?, ?, ?)");
                    $stmt_towar->bind_param("sdd", $row['nazwa_towar'], $cenaZaSztuke, $waga);
                    $stmt_towar->execute();
    
                    $last_id = $conn->insert_id;
                    $towarId = $last_id;
                    
                    break;
                }
                else {
                    $towarId = $row['id_towar'];
                    break;
                }
            }
        }
        else {
            $stmt_towar = $conn->prepare("INSERT INTO `towary` (`nazwa_towar`, `cena_towar`, `waga`) VALUES (?, ?, ?)");
            $stmt_towar->bind_param("sdd", $nazwaTowaru, $cenaZaSztuke, $waga);
            $stmt_towar->execute();

            $last_id = $conn->insert_id;
            $towarId = $last_id;
        }

        $stmt_partia = $conn->prepare("INSERT INTO `partie` (`wartosc`, `ilosc`, `data_przyjecia`, `dostawa_id`, `towar_id`, `data_prod_towaru`) VALUES (?, ?, ?, ?, ?, ?);");
        $stmt_partia->bind_param("disiis", $wartoscPartii, $ilosc, $dataDostawy, $dostawaId, $towarId, $dataProdukcji);
        $stmt_partia->execute();
        
        

        $_SESSION['error'] = "Dodano partię.";
        header("Location: ../przyjecie-towaru.php");

    }
    else {
        $_SESSION['error'] = "Błąd podczas tworzenia nowej partii.";
        header("Location: ../przyjecie-towaru.php");
    }
    

    $conn->close();

?>