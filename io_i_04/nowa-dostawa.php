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
        <form id="delivery-form" action="./scripts/nowa-dostawa.php" method="POST">

            <div class="form__header">
                <h2>Nowa dostawa</h2>
                <?php
                    if (isset($_SESSION['error'])) {
                        echo "<div class='error'>" . $_SESSION['error'] . "</div>";
                    }
                ?>
            </div>

            <div class="input-box">
                <label for="dostawca">Dostawca</label>
                <input id="dostawca" name="dostawca" type="text" placeholder="Podaj nazwę dostawcy" required>
                <div class="error hide"></div>
            </div>

            <div class="input-box">
                <label for="wartosc-dostawy">Wartość dostawy (zł)</label>
                <input id="wartosc-dostawy" name="wartosc-dostawy" type="number" placeholder="Podaj wartość dostawy" step="0.01" required>
                <div class="error hide"></div>
            </div>

            <div class="input-box">
                <label for="data-dostawy">Data i czas dostawy</label>
                <input id="data-dostawy" name="data-dostawy" type="date" placeholder="Wybierz datę dostawy" required>
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