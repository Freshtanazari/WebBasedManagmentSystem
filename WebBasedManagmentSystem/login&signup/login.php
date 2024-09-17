<?php

if (isset($_POST['login-btn'])){
    require'dbconnection.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username)|| empty($password)){
        header("Location: ./login.html?error=emptyFields");
        exit();
    }else {
        $sql = "SELECT * FROM users WHERE username=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ./login.html?error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt,"s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                $passwordcheck = password_verify($password, $row['userPwd']);
                if($passwordcheck == false){
                    header("Location: login.html?error=wrongpassword");
                    exit();
                }else if($passwordcheck == true){
                    session_start();
                    $_SESSION['userName'] = $row['username'];
                    $_SESSION['id'] =  $row['ID'];
                    header("Location: ..\main\mainPage.php?login=success");
                    exit();
                }
            }else {
                header("Location: ./login.html?error=nouser");
                exit();
            }


        }

    }

}else{
    header("Location: ./index.html");
    exit();
}
$db_username;
$db_password;


?>