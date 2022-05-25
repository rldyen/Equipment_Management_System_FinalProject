<?php
    include ("Session-Checker.php");
    require_once "Config.php";

    //Update

    if(isset($_POST['btnSubmit'])){
        $sql = "UPDATE tblaccounts SET password = ?, usertype = ? WHERE username = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $_POST['txtPassword'],
            $_POST['cmbusertype'],  $_GET['username']);
            
            if(mysqli_stmt_execute($stmt)){
                header("Location: Account-Management-Menu.php?success=1");
                $_SESSION['message'] = 'Account successfully updated!';
                exit();
            } else{
                echo '<div class ="incorrectText">Error on update statement</div>';

            } 
        }
    }

    else {
            if (isset($_GET['username']) && !empty(trim($_GET['username']))){

                $sql = "SELECT * FROM tblaccounts WHERE username = ?";
                if($stmt = mysqli_prepare($link, $sql)){
                    mysqli_stmt_bind_param($stmt, "s", $_GET['username']);
                    if(mysqli_stmt_execute($stmt)){
                        $result = mysqli_stmt_get_result($stmt);
                        if(mysqli_num_rows($result) == 1){
                            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        } else{
                            header("Location: Error.php");
                            exit();
                        }
                    } else {
                        echo '<div class ="incorrectText">Error on select statement</div>';
                    }
                }
            }
        }

        ?>

<!doctype html>
<html lang="en">
<head>
    <title>Update Account</title>
    <link rel="stylesheet" href="Style_Account-Update.css">
</head>
<body>

    <div class ="formContainer">

        <p class="updateAccountInstruction">Edit the values and submit to update the Account</p>
        <form action = "<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method ="POST">

        <div class ="data">
            <label>Username: </label><?php echo $row['username']; ?> <br><br>
            <label>Password: </label><input type="password" name="txtPassword" value="<?php echo $row['password']; ?>" required> <br><br>
            <label>Current User Type: </label> <?php echo $row['usertype']; ?>
        </div>

        <br><br>

        <div class ="dataUserType">
            <label>Select New User Type: </label>

            <select name="cmbusertype" id="cmbusertype" required>
                <option value="">--Select User Type--</option>
                <option value="ADMINISTRATOR">Administrator</option>
                <option value="TECHNICAL">Technical</option>
                <option value="USER">User</option>
            </select><br>

        </div>

            <div class ="submitBtn">
                <div class = "inner">
                    <input type="submit" name="btnSubmit" value ="Submit">
                </div>  
            </div>

            <div class ="cancelRef">
                <a href="Account-Management-Menu.php" class="cancelText">Cancel</a>
            </div>

        </form>

    </div>
</body>
</html>