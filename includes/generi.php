<?php
/**
* Questo script PHP recupera i generi distinti dalla tabella "libri" e li stampa come opzioni all'interno di un elemento select HTML.
* Utilizza la classe Connection per stabilire una connessione al database.
* 
* @param void
* @return void
*/

    include_once 'connection.php';
    $connection = Connection::new();
    $genreQuery = "SELECT DISTINCT genere FROM libri";
    $result = $connection -> query($genreQuery);
    while ($row = $result->fetch_assoc()) {
        echo "<option value=".$row['genere'].">".$row['genere']."</option>";
    }
    $connection->close();
    
?>
