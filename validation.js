
//Pomoćna metoda
function validateInput(input, minLength, maxLength) {
    const value = input.value.trim();
    const length = value.length;
    if (length < minLength || length > maxLength) {
        input.classList.add('error-border');
        input.classList.add('error-border:focus');
        input.classList.remove('success-border');
        input.classList.remove('success-border:focus');
        return false;
    } else {
        input.classList.remove('error-border');
        input.classList.remove('error-border:focus');
        input.classList.add('success-border');
        input.classList.add('success-border-focus');
        return true;
    }
}

//Pomoćna metoda
function validateSelect(select) {
    if (select.value === "") {
        select.classList.add('error-border');
        select.classList.remove('success-border');
        return false;
    } else {
        select.classList.remove('error-border');
        select.classList.add('success-border');
        return true;
    }
}

//Ovaj dio validacije se odnosni na unos nove vijesti.
//Dodajemo listener koji u slučaju kada korisnik klikne na submit button mijenja border i prikazuje greške tako što dodaje tekst praznim div-ovima.

function validateFormForNewArticle() {
    const titleInput = document.querySelector('input[name="title"]');
    const aboutTextarea = document.querySelector('textarea[name="about"]');
    const contentTextarea = document.querySelector('textarea[name="content"]');
    const photoInput = document.querySelector('input[name="photo"]');
    const categorySelect = document.querySelector('select[name="category"]');
    let isValid = true;

    if (!validateInput(titleInput, 5, 100)) {
        document.getElementById('titleError').innerText = "News title must be between 5 and 100 characters";
        isValid = false;
    } else {
        document.getElementById('titleError').innerText = "";
    }

    if (!validateInput(aboutTextarea, 10, 200)) {
        document.getElementById('aboutError').innerText = "News summary must be between 10 and 200 characters";
        isValid = false;
    } else {
        document.getElementById('aboutError').innerText = "";
    }

    if (contentTextarea.value.trim() === "") {
        document.getElementById('contentError').innerText = "News content cannot be empty";
        isValid = false;
        contentTextarea.classList.add('error-border');
        contentTextarea.classList.add('error-border:focus');
        contentTextarea.classList.remove('success-border');
        contentTextarea.classList.remove('success-border:focus');
    } else if (contentTextarea.value.length < 50 || contentTextarea.value.length > 10000) {
        document.getElementById('contentError').innerText = "News content must be between 50 and 10,000 characters long";
        isValid = false;
        contentTextarea.classList.add('error-border');
        contentTextarea.classList.add('error-border:focus');
        contentTextarea.classList.remove('success-border');
        contentTextarea.classList.remove('success-border:focus');
    } else {
        document.getElementById('contentError').innerText = "";
        contentTextarea.classList.add('success-border');
        contentTextarea.classList.add('success-border:focus');
        contentTextarea.classList.remove('error-border');
        contentTextarea.classList.remove('error-border:focus');
    }
    

    if (photoInput.value === "") {
        document.getElementById('photoError').innerText = "Image must be selected";
        isValid = false;
    } else {
        document.getElementById('photoError').innerText = "";
    }

    if (categorySelect.value === "") {
        document.getElementById('categoryError').innerText = "Category must be selected";
        isValid = false;
    } else {
        document.getElementById('categoryError').innerText = "";
    }

    return isValid;
}


//Ovdje je uključen event listener koji dinamički mijenja boju bordera prilikom inputa korisnika. 
//Ako uvjeti nisu zadovoljeni, border će biti crvene boje (dodajemo elementima klasu error-border)
//Ako su uvjeti zadovoljeni, border će biti zelene boje (dodajemo klasu success-border)


document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.querySelector('input[name="title"]');
    const aboutTextarea = document.querySelector('textarea[name="about"]');
    const contentTextarea = document.querySelector('textarea[name="content"]');
    const photoInput = document.querySelector('input[name="photo"]');
    const categorySelect = document.querySelector('select[name="category"]');
    
    titleInput.addEventListener('input', function() {
        validateInput(titleInput, 5, 100);
    });
    
    aboutTextarea.addEventListener('input', function() {
        validateInput(aboutTextarea, 10, 200);
    });
    
    contentTextarea.addEventListener('input', function() {
        if (contentTextarea.value.trim() === "") {
            contentTextarea.classList.add('error-border');
            contentTextarea.classList.add('error-border:focus'); 
            contentTextarea.classList.remove('success-border');
            contentTextarea.classList.remove('success-border:focus');
        } else if (contentTextarea.value.length < 50 || contentTextarea.value.length > 10000) {
            contentTextarea.classList.add('error-border');
            contentTextarea.classList.add('error-border:focus');
            contentTextarea.classList.remove('success-border');
            contentTextarea.classList.remove('success-border:focus');
        } else {
            contentTextarea.classList.add('success-border');
            contentTextarea.classList.add('success-border:focus');
            contentTextarea.classList.remove('error-border');
            contentTextarea.classList.remove('error-border:focus');
        }
    });
    
    
    photoInput.addEventListener('change', function() {
        if (photoInput.value === "") {
            photoInput.classList.add('error-border');
            photoInput.classList.remove('success-border');
        } else {
            photoInput.classList.remove('error-border');
            photoInput.classList.add('success-border');
        }
    });
    
    categorySelect.addEventListener('change', function() {
        validateSelect(categorySelect);
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="insert.php"]');
    form.addEventListener('submit', function(event) {
        if (!validateFormForNewArticle()) {
            event.preventDefault();
        }
    });
});




