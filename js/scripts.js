//
// Scripts
//

// Resumission Form Issue Fix
// if (window.history.replaceState) {
//     window.history.replaceState(null, null, window.location.href);
// }

// Function to show the password
function togglePasswordVisibility(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const toggleIcon = document.getElementById(iconId);
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('bi-eye-slash-fill');
        toggleIcon.classList.add('bi-eye-fill');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('bi-eye-fill');
        toggleIcon.classList.add('bi-eye-slash-fill');
    }
}

window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }

        if (!window.location.pathname.includes('index.php') && window.scrollY === 0) {
            navbarCollapsible.classList.add('navbar-shrink');
        }
        else if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink')
        }
        else {
            navbarCollapsible.classList.add('navbar-shrink')
        }

    };

    // Shrink the navbar 
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    // Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

    // Activate SimpleLightbox plugin for portfolio items
    // new SimpleLightbox({
    //     elements: '#movie a.movie-box'
    // });

});


// Function to close modals when clicking outside of them
window.onclick = function (event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = "none";
    }
}


// Utility function to get elements by class name
function getElements(className) {
    return document.getElementsByClassName(className);
}

// Utility function to set modal display
function setModalDisplay(modal, display) {
    if (modal) {
        modal.style.display = display;
    }
}

// Utility function to handle modal close
function handleModalClose(modals) {
    for (let i = 0; i < modals.length; i++) {
        setModalDisplay(modals[i], "none");
    }
}

// Utility function to handle form reset and modal open
function handleModalOpen(modal, title, submitText) {
    document.getElementById("modalTitle").innerText = title;
    document.getElementById("submitButton").innerText = submitText;
    setModalDisplay(modal, "block");
}

// Utility function to populate form fields
function populateFormFields(fields) {
    for (let key in fields) {
        if (fields.hasOwnProperty(key)) {
            const field = document.getElementById(key);
            if (field) {
                field.value = fields[key];
            } else {
                console.warn(`Field with ID ${key} not found.`);
            }
        }
    }
}

// Get the modals
const modals = {
    addHallModal: document.getElementById("addHallModal"),
    deleteHallModal: document.getElementById("deleteHallModal"),
    addEditMovieModal: document.getElementById("addEditMovieModal"),
    deleteMovieModal: document.getElementById("deleteMovieModal"),
    addEditSlotModal: document.getElementById("addEditSlotModal"),
    deleteSlotModal: document.getElementById("deleteSlotModal")
};

// Get the buttons that open the modals
const buttons = {
    addHallBtn: document.getElementById("AddHallBtn"),
    addMovieBtn: document.getElementById("addMovieBtn"),
    addSlotBtn: document.getElementById("addSlotBtn")
};

// Handle Add Hall button click
if (buttons.addHallBtn) {
    buttons.addHallBtn.onclick = () => handleModalOpen(modals.addHallModal, "Add Hall", "Submit");
    document.getElementById("addEditHallForm").reset();
}

// Handle Add Movie button click
if (buttons.addMovieBtn) {
    buttons.addMovieBtn.onclick = () => {
        handleModalOpen(modals.addEditMovieModal, "Add Movie", "Submit");
        document.getElementById("addEditMovieForm").reset();
        document.getElementById("posterLabel").innerText = "Choose Poster";
        document.getElementById("currentPoster").style.display = "none";
    };
}

// Handle Add Slot button click
if (buttons.addSlotBtn) {
    buttons.addSlotBtn.onclick = () => handleModalOpen(modals.addEditSlotModal, "Add Slot", "Submit");
    document.getElementById("addEditSlotForm").reset();
}

// Handle Edit Hall button click
Array.from(getElements("editHallBtn")).forEach(btn => {
    btn.onclick = function () {
        const fields = {
            hallId: this.getAttribute("hallId"),
            hallname: this.getAttribute("hallname"),
            location: this.getAttribute("location"),
            rating: this.getAttribute("rating"),
            type: this.getAttribute("type")
        };
        console.log(fields);
        populateFormFields(fields)
        handleModalOpen(modals.addHallModal, "Edit Hall", "Update");
        document.getElementById("submitButton").classList.add("btn-success");
    };
});

