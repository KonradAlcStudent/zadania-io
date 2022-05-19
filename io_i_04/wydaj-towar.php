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
        <?php
            require_once("./scripts/connection_data.php");
            $conn = new mysqli($servername, $username, $password, $dbname);
        
            if ($conn->connect_error) {
                die("Błąd połączenia: " . $conn->connect_error);
            }
            $conn -> set_charset("utf8");
        ?>

        <form id="wydaj-towar-form" action="./scripts/wydaj-towar.php" method="POST">

            <div class="form__header">
                <h2>Wydaj towar</h2>
                <?php
                    if (isset($_SESSION['error'])) {
                        echo "<div class='error'>" . $_SESSION['error'] . "</div>";
                    }
                ?>
            </div>
            <div class="input-box">
                <label for="towar">Wybierz towar</label>
                <select name="id_partia" id="towar">
                    
                    <?php
                        $sql = "SELECT id_partia, nazwa_towar, data_przyjecia, SUM(ilosc) as ilosc_prod FROM towary INNER JOIN partie ON id_towar=towar_id GROUP BY nazwa_towar ORDER BY data_przyjecia ASC;";
                        $result = $conn->query($sql);
                                
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id_partia'] . "'>" . $row['nazwa_towar'] . " | ilość: " . $row['ilosc_prod'] . "</option>";
                            }
                        }
                        else {
                            echo "<option value='error' disabled>Brak opcji</option>";
                        }

                        $conn->close();
                    ?>
                    
                </select>
                <div class="error hide"></div>
            </div>


            <div class="input-box">
                <label for="ilosc">Ilość</label>
                <input id="ilosc" name="ilosc" type="number" placeholder="Podaj ilość" step="1" value="1" min="1" required>
                <div class="error hide"></div>
            </div>


            <input type="submit" value="Dalej">
            
        </form>

        <footer>Konrad Alchimowicz &copy;</footer>
    </div>

    <?php
        unset($_SESSION['error']);
    ?>

    <script src="./javascript/script.js"></script>

</body>
</html>