# LeParisien - projektni zadatak iz kolegija Programiranje web aplikacija

A responsive CRUD (Create, Read, Update, Delete) web application built with HTML, CSS, PHP, and JavaScript.

## Installation

1. Clone the repository.
2. Move the project files to the XAMPP `htdocs` directory. Typically, the `htdocs` directory is located at `C:\xampp\htdocs\` on Windows.
3. Import the database:
   - Navigate to the `data_base_export` folder in the cloned repository.
   - Locate the database dump file (e.g., `le_parisien.sql`).
   - Open phpMyAdmin or your preferred MySQL management tool.
   - Create a new database for your project named `le_parisien`. It needs to be named exactly like this because the `connect.php` is configured to connect to `le_parisien`.
   - Select the newly created database and import the database dump file (`le_parisien.sql`).

## Usage

1. Start the Apache and MySQL servers in XAMPP.
2. Open your web browser and navigate to `http://localhost/LeParisien/`.
3. You should now be able to access and interact with the web application.

**Note**: If you choose to use a different database name, username, or password, or if your MySQL server is hosted on a different host than `localhost`, make sure to update the corresponding values in the `connect.php` file accordingly.

## Screenshots on how the project should look like (provided by professor):


Homepage             |  Article Page
:-------------------------:|:-------------------------:
![Homepage](https://github.com/N0ksa/LeParisien/assets/118447696/89adb557-283a-4bdb-9898-beb46186b15e)  |  ![Article Page](https://github.com/N0ksa/LeParisien/assets/118447696/a89ba1ed-7895-495a-ab60-a1fb0890ad23)


## Short 60-second Demo on Desktop
<img src="https://github.com/N0ksa/LeParisien/assets/118447696/1ff74b9b-efe3-4242-a299-0655eda5c745" alt="Short Demo" width="600">


## Short 40-second Demo on Mobile
<img src="https://github.com/N0ksa/LeParisien/assets/118447696/067d40ce-1a4c-4bd0-8735-31c84d31b3ad" alt="Short Demo on Mobile" height="500">


## Longer Demo
[Watch on YouTube](https://youtu.be/0Wp3Llqe_dI)


## Additional information
To log in as an admin and access administrative functionalities, please use the following credentials:
- **Username:** admin
- **Password:** admin

For any questions or feedback, feel free to reach out to me.

