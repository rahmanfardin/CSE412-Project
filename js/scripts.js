/*!
* Start Bootstrap - Creative v7.0.7 (https://startbootstrap.com/theme/creative)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-creative/blob/master/LICENSE)
*/
//
// Scripts
//

// Resumission Form Issue Fix
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
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
    new SimpleLightbox({
        elements: '#movie a.movie-box'
    });

});


// Function to close modals when clicking outside of them
window.onclick = function (event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = "none";
    }
}


// Get the hall modals
var addHallModal = document.getElementById("addHallModal");
var deleteHallModal = document.getElementById("deleteHallModal");

// Get the buttons that open the modals
var AddHallBtn = document.getElementById("AddHallBtn");
var editHallBtns = document.getElementsByClassName("editHallBtn");
var deleteHallBtns = document.getElementsByClassName("deleteHallBtn");

// Get the <span> elements that close the modals
var closeButtons = document.getElementsByClassName("close");

// When the user clicks the button, open the Add Hall modal
if (AddHallBtn != null) {
    AddHallBtn.onclick = function () {
        addHallModal.style.display = "block";
        document.getElementById("modalTitle").innerText = "Add Hall";
        document.getElementById("addEditHallForm").reset();
        document.getElementById("submitButton").innerText = "Submit";
    }
}

// When the user clicks on <span> (x), close the modal
for (var i = 0; i < closeButtons.length; i++) {
    closeButtons[i].onclick = function () {
        addHallModal.style.display = "none";
        deleteHallModal.style.display = "none";
    }
}


// When the user clicks the Edit button, open the Edit Hall modal and populate the form
for (var i = 0; i < editHallBtns.length; i++) {
    editHallBtns[i].onclick = function () {
        var hallId = this.getAttribute("hallid");
        var hallname = this.getAttribute("hallname");
        var location = this.getAttribute("location");
        var rating = this.getAttribute("rating");
        var type = this.getAttribute("type");

        document.getElementById("hallId").value = hallId;
        document.getElementById("hallname").value = hallname;
        document.getElementById("location").value = location;
        document.getElementById("rating").value = rating;
        document.getElementById("type").value = type;

        addHallModal.style.display = "block";
        document.getElementById("modalTitle").innerText = "Edit Hall";
        document.getElementById("submitButton").innerText = "Update";
        document.getElementById("submitButton").classList.add("btn-success");
    }
}

// When the user clicks the Delete button, delete the hall
for (var i = 0; i < deleteHallBtns.length; i++) {
    deleteHallBtns[i].onclick = function () {
        var hallId = this.getAttribute("hallid");

        document.getElementById("deleteId").value = hallId;
        deleteHallModal.style.display = "block";
    }
}


// Get the movie modals
var addEditMovieModal = document.getElementById("addEditMovieModal");
var deleteMovieModal = document.getElementById("deleteMovieModal");

// Get the buttons that open the modals
var addMovieBtn = document.getElementById("addMovieBtn");
var editMovieBtns = document.getElementsByClassName("editMovieBtn");
var deleteMovieBtns = document.getElementsByClassName("deleteMovieBtn");

// Get the <span> elements that close the modals
var closeButtons = document.getElementsByClassName("close");

// When the user clicks the button, open the Add Movie modal
if (addMovieBtn != null) {
    addMovieBtn.onclick = function () {
        document.getElementById("modalTitle").innerText = "Add Movie";
        document.getElementById("addEditMovieForm").reset();
        document.getElementById("submitButton").innerText = "Submit";
        document.getElementById("posterLabel").innerText = "Choose Poster";
        document.getElementById("currentPoster").style.display = "none";
        addEditMovieModal.style.display = "block";
    }
}

// When the user clicks on <span> (x), close the modal
for (var i = 0; i < closeButtons.length; i++) {
    closeButtons[i].onclick = function () {
        addEditMovieModal.style.display = "none";
        deleteMovieModal.style.display = "none";
    }
}

// When the user clicks the Edit button, open the Edit Movie modal and populate the form
for (var i = 0; i < editMovieBtns.length; i++) {
    editMovieBtns[i].onclick = function () {
        var movieId = this.getAttribute("movieid");
        var moviename = this.getAttribute("moviename");
        var releasedate = this.getAttribute("releasedate");
        var genre = this.getAttribute("genre");
        var rating = this.getAttribute("rating");
        var movierating = this.getAttribute("movierating");
        var poster = this.getAttribute("poster");

        document.getElementById("movieid").value = movieId;
        console.log(movieId);
        document.getElementById("moviename").value = moviename;
        document.getElementById("releasedate").value = releasedate;
        document.getElementById("genre").value = genre;
        document.getElementById("rating").value = rating;
        document.getElementById("movierating").value = movierating;
        // Poster handling
        document.getElementById("posterLabel").innerText = "Current Poster";
        var currentPoster = document.getElementById("currentPoster");
        currentPoster.src = poster;
        currentPoster.style.display = "block"; // Show the current poster

        document.getElementById("modalTitle").innerText = "Edit Movie";
        document.getElementById("submitButton").innerText = "Update";
        document.getElementById("submitButton").classList.add("btn-success");
        addEditMovieModal.style.display = "block";
    }
}

// When the user clicks the Delete button, open the Delete Movie modal and set the movie ID
for (var i = 0; i < deleteMovieBtns.length; i++) {
    deleteMovieBtns[i].onclick = function () {
        var movieId = this.getAttribute("movieid");
        console.log(movieId);
        document.getElementById("movieDeleteId").value = movieId;
        deleteMovieModal.style.display = "block";
    }
}



// Get the custom alert
var customAlert = document.getElementById("customAlert");

// Get the close button inside the custom alert
var customAlertClose = customAlert.querySelector(".btn-close");

// Function to show the custom alert with a message
function showCustomAlert(message) {
    document.getElementById("customAlertMessage").innerText = message;
    customAlert.style.display = "block";
    customAlert.style.position = "fixed";
    customAlert.style.top = "50%";
    customAlert.style.left = "50%";
    customAlert.style.transform = "translate(-50%, -50%)";
}

// When the user clicks on the close button, hide the custom alert
customAlertClose.onclick = function () {
    customAlert.style.display = "none";
}

// Optionally, hide the alert after a few seconds
function hideCustomAlertAfterTimeout(timeout) {
    setTimeout(function () {
        customAlert.style.display = "none";
    }, timeout);
}

// Profile Script
document.getElementById('profile').addEventListener('click', function (event) {
    event.preventDefault();
    var proDiv = document.getElementById('profileDiv');
    var homeDiv = document.getElementById('home');
    if (proDiv.style.display === 'none') {
        proDiv.style.display = 'flex';
        homeDiv.style.display = 'none';
    } else {
        proDiv.style.display = 'none';
    }
});