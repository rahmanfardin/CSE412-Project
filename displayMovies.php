<?php
include './includes/dbcon.php';

$sql = "SELECT movieid, moviename, poster FROM movietable";
$result = $conn->query($sql);

if ($result === FALSE) {
    die("Error: " . $conn->error);
}
?>

<!-- Header -->
<?php include 'includes/header.php'; ?>

<div class="scroll-pane-container">
    <div class="scroll-pane">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="movie-poster" data-movie="' . htmlspecialchars($row["moviename"]) . '">';
                echo '<img src="'.'admin/uploads/posters/' . htmlspecialchars($row["poster"]) . '" alt="' . htmlspecialchars($row["moviename"]) . '">';
                echo '</div>';
            }
        } else {
            echo "No results found.";
        }
        $conn->close();
        ?>
    </div>
</div>

<div id="popup" class="popup">
    <span class="close">&times;</span>
    <div class="popup-content">
        <!-- Movie details will be loaded here -->
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const posters = document.querySelectorAll('.movie-poster');
        const popup = document.getElementById('popup');
        const closeBtn = document.querySelector('.popup .close');
        const popupContent = document.querySelector('.popup-content');

        posters.forEach(poster => {
            poster.addEventListener('click', function() {
                const movie = this.getAttribute('data-movie');
                popupContent.innerHTML = `<h2>${movie}</h2><p>Details about ${movie}...</p>`;
                popup.style.display = 'block';
            });
        });

        closeBtn.addEventListener('click', function() {
            popup.style.display = 'none';
        });

        window.addEventListener('click', function(event) {
            if (event.target == popup) {
                popup.style.display = 'none';
            }
        });
    });
</script>

<!-- Footer -->
<?php include 'includes/footer.php'; ?>