<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>bootstrap</title>
 <!-- Bootstrap -->
   <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
   <link href="css/bootstrap-responsive.css" rel="stylesheet">
   <link href="min.css" rel="stylesheet" media="screen">


   <script src="http://code.jquery.com/jquery-latest.js"></script>
   <script src="js/bootstrap.min.js"></script>

</head>
<body>

<div class="row">
    <div class="span4 offset4">
        <div class="well">
            <legend>Sign in to WebApp</legend>
            <form method="POST" action="" accept-charset="UTF-8">
                <?php if($_REQUEST[errorLogin]){?>
                <div class="alert alert-error">
                    <a class="close" data-dismiss="alert" href="#">x</a>Incorrect Username or Password!
                </div>
                <?php } ?>
                <input class="span3" placeholder="Username" type="text" name="username">
                <input class="span3" placeholder="Password" type="password" name="password">
                <label class="checkbox">
                    <input type="checkbox" name="remember" value="1"> Remember Me
                </label>
                <button class="btn-info btn" type="submit">Login</button>
            </form>
        </div>
    </div>
</div>



                <h4>Logga in</h4>
                   <div class="alert alert-error"> Fel användarnamn o eller lösenord...</div>
                    <form action="fileManager.php" method="post">
                      <fieldset>
                        <label>User Name</label>
                        <input type="text" id="email" name="email" placeholder="email...">
                        <label>Password</label>
                        <input type="password" id="passwd" name="passwd" placeholder="Password">
                        <button type="submit" class="btn">Submit</button>
                      </fieldset>
                    </form>                
                </div>
            </div>
        

</body>
</html>
