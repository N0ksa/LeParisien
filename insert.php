<?php
include 'connect.php';
include 'utility.php';
include 'paths.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['title']) && isset($_POST['about']) && isset($_POST['content']) && isset($_FILES['photo'])) {
     
        $title = $_POST['title'];
        $about = $_POST['about'];
        $content = $_POST['content'];
        $category = $_POST['category'];
        
        
        $archive = isset($_POST['archive']) ? 1 : 0;

       
        $picture = basename($_FILES["photo"]["name"]);
        $targetFile = IMAGE_UPLOAD_DIR . $picture;
        
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
            
            $date = date('Y-m-d H:i:s');
            
            $query = "INSERT INTO articles (articleDate, title, summary, articleText, imagePath, category, archive) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            
           
            $stmt = mysqli_prepare($dbc, $query);
            
          
            mysqli_stmt_bind_param($stmt, "ssssssi", $date, $title, $about, $content, $picture, $category, $archive);
            
        
            $success = mysqli_stmt_execute($stmt);
            
          
            if ($success) {
               
                if ($archive) {
                    displaySuccessMessage('Article successfully archived.', INSERT_ARTICLE);
                } else {
                    
                    displaySuccessMessage('Article successfully created.', "article.php?id=" . mysqli_insert_id($dbc));
                }
            } else {
                displayErrorMessage('Error saving to the database', INSERT_ARTICLE);
            }
            
           
            mysqli_stmt_close($stmt);
            mysqli_close($dbc);
            
        } else {
            displayErrorMessage('Error uploading image.', INSERT_ARTICLE);
        }
    } else {
        displayErrorMessage('Some of the required data is missing.', INSERT_ARTICLE);
    }
}
?>
