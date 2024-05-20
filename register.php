<?php
include 'paths.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
</head>
<body>
    <header>
        <div>
            <h1><img id="logo" src="./images/logo.png" alt="Le Parisien Logo"></h1>
        </div>
        <hr id="headerHr">
        <nav>
            <ul>
                <li><a href="<?php echo HOME; ?>">Home</a></li>
                <li><a href="<?php echo SPORTS; ?>">Sports</a></li>
                <li><a href="<?php echo POLITICS; ?>">Politics</a></li>
                <li><a href="<?php echo ADMINISTRATION; ?>">Administration</a></li>
            </ul>
        </nav> 
    </header>

    <div class="register-container">
        <h2>Register</h2>
        <form action="register.php" method="POST" class="register-form" id="registerForm">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>
            <div id="nameError" class="error" style="display:none;">Please enter your name.</div><br>

            <label for="surname">Surname:</label>
            <input type="text" id="surname" name="surname" required><br>
            <div id="surnameError" class="error" style="display:none;">Please enter your surname.</div><br>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <div id="usernameError" class="error" style="display:none;">Please enter a username.</div><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <div id="passwordError" class="error" style="display:none;">Please enter a password.</div><br>

            <label for="repeat-password">Repeat Password:</label>
            <input type="password" id="repeat-password" name="repeat-password" required><br>
            <div id="repeatPasswordError" class="error" style="display:none;">Passwords do not match.</div><br>

            <input type="submit" value="Register" class="register-button">
        </form>
    </div>

    <footer>
        <hr id="footerHr">
        &copy; Le Parisien by Leon Šarko
    
    </footer>


    <script src="register.js"></script>
</body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include 'connect.php';
    include 'utility.php';

    // Ovaj dio koda se izvršava ako je prošla validacija putem javascripta. 
    // Iz baze provjeravamo da li username postoji. Ako postoji, onda prikazujemo div sa notifikacijom da je username zauzet.
    // Ako je username dostupan, registriramo korisnika u bazi i preusmjeravamo ga prema login stranici.
    // Prilikom registracije korisnik dobiva default level 0 što označava da nema administracijska prava.
    
    $name = mysqli_real_escape_string($dbc, $_POST['name']);
    $surname = mysqli_real_escape_string($dbc, $_POST['surname']);
    $username = mysqli_real_escape_string($dbc, $_POST['username']);
    $password = mysqli_real_escape_string($dbc, $_POST['password']);
    $repeatPassword = mysqli_real_escape_string($dbc, $_POST['repeat-password']);

    
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    
    $checkQuery = "SELECT * FROM users WHERE username = '$username'";
    $checkResult = mysqli_query($dbc, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {

        echo "<script>";
        echo "document.getElementById('usernameError').innerText = 'Username already exists. Please choose a different username.';"; 
        echo "document.getElementById('usernameError').style.display = 'block';";
        echo "</script>";

    } else {

        $userLevel = 0;
        
        $query = "INSERT INTO users (name, surname, username, password, level) VALUES ('$name', '$surname', '$username', '$hashedPassword', $userLevel)";

        $result = mysqli_query($dbc, $query);
        mysqli_close($dbc);

        if ($result) {

            displaySuccessMessage("Registration successful", LOGIN);

        } else {
            displayErrorMessage('Database error. Please try again later.', REGISTER);
        }
    }
}

?>