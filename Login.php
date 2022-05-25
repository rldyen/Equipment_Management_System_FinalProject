<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <link rel="stylesheet" href="Style_Login.css">
</head>

<body>

    <div class="login-form">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <h2 class="text-center">Sign In</h2>   
            
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" placeholder="Username" required="required" name="txtUsername">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" placeholder="Password" required="required" name="txtPassword">
                </div>
            </div>     

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" name="btnSubmit">Login</button>
            </div>

            <div class="clearfix">
                <label class="pull-left checkbox-inline"><input type="checkbox"> Remember me</label>
            </div>  

        </form>
    </div>

</body>
</html>

    <?php
        if(isset($_POST['btnSubmit'])){

            require_once "Config.php";

            $sql = "SELECT * FROM tblaccounts WHERE username = ? and password = ? and status = 'ACTIVE' ";

            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "ss", $_POST['txtUsername'], $_POST['txtPassword']);
                
                if(mysqli_stmt_execute($stmt)){
                    $result = mysqli_stmt_get_result($stmt);
                    
                    if(mysqli_num_rows($result) == 1){
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                        session_start();
                        $_SESSION['username'] = $_POST['txtUsername'];
                        $_SESSION['usertype'] = $row['usertype'];

                        header("location: Index.php?username=" . $row['username']. "?usertype=" . $row['usertype']. "");
                    } else{
                        echo '<div class ="incorrectText">Incorrect Username or Password or Account is Inactive</div>';
                    }
                }
            } else{
                echo '<div class ="incorrectText">Error on select statement</div>';
            }

            
        }
        ?>