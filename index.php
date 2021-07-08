<!-- Your Client ID: 673935677678-um3vd58m78hefj2f9bemrk8u6shi2svg.apps.googleusercontent.com-->
<!--Your Client Secret: ExKHezlcHNy-k7kEl2LZw6KN-->

<?php
//Include Configuration File
include('config.php');


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
            $_SESSION['success'] = "Welcome $_SESSION[user_first_name] $_SESSION[user_last_name]. Your Registration Is Successfully Done...:)";

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
    $login_button = '<a href="'.$google_client->createAuthUrl().'">Login With Google</a>';
}


?>


<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PHP Login using Google Account</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <style>
        .success{
            padding: 5px 11px;
            background: #b6ffa5;
            margin-bottom: 15px;
        }
        .success strong{
            margin-right: 7px;
        }
        .panel-body img{
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <br />
    <h2 align="center">PHP Login using Google Account</h2>
    <br />

    <?php if (isset($_SESSION['success'])){?>
        <div class="success">
        <span>
            <?php
            echo  "<strong>Success!</strong>".$_SESSION['success'];
            unset($_SESSION['success']);
            ?>
          </span>
        </div>
    <?php }?>


    <div class="panel panel-default">
        <?php
            if($login_button == '')
            {
                echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
                echo '<img src="'.$_SESSION["user_image"].'" class="img-responsive img-circle img-thumbnail" />';
                echo '<h3><b>Name :</b> '.$_SESSION['user_first_name'].' '.$_SESSION['user_last_name'].'</h3>';
                echo '<h3><b>Email :</b> '.$_SESSION['user_email_address'].'</h3>';
                echo '<h3><a href="logout.php">Logout</h3></div>';
            }elseif (isset($_SESSION['user_first_name'])){
                echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
                echo '<img src="'.$_SESSION["user_image"].'" class="img-responsive img-circle img-thumbnail"/>';
                echo '<h3><b>Name :</b> '.$_SESSION['user_first_name'].' '.isset($_SESSION['user_last_name']).'</h3>';
                echo '<h3><b>Email :</b> '.$_SESSION['user_email_address'].'</h3>';
                echo '<h3><a href="logout.php">Logout</h3></div>';
            }
            else
            {
                header('Location:registraiton.php');
//                echo '<div align="center">'.$login_button . '</div>';
            }
        ?>
    </div>
</div>
</body>
</html>
