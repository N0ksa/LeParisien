<?php
session_start(); 
include 'connect.php';
include 'utility.php'; 
include 'paths.php'; 

$category = isset($_GET['category']) ? mysqli_real_escape_string($dbc, $_GET['category']) : null;

if(!$category) {
    mysqli_connect($dbc);
    display404Message("Category not found", HOME);
    exit; 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category - <?php echo ucfirst($category); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                <?php
                 if(isset($_SESSION['username'])) {
                    $username = $_SESSION['username'];
                    generateLogoutButton($username);
                } else {
                    generateLoginButton(); 
                }
                ?>
            </ul>
        </nav> 
    </header>

    <main>
        <div class="container">
            <section class="<?php echo $category; ?>">
                <div class="row">
                    <div class="col-lg-12">
                        <hr class="categoryHr">
                        <h2><?php echo ucfirst($category); ?></h2>
                    </div>
                </div>
                <?php generateArticles($dbc, $category); ?>
            </section>
        </div>
    </main>

    <footer>
        <hr id="footerHr">
        &copy; Le Parisien by Leon Šarko
    
    </footer>

    <script src="article_appear_animation.js"></script>
</body>
</html>