//Ovaj dio se odnosi na validaciju postojeće vijesti.
//Kod validacije postojeće vijesti nije bitan odabir slike niti odabir kategorije.
//Opet dodajemo listener koji mijenja border dinamički i validaciju u slučaju kada korisnik klikne na edit button.

function validateFormForExistingArticle(formId) {
    const form = document.getElementById(formId);
    const titleInput = form.querySelector('input[name="title"]');
    const aboutTextarea = form.querySelector('textarea[name="about"]');
    const contentTextarea = form.querySelector('textarea[name="content"]');
    const titleError = form.querySelector('.titleError');
    const aboutError = form.querySelector('.aboutError');
    const contentError = form.querySelector('.contentError');

    let isValid = true;

    if (!validateInput(titleInput, 5, 100)) {
        titleError.innerText = "News title must be between 5 and 100 characters";
        isValid = false;
    } else {
        titleError.innerText = "";
    }

    if (!validateInput(aboutTextarea, 10, 200)) {
        aboutError.innerText = "News summary must be between 10 and 100 characters";
        isValid = false;
    } else {
        aboutError.innerText = "";
    }

    if (contentTextarea.value.trim() === "") {
        document.getElementById('contentError').innerText = "News content cannot be empty";
        isValid = false;
        contentTextarea.classList.add('error-border');
        contentTextarea.classList.add('error-border:focus');
        contentTextarea.classList.remove('success-border');
        contentTextarea.classList.remove('success-border:focus');
    } else if (contentTextarea.value.length < 50 || contentTextarea.value.length > 10000) {
        document.getElementById('contentError').innerText = "News content must be between 50 and 10,000 characters long";
        isValid = false;
        contentTextarea.classList.add('error-border');
        contentTextarea.classList.add('error-border:focus');
        contentTextarea.classList.remove('success-border');
        contentTextarea.classList.remove('success-border:focus');
    } else {
        document.getElementById('contentError').innerText = "";
        contentTextarea.classList.add('success-border');
        contentTextarea.classList.add('success-border:focus');
        contentTextarea.classList.remove('error-border');
        contentTextarea.classList.remove('error-border:focus');
    }
    
    return isValid;
}

document.addEventListener('DOMContentLoaded', function() {
    const updateForms = document.querySelectorAll('form[action="update.php"]');
    
    updateForms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            const formId = form.getAttribute('id');
            if (!validateFormForExistingArticle(formId)) {
                event.preventDefault();
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form[action="update.php"]');
    
    forms.forEach(function(form) {
        const titleInput = form.querySelector('input[name="title"]');
        const aboutTextarea = form.querySelector('textarea[name="about"]');
        const contentTextarea = form.querySelector('textarea[name="content"]');
        
        titleInput.addEventListener('input', function() {
            validateInput(titleInput, 5, 100);
        });
        
        aboutTextarea.addEventListener('input', function() {
            validateInput(aboutTextarea, 10, 200);
        });
        
        contentTextarea.addEventListener('input', function() {
            if (contentTextarea.value.trim() === "") {
                contentTextarea.classList.add('error-border');
                contentTextarea.classList.add('error-border:focus'); 
                contentTextarea.classList.remove('success-border');
                contentTextarea.classList.remove('success-border:focus');
            } else if (contentTextarea.value.length < 50 || contentTextarea.value.length > 10000) {
                contentTextarea.classList.add('error-border');
                contentTextarea.classList.add('error-border:focus');
                contentTextarea.classList.remove('success-border');
                contentTextarea.classList.remove('success-border:focus');
            } else {
                contentTextarea.classList.add('success-border');
                contentTextarea.classList.add('success-border:focus');
                contentTextarea.classList.remove('error-border');
                contentTextarea.classList.remove('error-border:focus');
            }
        });
    });
});
