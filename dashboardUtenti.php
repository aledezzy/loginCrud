<?php
/*include the class connection.php*/
include 'includes/connection.php';
//start the session
session_start();
$connessione = Connection::new();
if (isset($_SESSION['user'])) {
    if ($_SESSION['role'] == "admin") {
        header("Location: dashboardAmministratori.php");
        die();
    }
} else {
    header("Location: login.php");
    die();
}
//get the user's email
$email = $_SESSION['user'];
if (isset($_POST['deleteAccount'])) {
    $query = "DELETE FROM utenti WHERE email = '$email'";
    $result = $connessione->query($query);
    if ($result) {
        header("Location: logout.php");
        die();
    }
}
//get the user's id
$query = "SELECT id FROM utenti WHERE email = ?";
$stmt = $connessione->prepare($query);
$stmt->bind_param("s", $email);
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
            if ($stmt) {
                header("Location: dashboardUtenti.php");
                die();
            }
        }
    } else {
        echo "<script>alert('Non ci sono copie disponibili di questo libro')</script>";
    }

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
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utenti</title>
    <link href="styles/dashboard.css" rel="stylesheet" />
    <script src="script/divSelector.js"></script>
</head>

<body>
    <div class="sidebarGridTemplate" id="dashboardSidebar">
        <button class="sidebarButton" onclick="showDiv(1)">Cerca Libro</button>
        <button class="sidebarButton" onclick="showDiv(2)">Prestiti</button>
        <button class="sidebarButton" onclick="showDiv(3)">Recensioni</button>
    </div>

    <div class="itemsMargin flex" id="dashboardHeader" style="justify-content: end;">
        <div class=" flex center">
            <div class="flex logoutButton">
                <div>
                    <img src="images/logoutLogo.svg" alt="headedrLogo">
                    <a href="logout.php">Logout</a>
                </div>
                <div>
                    <form action="" method="post"><button type="submit" name="deleteAccount">Nuclearizza
                            account</button></form>
                </div>
            </div>
        </div>
    </div>



    <main>
        <div class="itemsMargim" style="height:100%" id="dashboardMainContent" style="height:inherit;">
            <div id="div0" class="defaultPanel content-div">
                <h1>School dashboard</h1>
                <p>by De Zuani, Calizzano & Morabito
                <p>
                <p style="color:#2563eb;">Seleziona un'opzione</p>
            </div>

            <div id="div1" class="content-div gridTemplate parentHeight gridCenter">
                <div class="item">

                    <table class="userTable">
                        <?php
                        if (isset($_POST['searchBookButton'])) {
                            /*if(isset($_POST['searchBookButton'])){
                                $queryStr = "SELECT * FROM  libri WHERE 1=1";
                                
                                if(!$_POST['titolo']==""){
                                    echo "ho il titolo<br>";
                                    $queryStr.=" AND ? LIKE titolo";
                                   
                                }
                                if(!$_POST['autore']==""){
                                    echo "ho il autore<br>";
                                    $queryStr.=" AND ? LIKE autore";
                                    
                                }
                                if(!$_POST['generi']==""){
                                    echo "ho il genere<br>";
                                    $queryStr.=" AND ? LIKE genere";
                                   
                                }

                                
                                    $query = $connessione -> prepare($queryStr);*/

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

                                while ($row = $result->fetch_array()) {

                                    echo "<tr>";
                                    echo "<td>" . $row['isbn'] . "</td>";
                                    echo "<td>" . $row['titolo'] . "</td>";
                                    echo "<td>" . $row['autore'] . "</td>";
                                    echo "<td>" . $row['anno_pubblicazione'] . "</td>";
                                    echo "<td>" . $row['genere'] . "</td>";
                                    echo "<td>" . $row['quantita'] . "</td>";
                                }
                                echo "</table>";
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
                                $getBooksquery = "SELECT isbn, titolo, autore, anno_pubblicazione, genere, quantita FROM libri";
                                $result = $connessione->query($getBooksquery);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['isbn'] . "</td>";
                                    echo "<td>" . $row['titolo'] . "</td>";
                                    echo "<td>" . $row['autore'] . "</td>";
                                    echo "<td>" . $row['anno_pubblicazione'] . "</td>";
                                    echo "<td>" . $row['genere'] . "</td>";
                                    echo "<td>" . $row['quantita'] . "</td>";
                                    ?>
                                    <form method="post">
                                        <td><button type='submit' name='deleteBookButton'
                                                value="<?php echo $row['isbn'] ?>">Elimina</button></td>

                                    </form>
                                    <form action="modifyBook.php" method="post">
                                        <td><button type='submit' name='modifyBookButton'
                                                value="<?php echo $row['isbn'] ?>">Modifica</button></td>
                                    </form>
                                    </tr>
                                    <?php
                                }
                        }
                        ?>
                        </table>

                </div>
            </div>

            <div id="div2" class="content-div gridTemplate parentHeight gridCenter">
                <div class="item">


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
Faccio una tabella per mostrare i libri presi in prestito dall'utente ( controllando dalla tabella prestiti l'id_utente) e faccio un bottone per resitutire il libro, aumentando così la quantità disponibile di quel libro
e sotto faccio una tabella con tutti i libri nella tabella libri che controlla quando premo il tasto prendi in prestito se quantita > 0, altrimenti alert con errore */
                        $getBooksquery = "SELECT isbn, titolo, autore, anno_pubblicazione, genere, quantita FROM libri";
                        $result = $connessione->prepare($getBooksquery);
                        $result->execute();
                        $resultBooks = $result->get_result();
                        while ($row = $resultBooks->fetch_assoc()) {
                            
                            echo "<tr>";
                            echo "<td>" . $row['isbn'] . "</td>";
                            echo "<td>" . $row['titolo'] . "</td>";
                            echo "<td>" . $row['autore'] . "</td>";
                            echo "<td>" . $row['anno_pubblicazione'] . "</td>";
                            echo "<td>" . $row['genere'] . "</td>";
                            echo "<td>" . $row['quantita'] . "</td>";
                            ?>
                            <form method="post">
                                <td><button type='submit' name='prendiPrestito' value="<?php echo $row['isbn'] ?>">Prendi in prestito</button></td>
                            </form>
                            </tr>
                            <?php
                        }
                        echo "</table>";
                        ?>
                        <div class="item">
                            
                            <table class="userTable">
                                <th>Isbn</th>
                                <th>Titolo</th>
                                <th>Autore</th>
                                <th>Anno di Pubblicazione</th>
                                <th>Genere</th>
                                <th>Quantita rimasta</th>
                                <th>Restituisci</th>
                        <?php
                        // Mostrare i libri presi in prestito dall'utente (controllando dalla tabella prestiti l'id_utente)
                        $getPrestitiQuery = "SELECT l.isbn, l.titolo, l.autore, l.anno_pubblicazione, l.genere, l.quantita
                        FROM libri l
                        INNER JOIN prestiti p ON l.id = p.id_libro
                        WHERE p.id_utente = ?;";
                        $preparedQuery = $connessione->prepare($getPrestitiQuery);
                        $preparedQuery->bind_param("i", $id_utente);
                        $preparedQuery->execute();
                        $resultPrestiti = $preparedQuery->get_result();
                        
                        while ($rowPrestiti = $resultPrestiti->fetch_assoc()) {
                            
                            echo "<tr>";
                            echo "<td>" . $rowPrestiti['isbn'] . "</td>";
                            echo "<td>" . $rowPrestiti['titolo'] . "</td>";
                            echo "<td>" . $rowPrestiti['autore'] . "</td>";
                            echo "<td>" . $rowPrestiti['anno_pubblicazione'] . "</td>";
                            echo "<td>" . $rowPrestiti['genere'] . "</td>";
                            echo "<td>" . $rowPrestiti['quantita'] . "</td>";
                            ?>
                            <form method="post">
                                <td><button type='submit' name='restituisciLibro'
                                        value="<?php echo $rowPrestiti['isbn'] ?>">Restituisci</button></td>
                            </form>
                        </tr>
                            <?php
                        }
                        ?>
                        </table>
                        
                    </div>
                </div>
            </div>

            <div id="div3" class="content-div gridTemplate parentHeight gridCenter">
                <div class="item">
                    <table class="userTable">
                        <th>Isbn</th>
                        <th>Titolo</th>
                        <th>Autore</th>
                        <th>Anno di Pubblicazione</th>
                        <th>Genere</th>
                        <th>Quantita rimasta</th>
                        <th>Morte</th>
                        <?php
                        $getBooksquery = "SELECT isbn, titolo, autore, anno_pubblicazione, genere, quantita FROM libri";
                        $result = $connessione->query($getBooksquery);
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['isbn'] . "</td>";
                            echo "<td>" . $row['titolo'] . "</td>";
                            echo "<td>" . $row['autore'] . "</td>";
                            echo "<td>" . $row['anno_pubblicazione']. "</td>";
                            echo "<td>" . $row['genere'] . "</td>";
                            echo "<td>" . $row['quantita'] . "</td>";
                            ?>
                            <td>
                                <form action="recensioni_libro.php" method="post">
                                    <button type="submit" name="readReviews" value="<?php echo $row['isbn']; ?>">Leggi
                                        recensioni</button>
                                </form>
                            </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>

                </div>
            </div>
        </div>
    </main>

</body>

</html>