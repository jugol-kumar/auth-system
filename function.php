<?php

include('config.php');


if(isset($_POST['signUpButton']))
{


    if (empty($_POST["password"])) {
        $_SESSION['error'] = "This Password Field Is Required...";
    }else{
        $password = md5($_POST['password']);
    }

    if (empty($_POST["email"])) {
        $_SESSION['error'] = "This Email Field Is Required...";
    }else{
        $vEmail = $_POST['email'];
        if (filter_var($vEmail, FILTER_VALIDATE_EMAIL)) {
            $email = $vEmail;
        }else{
            $_SESSION['error'] = "This Email Is Not Valid. Please Enter Valid Email Address...";
        }
    }
    if (empty($_POST["name"])) {
        $_SESSION['error'] = "This Name Field Is Required...";
    }else{
        $first_name = $_POST['name'];
    }


    if (isset($_SESSION['image'])){
        $photo = $_SESSION['image'];
    }else{
        $photo = 'https://pic.onlinewebfonts.com/svg/img_148071.png';
    }

    if (!isset($_SESSION['error'])){
        $sql = "INSERT INTO user(name,email,password,photo) VALUES ('$first_name', '$email', '$password', '$photo')";
        if (mysqli_query($link, $sql)){
            $_SESSION['user_first_name'] = $first_name;
            $_SESSION['user_email_address'] = $email;
            $_SESSION['user_image'] = $photo;
            $_SESSION['success'] = "Welcome $first_name . Your Registration Is Successfully Done...:)";
            header('Location:index.php');
        }else{
            die('have and error'.mysqli_error($link));
        }
    }else{
        header('Location:registraiton.php');
    }



}

if(isset($_POST['signInButton']))
{
    if (empty($_POST["password"])) {
        $_SESSION['error'] = "This Password Field Is Required...";
    }else{
        $password = md5($_POST['password']);
    }

    if (empty($_POST["email"])) {
        $_SESSION['error'] = "This Email Field Is Required...";
    }else{
        $vEmail = $_POST['email'];
        if (filter_var($vEmail, FILTER_VALIDATE_EMAIL)) {
            $email = $vEmail;
        }else{
            $_SESSION['error'] = "This Email Is Not Valid. Please Enter Valid Email Address...";
        }
    }
    if (!isset($_SESSION['error'])){
        $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
        if (mysqli_query($link, $sql)){
            $sqlResult = mysqli_query($link, $sql);
            $res = mysqli_fetch_assoc($sqlResult);
            if ($res){
                $_SESSION['user_first_name'] = $res['name'];
                $_SESSION['user_email_address'] = $res['email'];
                $_SESSION['user_image'] = $res['photo'];
                $_SESSION['success'] = "Welcome $_SESSION[user_first_name] . Your Registration Is Successfully Done...:)";
                header('Location:index.php');
            }else{
                $_SESSION['error'] = "Your User Name Or password Invalid. Please Try Again...";
                header('Location:registraiton.php');
            }
        }else{
            die('have and error'.mysqli_error($link));
        }
    }else{
        header('Location:registraiton.php');
    }

}
?>
