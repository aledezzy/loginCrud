<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recensioni libro</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <style>
        body {
            margin: 0;
        }

        p {
            margin: 5px 10px;
        }
    </style> <!-- MI DISPIACE -->
    <div class="bookReviewNavbar">
        <a href="dashboardUtenti.php">Ritorna alla dashboard</a>
    </div>

    <h1 style="text-align:center">INSERISCI RECENSIONE PER QUESTO LIBRO</h1>
    <div class="flex" style="align-items:center">
        <form action="" method="post">
            <button type="submit" name="newReview" value="<?php echo $_POST['readReviews']?>">Lascia recensione</button>
            <input type="text" name="testoRecensione">
            <input type="text" name="votoRecensione">
        </form>
    </div>
    <?php
        session_start();

        include "includes/connection.php";
        $connessione = Connection::new();
        //readReviews premuto e mi da isbn libro
        
        if (isset($_POST['readReviews'])) {
            $isbn = htmlentities($_POST['readReviews']);
            $sql = "SELECT id FROM libri WHERE isbn = ?";
            $preparedQuery = $connessione->prepare($sql);
            $preparedQuery->bind_param("s", $isbn);
            if ($preparedQuery->execute()) {
                $result = $preparedQuery->get_result();
                while ($row = $result->fetch_array()) {
                    $bookID = $row['id'];
                }
            }
            $result->free_result();

            $sql = "SELECT * FROM recensioni WHERE id_libro = ?";
            $preparedQuery = $connessione->prepare($sql);
            $preparedQuery->bind_param("s", $bookID);
            if ($preparedQuery->execute()) {
                $result = $preparedQuery->get_result();
                while ($row = $result->fetch_array()) {
                    echo "<p>" . $row['testo'] . "</p>";
                    echo "<p>" . $row['voto'] . "</p>";
                }
            }
            
        }
        //newReview premuto
        //quindi inserisco nellan tabella recensioni id_libro, id_utente(preso dalla variabile di sessione), voto, testo
        if(isset($_POST['newReview'])){
            $isbn = htmlentities($_POST['newReview']);
            $sql = "SELECT id FROM libri WHERE isbn = ?";
            $preparedQuery = $connessione->prepare($sql);
            $preparedQuery->bind_param("s", $isbn);
            if ($preparedQuery->execute()) {
                $result = $preparedQuery->get_result();
                while ($row = $result->fetch_array()) {
                    $bookID = $row['id'];
                }
            }
            $result->free_result();
            $userID = $_SESSION['user'];
            //faccio quey per trovare l'id dell'utente loggato avento la mail dalla variabile di sessione
            $sql = "SELECT id FROM utenti WHERE email = ?";
            $preparedQuery = $connessione->prepare($sql);
            $preparedQuery->bind_param("s", $userID);
            if ($preparedQuery->execute()) {
                $result = $preparedQuery->get_result();
                while ($row = $result->fetch_array()) {
                    $userID = $row['id'];
                }
            }
            $voto = htmlentities($_POST['votoRecensione']);
            $testo = htmlentities($_POST['testoRecensione']);
            $sql = "INSERT INTO recensioni (id_libro, id_utente, voto, testo) VALUES (?, ?, ?, ?)";
            $preparedQuery = $connessione->prepare($sql);
            $preparedQuery->bind_param("iiis", $bookID, $userID, $voto, $testo);
            if ($preparedQuery->execute()) {
                //alert di successo?>
                <script>
                    alert("Recensione lasciata con successo. Grazie per il tuo contributo.");
                    window.location.href = "dashboardUtenti.php";
                </script>
            <?php

            }
        }
            ?>

</body>

</html>