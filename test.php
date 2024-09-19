<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Hall Modal</title>
    <link rel="stylesheet" href="/css/styles.css">
    <style>
        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-dialog {
            position: relative;
            margin: auto;
            top: 15%;
            width: 80%;
        }

        .modal-content {
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #888;
        }

        .modal-header, .modal-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-close {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Trigger/Open The Modal -->
    <button id="openModalBtn">Add Hall</button>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Hall</h5>
                    <span class="btn-close">&times;</span>
                </div>
                <div class="modal-body">
                    <form id="addHallForm" action="add_hall.php" method="post">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="hallname" name="hallname" type="text" placeholder="Enter hall name" required />
                            <label for="hallname">Hall Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="location" name="location" type="text" placeholder="Enter location" required />
                            <label for="location">Location</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="rating" name="rating" type="number" placeholder="Enter rating" required />
                            <label for="rating">Rating</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-control" id="type" name="type" required>
                                <option value="3D">3D</option>
                                <option value="2D">2D</option>
                            </select>
                            <label for="type">Type</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Hall</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("openModalBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("btn-close")[0];

        // Get the button that closes the modal
        var closeBtn = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks on the close button, close the modal
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>