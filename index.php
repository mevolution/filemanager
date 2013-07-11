<?php

session_start();
include ('restServer/src/Session.class.php');
$s = new Session("./users.json");
if($_REQUEST[logout]=="true") {
    $s->logout();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!--[if lte IE 8]>
    <script src="lib/json3.min.js"></script>
    <![endif]-->


<title>Login filemanager</title>
 <!-- Bootstrap -->
   <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
   <link href="css/bootstrap-responsive.css" rel="stylesheet">
   <link href="min.css" rel="stylesheet" media="screen">


   <script src="http://code.jquery.com/jquery-latest.js"></script>
   <script src="js/bootstrap.min.js"></script>

</head>
<body>
<div style="margin-top: 100px"></div>
        <div class="row">
            <div style="text-align: center" class="span4 offset5">
                <!-- class="span4 offset6"> -->
                <div class="well">
                    <legend>Sign in to Filemanager</legend>
                    <form method="POST" action="fileManager.php" accept-charset="UTF-8">
                        <?php if($_REQUEST[errorLogin]){?>
                        <div class="alert alert-error">
                            <a class="close" data-dismiss="alert" href="#">x</a>Incorrect Username or Password!
                        </div>
                        <?php } ?>
                        <input class="span3" placeholder="Username" type="text" name="email" ng-model="email">
                        <input class="span3" placeholder="Password" type="password" name="passwd" ng-model="passwd">

                        <!--
                        <label class="checkbox">
                            <input type="checkbox" name="remember" value="1"> Remember Me
                        </label>
                        -->
                        <button id="login_button" class="btn-info btn" type="submit">Login</button>
                    </form>
                </div>
            </div>
        </div>

</body>
</html>
