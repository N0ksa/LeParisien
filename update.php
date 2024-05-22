<?php

include 'connect.php';
include 'utility.php';
include 'paths.php';
include 'queries.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        
        $query = QUERY_GET_IMAGE_BY_ID;
        $stmt = mysqli_prepare($dbc, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $imageFileName);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($imageFileName) {
            $imagePath = "images/" . $imageFileName;
            
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $query = QUERY_DELETE_ARTICLE_BY_ID;
        $stmt = mysqli_prepare($dbc, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            displaySuccessMessage('Article and associated image successfully deleted.', INPUT);
        } else {
            displayErrorMessage("Unable to delete article.", INPUT);
        }
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $about = $_POST['about'];
        $content = $_POST['content'];
        $category = $_POST['category'];
        $archive = isset($_POST['archive']) ? 1 : 0;

        if ($_FILES['photo']['size'] > 0) {
            $query = QUERY_GET_IMAGE_BY_ID;
            $stmt = mysqli_prepare($dbc, $query);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $oldImageFileName);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            if ($oldImageFileName) {
                $oldImagePath = "images/" . $oldImageFileName;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $target_dir = "images/";
            $target_file = $target_dir . basename($_FILES["photo"]["name"]);

            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $newImageFileName = basename($_FILES["photo"]["name"]);
                $query = QUERY_UPDATE_ARTICLE_WITH_IMAGE;
                $stmt = mysqli_prepare($dbc, $query);
                mysqli_stmt_bind_param($stmt, "ssssisi", $title, $about, $content, $category, $archive, $newImageFileName, $id);
                
                if (mysqli_stmt_execute($stmt)) {
                    if ($archive) {
                        displaySuccessMessage('Article successfully archived.', INPUT);
                    } else {
                        displaySuccessMessage('Article successfully updated.', "article.php?id=$id");
                    }
                } else {
                    displayErrorMessage("Error updating article.", INPUT);
                }

                mysqli_stmt_close($stmt);
            } else {
                displayErrorMessage("Unable to upload image.", INPUT);
            }
        } else {
            $query = QUERY_UPDATE_ARTICLE_WITHOUT_IMAGE;
            $stmt = mysqli_prepare($dbc, $query);
            mysqli_stmt_bind_param($stmt, "ssssii", $title, $about, $content, $category, $archive, $id);
            
            if (mysqli_stmt_execute($stmt)) {
                if ($archive) {
                    displaySuccessMessage('Article successfully archived.', INPUT);
                } else {
                    displaySuccessMessage('Article successfully updated.', "article.php?id=$id");
                }
            } else {
                displayErrorMessage("Error updating article.", INPUT);
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($dbc);

} else {
    mysqli_close($dbc);
    displayErrorMessage("You cannot directly access this page.", HOME);
}

?>
