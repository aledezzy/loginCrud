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
        <a href="managers/manage_libri.php">Gestione Libri</a>
        <a href="managers/manage_prestiti.php">Gestione Prestiti</a>
        <a href="recensioni_libro.php">Recensioni</a>
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

            

            <div id="div2" class="content-div gridTemplate parentHeight gridCenter">
                <div class="item">

                cvoeihfo
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
                        $getBooksquery = "SELECT id, isbn, titolo, autore, anno_pubblicazione, genere, quantita FROM libri";
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
                                    <button type="submit" name="readReviews" value="<?php echo $row['id']; ?>">Leggi
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