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
                <h2>Przyjęcie towaru</h2>
                <span>Dostawa nr: <?php echo $_SESSION['id_dostawa']; ?></span>
                <?php
                    if (isset($_SESSION['error'])) {
                        echo "<div class='error'>" . $_SESSION['error'] . "</div>";
                    }
                ?>
            </div>
            <a href="./dodaj-partie.php"><button>Dodaj partię</button></a>
            <a href="./index.html"><button>Zakończ dostawę</button></a>
        </div>

        <footer>Konrad Alchimowicz &copy;</footer>
    </div>


    <script src="./javascript/script.js"></script>

</body>
</html>