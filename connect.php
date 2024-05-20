<?php

header('Content-Type: text/html; charset=utf-8');

$servername = "localhost";
$username = "root";
$password = "";
$basename = "le_parisien";

try {
   
    $dbc = mysqli_connect($servername, $username, $password, $basename);
    mysqli_set_charset($dbc, "utf8");

} catch (mysqli_sql_exception $e) {
    
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="images/favicon.ico" type="image/x-icon">
        <title>Error</title>
        <style>
            body {
                
                background-color: #f0f0f0;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            .container {
                max-width: 600px;
                padding: 20px;
                text-align: center;
            }
            h1 {
                color: #ff0000;
                margin-bottom: 20px;
            }
            img {
                max-width: 100%;
                height: auto;
                margin-bottom: 20px;
            }
            p {
                margin-bottom: 20px;
            }
        </style>

    </head>
    <body>
        <div class="container">
            <h1>Error</h1>
            <p>Sorry, there was a problem connecting to the database. Please try again later.</p>
            <p>Error message: <?php echo $e->getMessage(); ?></p>
            <img src="images/no_connection_to_database.jpg" alt="No connection to database">
        </div>
    </body>
    </html>
    <?php
    
   
    exit();
}

?>
