<?php
include 'connect.php';
include 'utility.php';
include 'paths.php';

session_start();

/*
Ako postoji aktivna sesija, prvo ćemo provjeriti razinu korisničkih prava.
Ako korisnik ima administratorske ovlasti, bit će preusmjeren na stranicu za unos novih vijesti.
U suprotnom, ako korisnik nema administratorske ovlasti, bit će prikazana poruka
da nema dozvolu za pristup kao administrator i biti će preusmjeren na početnu stranicu. */
if (isset($_SESSION['username'])) {
    
    $username = $_SESSION['username'];
    
    
    if ($_SESSION['user_level'] == 1) {
        header('Location: ' . INSERT_ARTICLE); 
        exit;

    } else {
        echo '<script>
                alert("User ' . $username . ' is not logged in as admin!");
                window.location.href = "' . HOME . '";
              </script>';

        exit;
    }
}



/*
Ovaj dio koda se izvrsava ako je forma ispunjena u potpunosti. 
Provjeravamo u bazi da li postoji korisnik sa navedenim username-om i password-om, 
i ako postoji, postavljamo sesiju te preusmjeravamo na početnu stranicu. 
Ako ne postoji takav korisnik, šaljemo notifikaciju i ponovno preusmjeravamo na login.
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($dbc, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username=?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        displayErrorMessage("There was an error processing your request. Please try again later.", HOME);
    } else {
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            mysqli_close($dbc);

            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['user_level'] = $user['level']; 
                echo "<script>
                        setTimeout(function() {
                            window.location.href = '" . HOME . "';
                        }, 200);
                     </script>";
                     exit;
            } else {
                echo '<script>
                        alert("Password is incorrect.");
                        window.location.href = "' . LOGIN . '"; 
                     </script>';
                     exit;
            }
        }else{
            echo '<script>
                        alert("Username is incorrect.");
                        window.location.href = "' . LOGIN . '"; 
                     </script>';
                     exit;

        }
    }
  
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
</head>
<body>
    <header>
        <div>
            <h1><img id="logo" src="<?php echo UPLPATH; ?>logo.png" alt="Le Parisien Logo"></h1>
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

    <div class="login-container">
        <h2>Login</h2>
        <form action="<?php echo ADMINISTRATION; ?>" method="POST" class="login-form">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login" class="login-button">
            <button onclick="location.href='<?php echo REGISTER; ?>'" class="register-button">Register</button>
        </form>
    </div>

    <footer>
        &copy; Le Parisien by Leon Šarko
    
    </footer>
</body>
</html>