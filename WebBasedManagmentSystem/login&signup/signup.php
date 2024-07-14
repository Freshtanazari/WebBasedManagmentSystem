<?php

if(isset($_POST['signup-btn'])){ // checks if the user clicked the signup button or not
    require 'dbconnection.php';

    $fullName = $_POST['fullName'];
    $emailAddress = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conPassword = $_POST['confirmPassword'];
   

    if(empty($fullName) || empty($password) || empty($conPassword) || empty($emailAddress) || empty($username)){
        header('Location: signup.html?error=emptyfields&username='.$username.'&email='.$emailAddress);
        exit();
    }
    else if(!filter_var($emailAddress,FILTER_VALIDATE_EMAIL)){ // the function filter_var checks a variable against a validation defined in php
        header('Location: signup.html?error=invalidemail&username='.$username);
        exit();
    }
    else if(!preg_match("/^[a-zA-Z0-9]*$/",$username)){ // the preg_match checks a variable against a regular expression
        header('Location: signup.html?error=invalidusername&email='.$emailAddress);
        exit();
    }
    else if(!preg_match("/^[a-zA-Z0-9]*$/",$username) && !filter_var($emailAddress,FILTER_VALIDATE_EMAIL)){ // checks if both of the condition is violated
        header('Location: signup.html?error=invalidusernamemail');
        exit();
    }
    else if ($password != $conPassword){ // checks if the pwd matches
        header('Location: signup.html?error=pwdmismatch&email='.$emailAddress);
        exit();
    }
    else {
        //checks if the username is taken
        $sql = "SELECT username FROM users WHERE username=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header('Location: signup.html?error=sqlerror');
        exit(); 
        }else{
            
            mysqli_stmt_bind_param($stmt, "s", $username); // bind the ? with the value of variable username
            mysqli_stmt_execute($stmt); // execute the statement
            mysqli_stmt_store_result($stmt); // get the result of the sql execution
            $result = mysqli_stmt_num_rows($stmt); // store the number of rows from the result into this var
            if($result >0){ // if there is another username the same is provided 
                header('Location: signup.html?error=usernametaken&email='.$emailAddress);
                exit(); 
            } 
            else{
                $sql = "INSERT INTO users (fname ,emailAddress , username, userPwd) VALUES (?, ?, ?, ?);";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header('Location: signup.html?error=sqlerror');
                exit();
                }
                else {
                    $hasedPwd = password_hash($password, PASSWORD_DEFAULT); // use the default algorithm for hashing the password

                    mysqli_stmt_bind_param($stmt, "ssss", $fullName, $emailAddress, $username, $hasedPwd); // bind the ? with the value of variables
                    mysqli_stmt_execute($stmt); // execute the statement
                    header('Location: login.html?signup=success'); // signup completed
                    exit(); 
                }// end if

            } 
        }
        
    }
    mysqli_stmt_close($stmt); // close the statement
    mysqli_close($conn); // close the connection

}

else{
    header('Location: signup.html'); 
    exit();  
}

?>