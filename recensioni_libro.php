<?php
session_start();

include "includes/connection.php";
$connessione = Connection::new();
//readReviews premuto e mi da isbn libro
?>

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
    <form action="" method="post">
        <select name="bookID">
            <?php
            $getBooksquery = "SELECT id, titolo, autore FROM libri";
            $result = $connessione->query($getBooksquery);

            while ($row = $result->fetch_assoc()) {

                ?>

                <option value="<?php echo $row['id'] ?>">
                    <?php echo $row['titolo'] . "  by " . $row['autore'] ?>
                </option>

                <?php
            }

            ?>
        </select>
        <button type="submit" name="readReviews">Leggi recensioni</button>
    </form>
    <?php
    if (isset($_POST['readReviews'])) {
        $BOOKID = $_POST['bookID'];
        $queryStr = "SELECT id_utente, voto, testo, data_recensione FROM recensioni WHERE id_libro = ?";
        $preparedQuery = $connessione->prepare($queryStr);
        $preparedQuery->bind_param("i", $BOOKID);
        $preparedQuery->execute();
        $result = $preparedQuery->get_result();
        ?>
        <table class="userTable">
            <?php
            while ($row = $result->fetch_assoc()) {

                ?>
                <tr>
                    <td>
                        <?php if (isset($row['id_utente'])) {
                            $preparedQuery = $connessione->prepare("SELECT email FROM utenti WHERE id = ?");
                            $preparedQuery->bind_param("s", $row['id_utente']);
                            if ($preparedQuery->execute()) {
                                $resultUser = $preparedQuery->get_result();
                                $rowUser = $resultUser->fetch_assoc();
                                echo $rowUser['email'];
                            }
                        } else {
                            echo "Utente Nuclearizzato";
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo $row['testo'] ?>
                    </td>
                    <td>
                        <?php echo $row['voto'] ?>
                    </td>
                    <td>
                        <?php echo $row['data_recensione'] ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <form action="" method="post">
                    <td style="color: gray;">
                        <?php echo $_SESSION['user'] . "" ?>
                    </td>
                    <td><input type="text" name="testoRecensione"></td>
                    <td><input type="text" name="votoRecensione"></td>
                    <td><button type="submit" name="newReview" value="<?php echo $BOOKID ?? "" ?>">Lascia
                            recensione</button>
                    </td>
                    <?php
                    $preparedQuery = $connessione->prepare("SELECT id FROM utenti WHERE email = ?");
                    $preparedQuery->bind_param("s", $_SESSION['user']);
                    if ($preparedQuery->execute()) {
                        $resultUser = $preparedQuery->get_result();
                        $rowUser = $resultUser->fetch_assoc();
                        $USERID = $rowUser['id'];
                    }
                    ?>
                    <td><input type="hidden" name="userID" value="<?php echo $USERID ?>"></td>
            </tr>
        </table>

        <?php
    }
    if (isset($_POST['newReview'])) {
        $voto = htmlentities($_POST['votoRecensione']);
        $testo = htmlentities($_POST['testoRecensione']);
        $sql = "INSERT INTO recensioni (id_libro, id_utente, voto, testo) VALUES (?, ?, ?, ?)";
        $preparedQuery = $connessione->prepare($sql);
        $preparedQuery->bind_param("iiis", $_POST['newReview'], $_POST['userID'], $_POST['votoRecensione'], $_POST['testoRecensione']);
        if ($preparedQuery->execute()) {
            ?> //alert di successo
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