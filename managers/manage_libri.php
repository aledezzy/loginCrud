<?php include "../includes/connection.php";
$connessione = Connection::new();
session_start();

if (isset($_POST['confirmBookEdit'])) {
    $id = $_POST['confirmBookEdit'];
    $isbn = $_POST['isbn'];
    $titolo = $_POST['titolo'];
    $autore = $_POST['autore'];
    $anno_pubblicazione = $_POST['anno_pubblicazione'];
    $genere = $_POST['genere'];
    $quantita = $_POST['quantita'];
    //var_dump($isbn, $titolo, $autore, $anno_pubblicazione, $genere, $quantita);
    $query = "  ";
    $query = $connessione->prepare($query);
    $query->bind_param("sssisis", $isbn, $titolo, $autore, $anno_pubblicazione, $genere, $quantita, $id);

    if ($query->execute()) {
        //NON RIESCO A FARE UN ALERT
    }
}

if (isset($_POST['deleteBookButton'])) {
    $bookID = $_POST['deleteBookButton'];
    $smbt = $connessione->prepare("DELETE FROM libri WHERE id=?");
    $smbt->bind_param("i", $bookID);
    $smbt->execute();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <a href="../login.php">Ritorna alla dashboard</a>
    <table class="userTable">
        <table>
            <form action="" method="post">
                <input type="text" name="titolo">
                <input type="text" name="autore">
                <select name="generi">
                    <option value="*">--Seleziona genere--</option>
                    <?php include "../includes/generi.php" ?>
                </select>
                <button type="submit" name="searchBookButton">Cerca</button>
            </form>
        </table>
        <?php




        if (isset($_POST['searchBookButton'])) {
            if (!empty($_POST['titolo']) || !empty($_POST['autore']) || !empty($_POST['generi'])) {
                $queryStr = "SELECT * FROM libri WHERE 1=1";
                $params = array();

                if (!empty($_POST['titolo'])) {

                    $queryStr .= " AND titolo LIKE ?";
                    $params[] = $_POST['titolo'];
                }
                if (!empty($_POST['autore'])) {

                    $queryStr .= " AND autore LIKE ?";
                    $params[] = $_POST['autore'];
                }
                if (!empty($_POST['generi']) && $_POST['generi'] != "*") {

                    $queryStr .= " AND genere LIKE ?";
                    $params[] = $_POST['generi'];
                }

                $query = $connessione->prepare($queryStr);

                switch (count($params)) {
                    case 1:
                        $query->bind_param("s", $params[0]);
                        break;
                    case 2:
                        $query->bind_param("ss", $params[0], $params[1]);
                        break;
                    case 3:
                        $query->bind_param("sss", $params[0], $params[1], $params[2]);
                        break;
                    // Add more cases if needed
                }

                $query->execute();
                $result = $query->get_result();
                ?>

                <table class="userTable">
                    <?php
                    while ($row = $result->fetch_array()) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $row['isbn'] ?>
                            </td>
                            <td>
                                <?php echo $row['titolo'] ?>
                            </td>
                            <td>
                                <?php echo $row['autore'] ?>
                            </td>
                            <td>
                                <?php echo $row['anno_pubblicazione'] ?>
                            </td>
                            <td>
                                <?php echo $row['genere'] ?>
                            </td>
                            <td>
                                <?php echo $row['quantita'] ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php

            }

        } else {
            // Rest of the code
        

            ?>

            <table class="userTable">
                <th>Isbn</th>
                <th>Titolo</th>
                <th>Autore</th>
                <th>Anno di Pubblicazione</th>
                <th>Genere</th>
                <th>Quantita rimasta</th>
                <th></th>
                <?php
                $getBooksquery = "SELECT id, isbn, titolo, autore, anno_pubblicazione, genere, quantita FROM libri";
                $result = $connessione->query($getBooksquery);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['isbn'] . "</td>";
                    echo "<td>" . $row['titolo'] . "</td>";
                    echo "<td>" . $row['autore'] . "</td>";
                    echo "<td>" . $row['anno_pubblicazione'] . "</td>";
                    echo "<td>" . $row['genere'] . "</td>";
                    echo "<td>" . $row['quantita'] . "</td>";
                    if ($_SESSION['role'] == "admin") {
                        ?>
                        <form method="post">
                            <td><button type='submit' name='deleteBookButton' value="<?php echo $row['id'] ?>">Elimina</button></td>

                        </form>
                        <form action="" method="post">
                            <td><button type='submit' name='modifyBookButton' value="<?php echo $row['id'] ?>">Modifica</button>
                            </td>
                            <td><input type="hidden" name="isbn" value="<?php echo $row['isbn'] ?>"></td>
                            <td><input type="hidden" name="titolo" value="<?php echo $row['titolo'] ?>"></td>
                            <td><input type="hidden" name="autore" value="<?php echo $row['autore'] ?>"></td>
                            <td><input type="hidden" name="anno_pubblicazione" value="<?php echo $row['anno_pubblicazione'] ?>">
                            </td>
                            <td><input type="hidden" name="genere" value="<?php echo $row['genere'] ?>"></td>
                            <td><input type="hidden" name="quantita" value="<?php echo $row['quantita'] ?>"></td>

                        </form>
                        </tr>
                        <?php
                    }
                }

                if (isset($_POST['modifyBookButton'])) {
                    ?>
                    <form action="" method="post">
                        <tr>
                            <td><input type="text" name="isbn" value="<?php echo $_POST['isbn'] ?>"></td>
                            <td><input type="text" name="titolo" value="<?php echo $_POST['titolo'] ?>"></td>
                            <td><input type="text" name="autore" value="<?php echo $_POST['autore'] ?>"></td>
                            <td><input type="text" name="anno_pubblicazione" value="<?php echo $_POST['anno_pubblicazione'] ?>">
                            </td>
                            <td>
                                <select name="genere" id="">
                                    <?php include "includes/generi.php" ?>
                                </select>
                            </td>
                            <td><input type="text" name="quantita" value="<?php echo $_POST['quantita'] ?>"></td>
                            <td><button type='submit' name='confirmBookEdit'
                                    value="<?php echo $_POST['modifyBookButton'] ?>">Modifica?</button></td>
                        </tr>
                    </form>
                    <?php


                }
        }
        ?>
        </table>
</body>

</html>