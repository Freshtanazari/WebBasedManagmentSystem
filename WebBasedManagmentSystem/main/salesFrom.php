<?php

if(isset($_POST['PD-entry'])){ // if the button is clicked
    require '..\login&signup\dbconnection.php';

    $productName = $_POST['productName'];
    $date = $_POST['date'];
    $username = $_POST['seller'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    if (empty($productName) || empty($date) || empty($price) || empty($username)){
        header('Location: mainPage.php?error=emptyfields&price='.$price.'&productName='.$productName);
        exit();
    }
    $sql = 'INSERT INTO sales ( productName, saleDate, price, username, productDescription) VALUES (?, ?, ?, ?, ?);';
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header('Location: mainPage.php?error=sqlerror');
        exit();
    }else{

    mysqli_stmt_bind_param($stmt, "sssss", $productName, $date, $price, $username, $description);
    mysqli_stmt_execute($stmt); // execute the statement
    header('Location: mainPage.php?pd-entry=success'); // signup completed
    exit(); 
    }

}




?>