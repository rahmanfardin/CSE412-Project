<?php include 'nav.php' ?>
<h1>
    <?php
    echo "hello<br>";
    echo phpversion();
    echo "<br>hello";
    ?>
</h1>

<?php
include 'dbcon.php';

$sql = 'select * from test';

$result = mysqli_query($conn, $sql);


?>
<div class="container col-6 mx-auto card p-3 shadow-lg">
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td>' . $row['age'] . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>

    </table>
</div>