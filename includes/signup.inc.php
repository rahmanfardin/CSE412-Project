<?php

function usernameEsists($username, $conn){
    $existsSql = "SELECT * FROM `usertable` WHERE `username` = '$username'; ";
    $result = mysqli_query($conn, $existsSql);
    $numOfUsers = mysqli_num_rows($result);
    if ($numOfUsers == 0) return false;
    else return true;
}
function emailExists($email, $conn){
    $existsSql = "SELECT * FROM `usertable` WHERE `email` = '$email'; ";
    $result = mysqli_query($conn, $existsSql);
    $numOfUsers = mysqli_num_rows($result);
    if ($numOfUsers == 0) return false;
    else return true;
}

function passwordCheck($password, $cpassword){
    if($password == $cpassword) return true;
    else return false;
}
