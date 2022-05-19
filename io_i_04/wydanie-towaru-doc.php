<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Inzynieria oprogramowania</title>

    <style>
        .print-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .print-container h1 {
            text-align: center;
        }

        .print-container table {
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="print-container">
        <?php
            session_start();
            echo $_SESSION['wydanie-doc'];
        ?>
    </div>
    <br>
    <center>
        <button id="drukuj">Drukuj</button>
    </center>

    <script>
        function openPrintMenu(e) {
            e.target.style.display = 'none';
            window.print();
        }

        drukuj.addEventListener('click', e => {
            openPrintMenu(e);
        })
    </script>
</body>
</html>