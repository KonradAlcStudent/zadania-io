<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">

    <title>Inzynieria oprogramowania</title>
</head>
<body>
    <div class="back">
        <a href="./index.html"><</a>
    </div>
    <div class="container">
        <div class="menu">
            <div class="form__header">
                <h2>Stan magazynowy</h2>
            </div>

        </div>

        <?php
            require_once("./scripts/connection_data.php");
            $conn = new mysqli($servername, $username, $password, $dbname);
        
            if ($conn->connect_error) {
                die("Błąd połączenia: " . $conn->connect_error);
            }
            $conn -> set_charset("utf8");

            $sql = "SELECT towary.nazwa_towar, towary.cena_towar, towary.waga, towary.data_produkcji, partie.ilosc, partie.data_przyjecia FROM towary LEFT JOIN partie ON towary.partia_id = partie.id_partia ORDER BY towary.nazwa_towar;";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "
                    <table border='1'>
                    <tr>
                        <th>Nazwa towaru</th>
                        <th>Cena za szt.</th>
                        <th>Ilość</th>
                        <th>Waga</th>
                        <th>Data produkcji</th>
                        <th>Data przyjęcia</th>
                    </tr>";
                    
                    while($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>" . $row['nazwa_towar'] . "</td>
                            <td>" . $row['cena_towar'] . "</td>
                            <td>" . $row['ilosc'] . "</td>
                            <td>" . $row['waga'] . "</td>
                            <td>" . $row['data_produkcji'] . "</td>
                            <td>" . $row['data_przyjecia'] . "</td>
                        </tr>
                        ";
                    }

                    echo "</table>";
                }
                else {
                    echo "<span>Brak danych.</span>";
                }

            $conn->close();
        ?>

        <footer>Konrad Alchimowicz &copy;</footer>
    </div>


    <script src="./javascript/script.js"></script>

</body>
</html>