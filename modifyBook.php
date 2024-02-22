<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>modifyBook</title>
</head>

<body>
    <table class="userTable">
        <th>Isbn</th>
        <th>Titolo</th>
        <th>Autore</th>
        <th>Anno di Pubblicazione</th>
        <th>Genere</th>
        <th>Quantita rimasto(Zocca)</th>
        <th></th>
</body>


<?php
/*include the class connection.php*/
include 'includes/connection.php';
//start the session
session_start();
$connessione = Connection::new();

if (isset($_SESSION['user'])) {
    if ($_SESSION['role'] == "user") {
        header("Location: login.php");
        die();
    }
}
if (isset($_POST['confirmButton'])) {
    $isbn = $_POST['isbn'];
    $titolo = $_POST['titolo'];
    $autore = $_POST['autore'];
    $anno_pubblicazione = $_POST['anno_pubblicazione'];
    $genere = $_POST['genere'];
    $quantita = $_POST['quantita'];
    var_dump($isbn, $titolo, $autore, $anno_pubblicazione, $genere, $quantita);
    $query = "UPDATE libri SET isbn = ?, titolo = ?, autore = ?, anno_pubblicazione = ?, genere = ?, quantita = ? WHERE isbn = ?";
    $query = $connessione->prepare($query);
    $query->bind_param("sssisis", $isbn, $titolo, $autore, $anno_pubblicazione, $genere, $quantita, $isbn);
    
    if ($query->execute()) {
        header("Location: dashboardAmministratori.php");
        die();
    } else {
        echo "Errore";
    }
}

$getBookQuery = "SELECT isbn, titolo, autore, anno_pubblicazione, genere, quantita FROM libri WHERE isbn = ?";
$query = $connessione->prepare($getBookQuery);
$query->bind_param("s", $_POST['modifyBookButton']);
$query->execute();
$result = $query->get_result();

while($row = $result->fetch_assoc()){
    echo "<tr>";
    echo "<td>".$row['isbn']."</td>";
    echo "<td>".$row['titolo']."</td>";
    echo "<td>".$row['autore']."</td>";
    echo "<td>".$row['anno_pubblicazione']."</td>";
    echo "<td>".$row['genere']."</td>";
    echo "<td>".$row['quantita']."</td>";
    echo "<tr>";


?>
    <form action="" method="post">
        <tr>
            <td><input type="text" name="isbn" value="<?php echo $row['isbn']?>"></td>
            <td><input type="text" name="titolo" value="<?php echo $row['titolo']?>"></td>
            <td><input type="text" name="autore" value="<?php echo $row['autore']?>"></td>
            <td><input type="text" name="anno_pubblicazione" value="<?php echo $row['anno_pubblicazione']?>"></td>
            <td><input type="text" name="genere" value="<?php echo $row['genere']?>"></td>
            <td><input type="text" name="quantita" value="<?php echo $row['quantita']?>"></td>
            <td><input type="submit" value="Conferma" name="confirmButton"></td>
        </tr>
    </form>

<?php
}
echo "</table>";

?>
</html>