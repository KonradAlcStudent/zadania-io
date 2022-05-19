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

        $sql = "SELECT id_partia, nazwa_towar, cena_towar, ilosc FROM partie INNER JOIN towary ON towar_id=id_towar WHERE id_partia=$id_partia;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $wartosc_calkowita = $row['cena_towar'] * $ilosc;
                $print_page = "<h1>Wydanie towaru z partii nr $id_partia</h1><br>
                                <table border='1'>
                                    <tr>
                                        <th>Nazwa towaru:</th>
                                        <td>".$row['nazwa_towar']."</td>
                                    </tr>
                                    <tr>
                                        <th>Ilość:</th>
                                        <td>$ilosc</td>
                                    </tr>
                                    <tr>
                                        <th>Cena za szt.:</th>
                                        <td>".$row['cena_towar']."</td>
                                    </tr>
                                    <tr>
                                        <th>Wartość wydanego towaru:</th>
                                        <td>$wartosc_calkowita</td>
                                    </tr>
                                </table>";
            }
        }

        $sql = "UPDATE partie SET `ilosc` = ilosc - $ilosc WHERE id_partia = $id_partia;";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['error'] = "Wydano towar z magazynu.";
            $_SESSION['wydanie-doc'] = $print_page;
            header("Location: ../wydanie-towaru-menu.php");
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