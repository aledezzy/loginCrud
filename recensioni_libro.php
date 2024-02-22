<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<?php
/*include the class connection.php*/
include 'includes/connection.php';
//start the session
session_start();
$connessione = Connection::new();

if(isset($_POST['newBookReview'])){

    $getUserIDbyMAIL = "SELECT id from utenti WHERE email = ?";
    $preparedUserQuery = $connessione -> prepare($getUserIDbyMAIL);
    $preparedUserQuery->bind_param("s", $_SESSION['user']);
    $preparedUserQuery->execute();
    $result = $preparedUserQuery->get_result();
    while($row = $result->fetch_assoc()){
        $userID = $row['id'];
    }

    $bookID = $_POST['bookID'];
    $bookReview = $_POST['review_body'];
    $bookRating = $_POST['review_rating'];

    $newReviewQuery = "INSERT INTO recensioni(id_libro, id_utente, voto, testo) VALUES (?, ?, ?, ?)";
    $insertBookQuery = $connessione -> prepare($newReviewQuery);
    $insertBookQuery->bind_param("iiis", $bookID, $userID, $bookRating, $bookReview);
    $insertBookQuery->execute();
    

}

if(isset($_POST['readReviews'])) {
    $getBookIDbyISBN = "SELECT id from libri WHERE isbn = ?";
    $preparedQuery = $connessione -> prepare($getBookIDbyISBN);
    $preparedQuery->bind_param("s", $_POST['readReviews']);
    $preparedQuery->execute();
    $result = $preparedQuery->get_result();
    while($row = $result->fetch_assoc()){
        $bookID = $row['id'];
    }
    $result -> free_result();

    $getBookReviews = "SELECT testo, data_recensione, voto FROM recensioni WHERE id_libro = ?";
    $preparedReviewQuery = $connessione -> prepare($getBookReviews);
    $preparedReviewQuery->bind_param("i", $bookID);
    $preparedReviewQuery->execute();
    $result = $preparedReviewQuery->get_result();
    while($row = $result->fetch_assoc()){
        
?>
    <table class="userTable">
        <th>Testo</th>
        <th>Data Recensione</th>
        <th>Vot ( 1- 10 )</th>
        <tr>
            <td><?php echo $row['testo']?></td>
            <td><?php echo $row['data_recensione']?></td>
            <td><?php echo $row['voto']?></td>
        </tr>
    </table>
    
    <?php
    }
} else{
    header("Location: dashboardUtenti.php");
    die();
}
?>
<form action="" method="post">
    <input type="text" name="review_body" >
    <input type="text" name="review_rating" >
    <input type="hidden" name="bookID" value="<?php echo $bookID?>">    
    <button type="submit" name="newBookReview">Lascia una recensione per questo libr</button>
</form>
</body>
</html>