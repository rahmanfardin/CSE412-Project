/*!
* Start Bootstrap - Creative v7.0.7 (https://startbootstrap.com/theme/creative)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-creative/blob/master/LICENSE)
*/
//
// Scripts
//

// Resumission Form Issue Fix
if(window.history.replaceState){
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




// Get the hall modals
var addHallModal = document.getElementById("addHallModal");
var editHallModal = document.getElementById("editHallModal");
var deleteHallModal = document.getElementById("deleteHallModal");

// Get the buttons that open the modals
var openAddModalBtn = document.getElementById("openAddModalBtn");
var editHallBtns = document.getElementsByClassName("editHallBtn");
var deleteHallBtns = document.getElementsByClassName("deleteHallBtn");

// Get the <span> elements that close the modals
var closeButtons = document.getElementsByClassName("close");

// When the user clicks the button, open the Add Hall modal
openAddModalBtn.onclick = function () {
    addHallModal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
for (var i = 0; i < closeButtons.length; i++) {
    closeButtons[i].onclick = function () {
        addHallModal.style.display = "none";
        editHallModal.style.display = "none";
        deleteHallModal.style.display = "none";
    }
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == addHallModal) {
        addHallModal.style.display = "none";
    }
    if (event.target == editHallModal) {
        editHallModal.style.display = "none";
    }
    if (event.target == deleteHallModal) {
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
        document.getElementById("editHallname").value = hallname;
        document.getElementById("editLocation").value = location;
        document.getElementById("editRating").value = rating;
        document.getElementById("editType").value = type;

        editHallModal.style.display = "block";
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