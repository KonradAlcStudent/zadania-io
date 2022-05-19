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

        <form id="delivery-form" action="./scripts/dodaj-partie.php" method="POST">

            <div class="form__header">
                <h2>Nowa partia dostawy</h2>
            </div>

            <div class="input-merge">
                <h3>Wybierz towar z bazy lub dodaj nowy</h3>
                <div class="input-box">
                    <label for="nazwa-towaru-select">Wybierz towar z listy</label>
                    <select name="nazwa-towaru-select" id="nazwa-towaru-select">
                        <option value="empty" selected>Dodaj nowy</option>

                        <?php
                            $sql = "SELECT id_towar, nazwa_towar FROM towary GROUP BY nazwa_towar ORDER BY nazwa_towar ASC";
                            $result = $conn->query($sql);
                                    
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['nazwa_towar'] . "'>" . $row['nazwa_towar'] . "</option>";
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
                    <label for="nazwa-towaru">Dodaj nowy towar (lub pozostaw puste)</label>
                    <input id="nazwa-towaru" name="nazwa-towaru" type="text" placeholder="Podaj nazwę towaru">
                    <div class="error hide"></div>
                </div>
            </div>

            

            <div class="input-box">
                <label for="ilosc">Ilość towarów (w sztukach)</label>
                <input id="ilosc" name="ilosc" type="number" placeholder="Podaj ilość">
                <div class="error hide"></div>
            </div>

            <div class="input-box">
                <label for="waga-szt">Waga (g)</label>
                <input id="waga-szt" name="waga-szt" type="number" placeholder="Podaj wagę sztuki.">
                <div class="error hide"></div>
            </div>

            <div class="input-box">
                <label for="wartosc-partii">Wartość partii (zł)</label>
                <input id="wartosc-partii" name="wartosc-partii" type="number" placeholder="Podaj wartość partii">
                <div class="error hide"></div>
            </div>

            <div class="input-box">
                <label for="data-produkcji">Data produkcji</label>
                <input id="data-produkcji" name="data-produkcji" type="date" placeholder="Podaj datę produkcji">
                <div class="error hide"></div>
            </div>

            

            

            <input type="submit" value="Dalej">

        </form>

        <footer>Konrad Alchimowicz &copy;</footer>
    </div>


    <script src="./javascript/script.js"></script>

</body>
</html>