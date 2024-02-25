<?php   include "includes/connection.php";
        $connessione = Connection::new();
        session_start();

//get the user's id
$query = "SELECT id FROM utenti WHERE email = ?";
$stmt = $connessione->prepare($query);
$stmt->bind_param("s", $_SESSION['user']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$id_utente = $row['id'];

if (isset($_POST['prendiPrestito'])) {
    $isbn = $_POST['prendiPrestito'];
    $query = "SELECT quantita FROM libri WHERE isbn = ?";
    $stmt = $connessione->prepare($query);
    $stmt->bind_param("s", $isbn);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row['quantita'] > 0) {
        //query for found the id_libro from isbn
        $query = "SELECT id FROM libri WHERE isbn = ?";
        $stmt = $connessione->prepare($query);
        $stmt->bind_param("s", $isbn);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $id_libro = $row['id'];


        $query = "INSERT INTO prestiti (id_utente, id_libro) VALUES (?, ?)";
        $stmt = $connessione->prepare($query);
        $stmt->bind_param("ss", $id_utente, $id_libro);
        $stmt->execute();
        if ($stmt) {
            $query = "UPDATE libri SET quantita = quantita - 1 WHERE isbn = ?";
            $stmt = $connessione->prepare($query);
            $stmt->bind_param("s", $isbn);
            $stmt->execute();
            echo "<script>alert('Libro Prenoato con successo')</script>";
        }
    } else {
        echo "<script>alert('Non ci sono copie disponibili di questo libro')</script>";
    }
    header("Location: dashboardUtenti.php");
}

if (isset($_POST['restituisciLibro'])) {
    $isbn = $_POST['restituisciLibro'];
    $query = "SELECT id FROM libri WHERE isbn = ?";
        $stmt = $connessione->prepare($query);
        $stmt->bind_param("s", $isbn);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $id_libro = $row['id'];

    $query = "DELETE FROM prestiti WHERE id_utente = ? AND id_libro = ?";
    $stmt = $connessione->prepare($query);
    $stmt->bind_param("ss", $id_utente, $id_libro);
    $stmt->execute();
    if ($stmt) {
        $query = "UPDATE libri SET quantita = quantita + 1 WHERE isbn = ?";
        $stmt = $connessione->prepare($query);
        $stmt->bind_param("s", $isbn);
        $stmt->execute();
        if ($stmt) {
            header("Location: dashboardUtenti.php");
            die();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <h1>Scegli un libro da prendere in prestito</h1>
    <table class="userTable">
        <th>Isbn</th>
        <th>Titolo</th>
        <th>Autore</th>
        <th>Anno di Pubblicazione</th>
        <th>Genere</th>
        <th>Quantita rimasta</th>
        <th>Prendi in prestito</th>
        <?php
        
        /*Prestiti ho utente
          Faccio una tabella per mostrare i libri presi in prestito dall'utente 
          ( controllando dalla tabella prestiti l'id_utente) e faccio un bottone per resitutire il libro, 
          aumentando così la quantità disponibile di quel libro
          e sotto faccio una tabella con tutti i libri nella tabella libri che controlla quando premo il tasto prendi 
          in prestito se quantita > 0, altrimenti alert con errore 
        */
        $getBooksquery = "SELECT l.isbn, l.titolo, l.autore, l.anno_pubblicazione, l.genere, l.quantita
        FROM libri l
        LEFT JOIN prestiti p
        ON id_libro != ?
        WHERE p.id_utente = ?
        GROUP BY l.titolo;";
        $result = $connessione->prepare($getBooksquery);
        //$result->bind_param("ii", , $id_utente);
        $result->execute();
        $resultBooks = $result->get_result();
        while ($row = $resultBooks->fetch_assoc()) {
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
                <form method="post">
                    <td><button type='submit' name='prendiPrestito' value="<?php echo $row['isbn'] ?>">Prendi in
                            prestito</button></td>
                </form>
            </tr>
            <?php
        }
        ?>
    </table>

    <?php
            $getPrestitiQuery = "SELECT l.isbn, l.titolo, l.autore, l.anno_pubblicazione, l.genere, l.quantita
                                FROM libri l
                                INNER JOIN prestiti p ON l.id = p.id_libro
                                WHERE p.id_utente = ?;";
            $preparedQuery = $connessione->prepare($getPrestitiQuery);
            $preparedQuery->bind_param("i", $id_utente);
            $preparedQuery->execute();
            $resultPrestiti = $preparedQuery->get_result();
    if($resultPrestiti->num_rows > 0) {
    ?>
        <table class="userTable" style="margin-top: 1em;">
        <th>Isbn</th>
        <th>Titolo</th>
        <th>Autore</th>
        <th>Anno di Pubblicazione</th>
        <th>Genere</th>
        <th>Quantita rimasta</th>
        <th>Restituisci</th>
        <?php
        // Mostrare i libri presi in prestito dall'utente (controllando dalla tabella prestiti l'id_utente)

            while ($row = $resultPrestiti->fetch_assoc()) {
                    var_dump($row)
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
                    <form method="post">
                        <td><button type='submit' name='restituisciLibro' value="<?php echo $row['isbn'] ?>">Restituisci</button></td>
                    </form>
                </tr>
                <?php
            }
        }
        ?>
    </table>

</body>

</html>