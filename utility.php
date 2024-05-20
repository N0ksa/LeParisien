<?php

//Pomoćne metode za generiranje poruka, vijesti...

function displaySuccessMessage($message, $redirectUrl = null) {
    echo "<script>alert('$message');</script>";
    echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>";
    echo "<img src='images/success.gif' alt='Success' width='200' height='200'>";
    echo "</div>";
    if ($redirectUrl) {
        echo "<script>setTimeout(function(){window.location.href='$redirectUrl';}, 2000);</script>";
    }
}

function displayErrorMessage($message, $redirectUrl = null) {
    echo "<script>alert('$message');</script>";
    echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>";
    echo "<img src='images/poop.gif' alt='Error'>";
    echo "</div>";
    if ($redirectUrl) {
        echo "<script>setTimeout(function(){window.location.href='$redirectUrl';}, 2000);</script>";
    }
}


function display404Message($message, $redirectUrl = null) {
    echo "<script>alert('$message');</script>";
    echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>";
    echo "<img src='images/error_404.gif' alt='Article not found'>";
    echo "</div>";
    if ($redirectUrl) {
        echo "<script>setTimeout(function(){window.location.href='$redirectUrl';}, 2000);</script>";
    }
}


function generateLoginButton() {
    echo '<li><a href="login.php" class="login-button">Login</a></li>';
}

function generateLogoutButton($username) {
    echo '<li><a href="logout.php" class="logout-button">Logout (<span id="loggedUser">' . $username . '</span>)</a></li>';
}



function generateArticleSection($dbc, $category)
{
    $query = "SELECT * FROM articles WHERE archive=0 AND category='$category' ORDER BY STR_TO_DATE(articleDate, '%Y-%m-%d %H:%i:%s') DESC LIMIT 3";
    $result = mysqli_query($dbc, $query);
    while($row = mysqli_fetch_array($result)) {
        echo '
            <article class="col-lg-4 col-md-6 col-sm-12">
                <div class="image-container">
                    <img src="' . UPLPATH . $row['imagePath'] . '" alt="' . $row['title'] . '">
                </div>
                <h3><a href="article.php?id=' . $row['id'] . '">' . $row['title'] . '</a></h3>
            </article>';
    }
}

function generateArticles($dbc, $category)
{
    $query = "SELECT * FROM articles WHERE archive=0 AND category='$category' ORDER BY STR_TO_DATE(articleDate, '%Y-%m-%d %H:%i:%s') DESC";
    $result = mysqli_query($dbc, $query);

    echo '<div class="row">';
    while ($row = mysqli_fetch_array($result)) {
        echo '<article class="col-lg-4 col-md-6 col-sm-12">';
        echo '<div class="image-container">';
        echo '<img src="' . UPLPATH . $row['imagePath'] . '" alt="' . $row['title'] . '">';
        echo '</div>';
        echo '<h3><a href="article.php?id=' . $row['id'] . '">' . $row['title'] . '</a></h3>';
        echo '</article>';
    }
    echo '</div>';

    mysqli_close($dbc);
}

function displayArticle($article)
{
    include_once 'paths.php';
    session_start(); 
    
    ob_start(); 
    
    
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $article['title'] . '</title>
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    </head>
    <body>
    
    <header>
        <div><h1><img id="logo" src="./images/logo.png" alt="Le Parisien Logo"></h1></div>
        <hr id="headerHr">
        <nav>
            <ul>
                <li><a href="' . HOME . '">Home</a></li>
                <li><a href="' . POLITICS . '">Politics</a></li>
                <li><a href="' . SPORTS . '">Sport</a></li>
                <li><a href="' . LOGIN . '">Administration</a></li>';
                
    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        generateLogoutButton($username); 
    } else {
        generateLoginButton(); 
    }

    echo '</ul>
        </nav> 
    </header>
    
    <main class="container articleContainer">
        <article class="articleCard">
            <h1>' . $article['title'] . '</h1>
            <div class="article-image">
                <img src="' . UPLPATH . $article['imagePath'] . '" alt="' . $article['title'] . '">
            </div>
            <h2>' . $article['summary'] . '</h2>
            <p>' . $article['articleText'] . '</p>
        </article>
    </main>
    
    <footer>
        <hr id="footerHr">
        &copy; Le Parisien by Leon Šarko
    </footer>
    
    </body>
    </html>';
    
    
    $output = ob_get_clean();
    
    echo $output; 
}
