<?php
session_start();


if (isset($_SESSION['username'])) {
    echo 'hello '. $_SESSION['username'];
}
?>