// Handle Edit Movie button click
Array.from(getElements("editMovieBtn")).forEach(btn => {
    btn.onclick = function () {
        const fields = {
            movieid: this.getAttribute("movieid"),
            moviename: this.getAttribute("moviename"),
            releasedate: this.getAttribute("releasedate"),
            genre: this.getAttribute("genre"),
            rating: this.getAttribute("rating"),
            movierating: this.getAttribute("movierating")
        };
        populateFormFields(fields);
        document.getElementById("posterLabel").innerText = "Current Poster";
        const currentPoster = document.getElementById("currentPoster");
        const basePath = './uploads/posters/';
        const posterPath = this.getAttribute("poster");
        currentPoster.src = basePath + posterPath;
        currentPoster.style.display = "block";
        handleModalOpen(modals.addEditMovieModal, "Edit Movie", "Update");
        document.getElementById("submitButton").classList.add("btn-success");
    };
});

// Handle Edit Slot button click
Array.from(getElements("editSlotBtn")).forEach(btn => {
    btn.onclick = function () {
        const fields = {
            slotid: this.getAttribute("slotid"),
            movieid: this.getAttribute("movieid"),
            hallid: this.getAttribute("hallid"),
            date: this.getAttribute("date"),
            slot: this.getAttribute("slot")
        };
        populateFormFields(fields);
        handleModalOpen(modals.addEditSlotModal, "Edit Slot", "Update");
        document.getElementById("submitButton").classList.add("btn-success");
    };
});

// Handle Delete Hall button click
Array.from(getElements("deleteHallBtn")).forEach(btn => {
    btn.onclick = function () {
        document.getElementById("deleteId").value = this.getAttribute("hallid");
        setModalDisplay(modals.deleteHallModal, "block");
    };
});

// Handle Delete Movie button click
Array.from(getElements("deleteMovieBtn")).forEach(btn => {
    btn.onclick = function () {
        document.getElementById("movieDeleteId").value = this.getAttribute("movieid");
        setModalDisplay(modals.deleteMovieModal, "block");
    };
});

// Handle Delete Slot button click
Array.from(getElements("deleteSlotBtn")).forEach(btn => {
    btn.onclick = function () {
        document.getElementById("deleteSlotId").value = this.getAttribute("slotid");
        setModalDisplay(modals.deleteSlotModal, "block");
    };
});

// Handle modal close on clicking close button
Array.from(getElements("close")).forEach(btn => {
    btn.onclick = () => handleModalClose(Object.values(modals));
});

// Get the custom alert
var customAlert = document.getElementById("customAlert");

// Get the close button inside the custom alert
if (customAlert) {
    var customAlertClose = customAlert.querySelector(".btn-close");
    if (customAlertClose) {
        customAlertClose.addEventListener("click", function () {
            customAlert.style.display = "none";
        });
    }
}

// Function to show the custom alert with a message
function showCustomAlert(message) {
    document.getElementById("customAlertMessage").innerText = message;
    customAlert.style.display = "block";
    customAlert.style.position = "fixed";
    customAlert.style.top = "50%";
    customAlert.style.left = "50%";
    customAlert.style.transform = "translate(-50%, -50%)";
}

// Optionally, hide the alert after a few seconds
function hideCustomAlertAfterTimeout(timeout) {
    setTimeout(function () {
        customAlert.style.display = "none";
    }, timeout);
}


// !for profile popup
// Get the modal
var modal = document.getElementById("profileModal");

// Get the button that opens the modal
var btn = document.getElementById("profileBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal and position it to the right of the button
btn.onclick = function() {
    var rect = btn.getBoundingClientRect();
    modal.style.top = rect.bottom + "px";
    modal.style.left = (rect.right - modal.offsetWidth) + "px";
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}