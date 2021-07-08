<?php


//Include Configuration File
include('config.php');

if (isset($_SESSION['user_first_name'])){
    header('Location:index.php');
}

$login_button = '';


if(isset($_GET["code"]))
{

    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);


    if(!isset($token['error']))
    {
        $google_client->setAccessToken($token['access_token']);

        $_SESSION['access_token'] = $token['access_token'];

        $google_service = new Google_Service_Oauth2($google_client);


        $data = $google_service->userinfo->get();


        if(!empty($data['given_name']))
        {
            $_SESSION['user_first_name'] = $data['given_name'];
        }

        if(!empty($data['family_name']))
        {
            $_SESSION['user_last_name'] = $data['family_name'];
        }

        if(!empty($data['email']))
        {
            $_SESSION['user_email_address'] = $data['email'];
        }

        if(!empty($data['gender']))
        {
            $_SESSION['user_gender'] = $data['gender'];
        }

        if(!empty($data['picture']))
        {
            $_SESSION['user_image'] = $data['picture'];
        }
    }
}


if(!isset($_SESSION['access_token']))
{
    $login_button = $google_client->createAuthUrl();
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="style.css">
    <style>
        .error{
            padding: 5px 11px;
            background: #ffa5a5;
            margin-bottom: 15px;
        }
        .success{
            padding: 5px 11px;
            background: #b6ffa5;
            margin-bottom: 15px;
        }
        .success strong{
            margin-right: 7px;
        }
        .error strong{
            margin-right: 7px;
        }
    </style>
</head>
<body>
<?php if (isset($_SESSION['error'])){?>
    <div class="error">
        <span>
            <?php
                echo  "<strong>Error!</strong>".$_SESSION['error'];
                unset($_SESSION['error']);
          ?>
          </span>
    </div>
<?php } ?>
<!--<h2>Weekly Coding Challenge #1: Sign in/up Form</h2>-->


<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form action="function.php" method="POST">
            <h1>Create Account</h1>
            <div class="social-container">
<!--                <a href="" class="social"><i class="fab fa-facebook-f"></i></a>-->
                <a href="<?php echo $login_button ?>" class="social"><i class="fab fa-google"></i></a>
            </div>
            <span>or use your email for registration</span>
            <input type="text" name="name" placeholder="Name" />
            <input type="email" name="email" placeholder="Email" />
            <input type="password" name="password" placeholder="Password" />
            <input type="submit" name="signUpButton" value="Signup">
        </form>
    </div>


    <div class="form-container sign-in-container">
        <form method="post" action="function.php">
            <h1>Sign in</h1>
            <div class="social-container">
<!--                <a href="" class="social"><i class="fab fa-facebook-f"></i></a>-->
                <a href="<?php echo $login_button ?>" class="social"><i class="fab fa-google"></i></a>
            </div>
            <span>or use your account</span>
            <input type="email" name="email" placeholder="Email" />
            <input type="password" name="password" placeholder="Password" />
            <a href="#">Forgot your password?</a>
            <input type="submit" name="signInButton" value="submit">
        </form>
    </div>


    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Welcome Back!</h1>
                <p>To keep connected with us please login with your personal info</p>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hello, Friend!</h1>
                <p>Enter your personal details and start journey with us</p>
                <button class="ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>
<footer>
    <p>
        Created with <i class="fa fa-heart"></i> by
        <a target="_blank" href="https://florin-pop.com">Florin Pop</a>
        - Read how I created this and how you can join the challenge
        <a target="_blank" href="https://www.florin-pop.com/blog/2019/03/double-slider-sign-in-up-form/">here</a>.
    </p>
</footer>
<script src="script.js"></script>
</body>
</html>
