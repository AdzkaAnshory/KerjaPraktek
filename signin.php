<?php
session_start();
if (isset($_SESSION["id"])) header("Location:index.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Cahaya Group Signin</title>

        <link href="css/style.default.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="signin">
        
        
        <section>
            
            <div class="panel panel-signin">
                <div class="panel-body">
                    <div class="logo text-center">
                        <img src="images/Cahaya Group.jpg" alt="Chain Logo" width="100px">
                    </div>
                    <br />
                    <h4 class="text-center mb5">Cahaya Group</h4>
                    <p class="text-center">Login Admin</p>
                    
                    <div class="mb30"></div>
                    
                    <form action="signin.php" method="post" id="form">
                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="email" class="form-control" placeholder="Email" id="email" name="email">
                        </div><!-- input-group -->
                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                        </div><!-- input-group -->
                        
                        <div class="clearfix">
                            <div class="pull-left">
                                <div class="ckbox-primary mt10">
                                    <label id="status"></label>
                                </div>
                            </div>
                            <div class="pull-right">
                                <button type="submit" id="submit" name="submit" class="btn btn-success">Sign In <i class="fa fa-angle-right ml5"></i></button>
                            </div>
                        </div>                      
                    </form>
            </div><!-- panel -->
            
        </section>


        <script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/jquery-migrate-1.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/modernizr.min.js"></script>
        <script src="js/pace.min.js"></script>
        <script src="js/retina.min.js"></script>
        <script src="js/jquery.cookies.js"></script>

        <script src="js/custom.js"></script>

        <script>
            $("#form").on("submit", function (e) {
                e.preventDefault();

                $.ajax({
                    url: "action/login_aksi.php",
                    data: $("#form").serialize(),
                    method: "POST",
                    dataType: "JSON",
                    beforeSend: function (e) {
                        $("#submit").attr("disabled", true);
                        $("#status").html("Loading...");
                    },
                    success: function (data) {
                        console.log(data)
                        $("#status").html(data.message);

                        if (data.status == 1)
                            setTimeout(function(){ window.location.href = "index.php"; }, 2000);
                        else
                            $("#submit").attr("disabled", false);
                    }
                })
            })
        </script>
    </body>
</html>
