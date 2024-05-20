# LeParisien - Projektni zadatak iz kolegija Programiranje web aplikacija

A web application built with HTML, CSS, PHP, and JavaScript.

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

### Homepage
<img src="https://raw.githubusercontent.com/N0ksa/LeParisien/main/assets/118447696/51637f9a-5070-4a93-9ce7-ac870c6397b8.png" width="400">

### Article Page
<img src="https://raw.githubusercontent.com/N0ksa/LeParisien/main/assets/118447696/c218b880-c64b-4361-8096-f4f5537fdfd3.png" width="400">

## Short 60-second Demo
<img src="https://raw.githubusercontent.com/N0ksa/LeParisien/main/assets/118447696/3b0c005f-b146-4095-acbc-1fa858e04222.gif" width="400">
