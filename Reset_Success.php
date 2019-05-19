<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Log Back In</title>
    <!-- Bootstrap -->
    <link type="text/css" href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	    <link type="text/css" href="bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body style="background-color: lightskyblue;">
<br/>
<br/>
<div class="container text-center">
<br/>
<p>Password Was Reset Successfully! Log In Below</p>
</div>
<br/>
<br/>
<div>
    <div class="container">
        <div class="row">
			<div class="col-md-4"></div>
            <div class="modal-content col-md-4">
                <div class="modal-body">
                    <div class="modal-header">
                        <h3>Login Area</h3>
                    </div>
                    <form action="LogIn.php" method="post">
                        <div class="form-group">

                            <label for="UserName">UserName</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                <input type="text" class="form-control" name="UN" required="required" placeholder="UserName">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Password">Password</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-star"></span></span>
                                
								<input type="password" class="form-control" required="required" name="new_pw" id="new_pw" placeholder="Password">
							</div>
							<br/>
								<button type="button" id="show_password" class="btn btn-success" name="show_password">Show</button>
						</div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="glyphicon glyphicon-lock"></span>
                                    <input type="submit" name="submit" value ="Log In" class="btn btn-primary" style="margin-left:5px;">
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
		<div class="col-md-4"></div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="JS/jquery.js"></script>
<script src="JS/peekaboo.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
</body>
</html>