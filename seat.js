// Select all the required DOM elements
const container = document.getElementById("seat");
const seats = document.querySelectorAll(".row .seat:not(.occupied)");
let count = document.getElementById("count");
let selectedSeatsArray = [];

// Update seat count
function updateSelectedCount() {
  const selectedSeats = document.querySelectorAll(".row .seat.selected");
  const selectedSeatsCount = selectedSeats.length;

  count.innerText = selectedSeatsCount;

  selectedSeatsArray = Array.from(selectedSeats).map(seat => seat.getAttribute('seatNumber'));

  // Log the selected seats array for debugging
  console.log(selectedSeatsArray);

  // saveSelectedSeats();
}

// Seat click event
container.addEventListener("click", (e) => {
  if (e.target.classList.contains("seat") && !e.target.classList.contains("occupied")) {
    e.target.classList.toggle("selected");

    updateSelectedCount();
  }
});

// Initial count and total set
updateSelectedCount();


// Select movie
document.addEventListener("DOMContentLoaded", function () {
  const movieSelect = document.getElementById("movieid");
  movieSelect.addEventListener("change", function () {
    this.form.submit();
  });
});

// Select hall
const hallSelect = document.getElementById("hallid");
hallSelect.addEventListener("change", function () {
  this.form.submit();
});