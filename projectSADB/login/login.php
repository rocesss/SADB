<!Doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css" type="text/css">
    <script src="../../jquery.min.js" type="text/javascript"></script>
    <script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="utility.js" type="text/javascript"></script>
    <link rel="stylesheet" href="loginCss.css" type="text/css">
    <title>Log In</title>
</head>

<body>
    <div class="container-fluid">
        <div id="first-container" class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <img class="img-responsive" src="../image/Ahealth-logo2.png">
            </div>
        </div>

        <div id="second-container" class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <form method="post" action="loginPhp.php">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                            <input type="text" class="form-control" name="username" placeholder="Username">
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <div class="input-group">
                            <button type="submit" id="login-button" class="btn btn-block">Log In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close login-failed-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Login Failed</h4>
                </div>
                <div class="modal-body">
                    <p>Username or Password Incorrect</p>
                </div>
                <div class="modal-footer">
                    <button id="login-failed-button" class="login-failed-close" type="button" class="btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
           if(getUrlVars()["login_attempt"] == 1){
               $("#myModal").modal();
           }

           $(".login-failed-close").click(function(){
               location.href = "http://localhost/PhpStormWorkspace/projectSADB/login/login.php";
           });
        });
    </script>

</body>
</html>


