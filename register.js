
/*
Služi za provjeru validnosti unesenih podataka prilikom registracije.
Ako potencijalni korisnik ne unese sve podatke ispravno, blokiramo submitanje forme i 
prikazujemo div-ove sa pogreškama.
*/

document.getElementById('registerForm').addEventListener('submit', function(event) {
    var name = document.getElementById('name').value;
    var surname = document.getElementById('surname').value;
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var repeatPassword = document.getElementById('repeat-password').value;

    var nameError = document.getElementById('nameError');
    var surnameError = document.getElementById('surnameError');
    var usernameError = document.getElementById('usernameError');
    var passwordError = document.getElementById('passwordError');
    var repeatPasswordError = document.getElementById('repeatPasswordError');

    var isValid = true;

    if (name === '') {
        nameError.style.display = 'block';
        isValid = false;
    } else {
        nameError.style.display = 'none';
    }

    if (surname === '') {
        surnameError.style.display = 'block';
        isValid = false;
    } else {
        surnameError.style.display = 'none';
    }

    if (username.length < 4 || username.length > 12) {
        usernameError.innerText = 'Username must be between 4 and 12 characters.';
        usernameError.style.display = 'block';
        isValid = false;
    } else {
        usernameError.style.display = 'none';
    }

    if (password.length < 5) {
        passwordError.innerText = 'Password must be at least 5 characters.';
        passwordError.style.display = 'block';
        isValid = false;
    } else {
        passwordError.style.display = 'none';
    }

    if (password !== repeatPassword) {
        repeatPasswordError.style.display = 'block';
        isValid = false;
    } else {
        repeatPasswordError.style.display = 'none';
    }

    if (!isValid) {
        event.preventDefault(); 
    }
});
