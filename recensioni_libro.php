<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <style>
        body{margin:0;}
        p{margin:5px 10px;}
    </style> <!-- MI DISPIACE -->
    <div class="bookReviewNavbar" >
        <a  href="dashboardUtenti.php">Ritorna alla dashboard</a>
    </div>  

    <h1 style="text-align:center">INSERISCI RECENSIONE PER QUESTO LIBRO</h1>
    <div class="flex" style="align-items:center">
        <form action="" method="post">
            <input type="text" name="review_body">
            <input type="text" name="review_rating">
            <input type="hidden" name="bookID" value="<?php echo $bookID ?>">
            <button type="submit" name="newBookReview">Lascia recensione</button>
        </form>
        <div style="margin:auto">
            <h2><?php echo htmlentities($_POST['bookName']) ?></h2>
            <h2><?php echo htmlentities($_POST['bookAuthor']) ?></h2>
        </div>
    </div>

    <?php
    /*include the class connection.php*/
    include 'includes/connection.php';
    //start the session
    session_start();
    $connessione = Connection::new();

    if (isset($_POST['newBookReview']) ) {

        $queryStr = "SELECT id from utenti WHERE email = ?";
        $preparedQuery = $connessione->prepare($queryStr);
        $preparedQuery->bind_param("s", $_SESSION['user']);
        $preparedQuery->execute();
        $result = $preparedQuery->get_result();
        while ($row = $result->fetch_assoc()) {
            $userID = $row['id'];
        }

        $bookID = $_POST['bookID'];
        $bookReview = $_POST['review_body'];
        $bookRating = ($_POST['review_rating'] <= '0' || $_POST['review_rating'] > '10') ? 0 : $_POST['review_rating'];

        $queryStr = "INSERT INTO recensioni(id_libro, id_utente, voto, testo) VALUES (?, ?, ?, ?)";
        $preparedQuery = $connessione->prepare($queryStr);
        $preparedQuery->bind_param("iiis", $bookID, $userID, $bookRating, $bookReview);
        $preparedQuery->execute();

    }

    if (isset($_POST['readReviews']) || isset($_POST['bookID'])) {
        if(isset($_POST['$bookID'])){
            $bookID = $_POST['$bookID'];
        } else{
            $queryStr = "SELECT id from libri WHERE isbn = ?";
            $preparedQuery = $connessione->prepare($queryStr);
            $preparedQuery->bind_param("s", $_POST['readReviews']);
            $preparedQuery->execute();
            $result = $preparedQuery->get_result();
            while ($row = $result->fetch_assoc()) {
                $bookID = $row['id'];
            }
            $result->free_result();
        }

        $queryStr = "SELECT testo, data_recensione, voto FROM recensioni WHERE id_libro = ?";
        $preparedQuery = $connessione->prepare($queryStr);
        $preparedQuery->bind_param("i", $bookID);
        $preparedQuery->execute();
        $result = $preparedQuery->get_result();

            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="reviewBox">
                    <div class="flex" style="border-bottom: 1px solid black; flex-wrap: wrap;">
                        <p><?php echo $_SESSION['user']?></p>
                        <p class=><?php echo $row['data_recensione'] ?></p>
                        <p><?php echo $row['voto'] ?></p>
                    </div>
                    <p><?php echo $row['testo'] ?></p>
                </div>

            <?php
            }
    }       
            ?>

    
</body>

</html>