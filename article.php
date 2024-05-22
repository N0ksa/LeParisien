<?php
include 'connect.php'; 
include 'utility.php';
include 'paths.php'; 
include 'queries.php';

if(isset($_GET['id'])) {

    $id = $_GET['id'];

    $query = QUERY_SELECT_ARTICLE_BY_ID;
    $stmt = mysqli_prepare($dbc, $query);
    
    mysqli_stmt_bind_param($stmt, 'i', $id);
    
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);

    if($result && mysqli_num_rows($result) > 0) {

        $article = mysqli_fetch_assoc($result);
        mysqli_free_result($result); 
        mysqli_stmt_close($stmt); 
        mysqli_close($dbc); 
        displayArticle($article);
    } else {
        mysqli_close($dbc); 
        display404Message("Article not found", HOME);
    }
} else {
    
    mysqli_close($dbc); 
    display404Message("Article ID not found", HOME);
}
?>
