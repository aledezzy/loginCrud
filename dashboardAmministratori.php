<?php
/*include the class connection.php*/
include 'includes/connection.php';
//start the session
session_start();
$connessione = Connection::new();

if (isset($_SESSION['user'])) {
    if ($_SESSION['role'] == "user") {
        header("Location: dashboardUtenti.php");
        die();
    }
}else{
    header("Location: login.php");
    die();
}

if(isset($_POST['deleteUserButton'])){
    $connessione -> query("DELETE FROM utenti WHERE email='".$_POST['deleteUserButton']."'");
}
if(isset($_POST['deleteBookButton'])){
    $connessione -> query("DELETE FROM libri WHERE isbn='".$_POST['deleteBookButton']."'");
}
if(isset($_POST['addUser'])){
    $query = "INSERT INTO utenti (nome, cognome, email, password) VALUES (?, ?, ?, ?)";
    $preparedQuery = $connessione->prepare($query);
    $preparedQuery->bind_param("ssss", $_POST['nome'], $_POST['cognome'], $_POST['email'], $_POST['password']);
    $preparedQuery->execute();
}
if(isset($_POST['AddBook'])){
    $query = "INSERT INTO utenti (nome, cognome, email, password) VALUES (?, ?, ?, ?)";
    $preparedQuery = $connessione->prepare($query);
    $preparedQuery->bind_param("ssss", $_POST['nome'], $_POST['cognome'], $_POST['email'], $_POST['password']);
    $preparedQuery->execute();
}
if(isset($_POST['searchBook'])){
    $query = "INSERT INTO utenti (nome, cognome, email, password) VALUES (?, ?, ?, ?)";
    $preparedQuery = $connessione->prepare($query);
    $preparedQuery->bind_param("ssss", $_POST['nome'], $_POST['cognome'], $_POST['email'], $_POST['password']);
    $preparedQuery->execute();
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Amministratori</title>
    <link href="styles/dashboard.css" rel="stylesheet" />
    <script src="script/divSelector.js"></script>
</head>

<body>
    <div class="sidebarGridTemplate"
    id="dashboardSidebar">
        <button class="sidebarButton" onclick="showDiv(1)">Gestione Utenti</button>
        <button class="sidebarButton" onclick="showDiv(2)">Libreria</button>
        <button class="sidebarButton" onclick="showDiv(3)">Gestione Libri</button>
    </div>

    <div class="itemsMargin flex" id="dashboardHeader" style="justify-content: end;">
        <div class=" flex center">
            <div class="flex logoutButton">
            <img src="images/logoutLogo.svg" alt="headedrLogo">
            <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>



    <main>
        <div class="itemsMargim" style="height:100%" id="dashboardMainContent" style="height:inherit;">
             <div id="div0" class="defaultPanel content-div">
                <h1 class="itemsMargin" style="color:#2563eb">School dashboard</h1>
                <p class="itemsMargin">by De Zuani, Calizzano & Morabito<p>
                <p class="itemsMargin" style="color:#2563eb;">Seleziona un'opzione</p>
             </div>

            <div id="div1" class="content-div parentHeight">
                <div class="item">
                <table class="userTable">
                            <caption><strong>Aggiungi utente</strong></caption>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>E-mail</th>
                            <th>Password</th>
                            <th></th>
                        <form method="post">
                            <tr>
                            <td><input class="userAddButton" type="text" name="nome"></td>
                            <td><input class="userAddButton" type="text" name="cognome"></td>
                            <td><input class="userAddButton" type="text" name="email"></td>
                            <td><input class="userAddButton" type="text" name="password"></td>
                            <td><button type='submit' name='addUser'>Aggiungi</button></td>
                            </tr>
                        </form>
                    </table>
                        
                    <h1>Lista Utenti</h1>
                    <table class="userTable">

                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>E-mail</th>
                        <th>Ruolo</th>
                        <th>Data Registrazione</th>
                        <th>Elimina</th>
                        <th>Disabilita</th>
                    <?php
                        $getUsersquery="SELECT nome, cognome, email, ruolo, data_registrazione FROM utenti";
                        $result = $connessione -> query($getUsersquery);
                        while($row = $result->fetch_assoc()){
                           if($row['ruolo'] != 'admin'){
                    ?>
                            <tr>
                            <td class="boh"><?php echo $row['nome']?></td>
                            <td><?php echo $row['cognome']?></td>
                            <td><?php echo $row['email']?></td>
                            <td><?php echo $row['ruolo']?></td>
                            <td><?php echo $row['data_registrazione']?></td>
                            <form method="post">
                            <td><button type='submit' name='deleteUserButton' value="<?php echo $row['email'];?>">Elimina</button></td>
                            <td><button type='submit' name='disableUserButton' value="<?php echo $row['email'];?>">Disabilita</button></td>
                            </form>
                           </tr>
                           <?php
                            }
                        }
                        $result -> free_result();
                        
                        ?>
                        </table>
                        

                </div>
            </div>

        <div id="div2" class="content-div parentHeight gridCenter">
            <div class="item">
            <table class="userTable">
                            <caption><strong>Ricerca libro</strong></caption>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>E-mail</th>
                            <th>Password</th>
                            <th></th>
                        <form method="post">
                            <tr>
                            <td><input class="userAddButton" type="text" name="nome"></td>
                            <td><input class="userAddButton" type="text" name="cognome"></td>
                            <td><input class="userAddButton" type="text" name="email"></td>
                            <td><input class="userAddButton" type="text" name="password"></td>
                            <td><button type='submit' name='addUser'>Aggiungi</button></td>
                            </tr>
                        </form>
            </table>
            <table>
                        <th>Isbn</th>
                        <th>Titolo</th>
                        <th>Autore</th>
                        <th>Anno di Pubblicazione</th>
                        <th>Genere</th>
                        <th>Quantita rimasta</th>
                        <th>Elimina</th>
                        <th>Disabilita</th>
            <?php
                $getBooksquery="SELECT isbn, titolo, autore, anno_pubblicazione, genere, quantita FROM libri";
                $result = $connessione -> query($getBooksquery);
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$row['isbn']."</td>";
                    echo "<td>".$row['titolo']."</td>";
                    echo "<td>".$row['autore']."</td>";
                    echo "<td>".$row['anno_pubblicazione']."</td>";
                    echo "<td>".$row['genere']."</td>";
                    echo "<td>".$row['quantita']."</td>";
            ?>
                    <form method="post">
                        <td><button type='submit' name='deleteBookButton' value="<?php echo $row['isbn']?>">Elimina</button></td>
                        <td><button type='submit' name='disableBookButton' value="<?php echo $row['isbn'] ?>">Disabilita</button></td>
                    </form>
                    </tr>
            <?php
                }
            ?>
            </table>
            </div>
        </div>

        <div id="div3" class="content-div  parentHeight gridCenter">
            <div class="item" style="color:#2563eb">hgdsf</div>
            <div class="item"></div>
            <div class="item">

            </div>
            <div class="item">

            </div>
        </div>
    </div>
    </div>

        </div>
    </main>
        
</body>
</html>
