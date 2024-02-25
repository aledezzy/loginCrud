<?php
/*include the class connection.php*/
include 'includes/connection.php';
//start the session
session_start();
$connessione = Connection::new();

if (isset($_POST['deleteUserButton'])) {
    $queryStr = "UPDATE recensioni SET id_utente = null WHERE id_utente = ?";
    $preparedQuery = $connessione->prepare($queryStr);
    $preparedQuery->bind_param("s", $_POST['deleteUserButton']);
    $preparedQuery->execute();

    $queryStr = "DELETE * FROM prestiti WHERE id_utente = ?";
    $preparedQuery = $connessione->prepare($queryStr);
    $preparedQuery->bind_param("s", $_POST['deleteUserButton']);
    $preparedQuery->execute();

    $connessione->query("DELETE FROM utenti WHERE id='" . $_POST['deleteUserButton'] . "'");
}

if (isset($_POST['addUser'])) {
    $criptedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $query = "INSERT INTO utenti (nome, cognome, email, password) VALUES (?, ?, ?, ?)";
    $preparedQuery = $connessione->prepare($query);
    $preparedQuery->bind_param("ssss", $_POST['nome'], $_POST['cognome'], $_POST['email'], $criptedPassword);
    $preparedQuery->execute();
}

if (isset($_POST['disableUserButton'])) {
    $query = "INSERT INTO utentidisabilitati
              VALUES (?, ?)";
    $preparedQuery = $connessione->prepare($query);
    $state = 'si';
    $preparedQuery->bind_param("ss", $_POST['disableUserButton'], $state);
    $preparedQuery->execute();
}

if (isset($_POST['enableUserButton'])) {
    $query = "DELETE FROM utentidisabilitati
              WHERE email = ?";
    $preparedQuery = $connessione->prepare($query);
    $preparedQuery->bind_param("s", $_POST['enableUserButton']);
    $preparedQuery->execute();
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
        <th>Abilita/Disabilita</th>

        <?php
        $getUsersquery = "SELECT  id, nome, cognome, utenti.email, ruolo, data_registrazione, stato 
                                            FROM utenti
                                            LEFT JOIN utentidisabilitati ON utenti.email = utentidisabilitati.email";
        $result = $connessione->query($getUsersquery);
        while ($row = $result->fetch_assoc()) {
            if ($row['ruolo'] != 'admin') {
                ?>
                <tr>
                    <td class="boh">
                        <?php echo $row['nome'] ?>
                    </td>
                    <td>
                        <?php echo $row['cognome'] ?>
                    </td>
                    <td>
                        <?php echo $row['email'] ?>
                    </td>
                    <td>
                        <?php echo $row['ruolo'] ?>
                    </td>
                    <td>
                        <?php echo $row['data_registrazione'] ?>
                    </td>
                    <form method="post">
                        <td><button type='submit' name='deleteUserButton' value="<?php echo $row['id']; ?>">Elimina</button></td>
                        <?php
                        if ($row['stato'] == 'si') {
                            ?>
                            <td><button type='submit' name='enableUserButton' value="<?php echo $row['id']; ?>">Abilita</button></td>
                            <?php
                        } else {
                            ?>
                            <td><button type='submit' name='disableUserButton' value="<?php echo $row['id']; ?>">Disabilita</button>
                            </td>
                            <?php
                        }
                        ?>

                    </form>
                </tr>
                <?php
            }
        }
        $result->free_result();

        ?>
    </table>

</body>

</html>