<?php
include 'utility.php';
include 'connect.php';
include 'paths.php'; 
session_start();

// U slučaju da korisnik direktno pristupi putanji /programiranje_web_aplikacija/projekt/login.php
// Ovaj kod će ga preusmjeriti ako nije prijavljen ili nema administratorska prava.

if (!isset($_SESSION['username'])) {
    displayErrorMessage("Login to access Administration", LOGIN);
    mysqli_close($dbc);
    exit;
} elseif ($_SESSION['user_level'] == 0) {
    displayErrorMessage("User ".$_SESSION['username']." does not have administrative rights. Please login as admin", HOME);
    mysqli_close($dbc);
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Article</title>
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
                <li><a href="<?php echo POLITICS; ?>">Politics</a></li>
                <li><a href="<?php echo SPORTS; ?>">Sport</a></li>
                <li><a href="<?php echo ADMINISTRATION; ?>">Administration</a></li>
                <?php
                 $username = $_SESSION['username'];
                 generateLogoutButton($username);
                ?>
            </ul>
        </nav> 
    </header>

    <main class="container" id="articleFormsContainer">
        <h2>New Entry</h2>
        <form action="insert.php" method="POST" enctype="multipart/form-data">
            <div class="form-item">
                <label for="title">News Title</label>
                <div class="form-field">
                    <input type="text" name="title" class="form-field-textual">
                    <div id="titleError" class="error-message"></div>
                </div>
            </div>
        
            <div class="form-item">
                <label for="about">Summary (up to 50 characters)</label>
                <div class="form-field">
                    <textarea name="about" id="" class="form-field-textual" rows="4"></textarea>
                    <div id="aboutError" class="error-message"></div>
                </div>
            </div>
        
            <div class="form-item">
                <label for="content">Content</label>
                <div class="form-field">
                    <textarea name="content" id="" class="form-field-textual" rows="8"></textarea>
                    <div id="contentError" class="error-message"></div>
                </div>
            </div>
        
            <div class="form-item">
                <div class="form-field">
                    <div class="file-upload-container">
                        <label class="custom-file-input-label" for="file-upload">Choose Image</label>
                        <input type="file" id="file-upload" class="custom-file-input" name="photo"/>
                    </div>
                    <div id="photoError" class="error-message"></div>
                </div>
            </div>
        
            <div class="form-item">
                <label for="category">News Category</label>
                <div class="form-field">
                    <select name="category" id="category" class="form-field-select">
                        <option value="">Select</option>
                        <option value="politics">Politics</option>
                        <option value="sports">Sports</option>
                    </select>
                    <div id="categoryError" class="error-message"></div>
                </div>
            </div>

            <div class="form-item">
                <label for="archive">Archive</label>
                <div class="form-field">
                    <input type="checkbox" name="archive" id="archive">
                    <div id="archiveError" class="error-message"></div>
                </div>
            </div>

            <div class="form-item">
                <input type="submit" class="save">
            </div>
        </form>

        <?php
            $query = "SELECT * FROM articles ORDER BY articleDate DESC";
            $result = mysqli_query($dbc, $query);

            $first = true;
            while ($row = mysqli_fetch_array($result)) {
                if ($first) {
                    echo '<h2>Edit</h2>';
                    $first = false;
                }

                $selectedCategory = $row['category'];
                echo '<form enctype="multipart/form-data" action="update.php" method="POST" id="' . $row['id'] . '">';

                echo '<div class="form-item">
                        <label for="title">News Title</label>
                        <div class="form-field">
                            <input type="text" required name="title" class="form-field-textual" value="' . $row['title'] . '">
                            <div class="error-message titleError"></div>
                        </div>
                      </div>';

                echo '<div class="form-item">
                        <label for="about">Summary (up to 100 characters)</label>
                        <div class="form-field">
                            <textarea name="about" required class="form-field-textual" rows="4">' . $row['summary'] . '</textarea>
                            <div class="error-message aboutError"></div>
                        </div>
                      </div>';

                echo '<div class="form-item">
                        <label for="content">Content</label>
                        <div class="form-field">
                            <textarea name="content" required class="form-field-textual" rows="8">' . $row['articleText'] . '</textarea>
                            <div class="error-message contentError"></div>
                        </div>
                      </div>';

                echo '<div class="form-item">
                        <label for="photo">Image:</label>
                        <div class="form-field">
                        <img src="images/' . $row['imagePath'] . '" id="formImage">
                            <div class="file-upload-container">
                                <label class="custom-file-input-label" for="file-upload">Choose File</label>
                                <input type="file" id="file-upload" class="custom-file-input" name="photo"/>
                            </div>
                        </div>
                      </div>';

                echo '<div class="form-item">
                        <label for="category">News Category</label>
                        <div class="form-field">
                            <select name="category" required class="form-field-select">';
                if ($selectedCategory == 'politics') {
                    echo '<option value="politics" selected>Politics</option>
                          <option value="sports">Sports</option>';
                } else {
                    echo '<option value="politics">Politics</option>
                          <option value="sports" selected>Sports</option>';
                }
                echo '</select>
                        <div class="error-message categoryError"></div>
                        </div>
                      </div>';

                echo '<div class="form-item">
                        <label for="archive">Archive</label>
                        <div class="form-field">
                            <input type="checkbox" name="archive" id="archive" ' . ($row['archive'] == 1 ? 'checked' : '') . '>
                        </div>
                      </div>';

                echo '<div class="form-item" style="text-align: center;">
                        <input type="hidden" name="id" value="' . $row['id'] . '">
                        <input type="submit" name="update" value="Save Changes">
                        <input type="submit" name="delete" value="Delete">
                      </div>
                    </form>';
            }


            mysqli_close($dbc);
        ?>
    </main>

    <footer>
        <hr id="footerHr">
        &copy; Le Parisien by Leon Šarko
    </footer>

    <script src="validation.js"></script>
</body>
</html>
