<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modal Example</title>
        <link rel="stylesheet" href="/css/styles.css">
    </head>
    <body>
        <!-- Trigger/Open The Modal -->
        <button id="openModalBtn">Open Modal</button>
    
        <!-- The Modal -->
        <div id="myModal" class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal Header</h5>
                        <span class="btn-close">&times;</span>
                    </div>
                    <div class="modal-body">
                        <p>This is a simple modal example.</p>
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
            var span = document.getElementsByClassName("close")[0];
    
            // When the user clicks the button, open the modal 
            btn.onclick = function() {
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
        </script>
</body>
</html>