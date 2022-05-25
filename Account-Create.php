<?php
    
    include("Session-Checker.php");
    require_once "Config.php";
    
    if(isset($_POST['btnSubmit'])){
        //check if the username is existing
        $sql = "SELECT * FROM tblaccounts WHERE username = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $_POST['txtUsername']);
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) != 1){
                    //insert new user to the Accounts Table
                    $sql = "INSERT INTO tblaccounts VALUES (?, ?, ?, ?, ?)";
                    if($stmt = mysqli_prepare($link, $sql)){
                        $status = "ACTIVE";
                        
                        mysqli_stmt_bind_param($stmt, "sssss", $_POST['txtUsername'], $_POST['txtPassword'], $_POST['cmbusertype'], $status, $_SESSION['username']);

                        if(mysqli_stmt_execute($stmt)){
                            header("Location: Account-Management-Menu.php?success=1");
                            $_SESSION['message'] = 'Account successfully added!';
                            exit();

                        } else {
                            echo '<div class ="incorrectText">Error on insert statement</div>';
                        }
                    }

                } else {
                    echo '<div class ="incorrectText">User already exists</div>';
                }

            } else{
                echo '<div class ="incorrectText">Error on select statement"</div>';
            }
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <title>Add New Account</title>
    <link rel="stylesheet" href="Style_Account-Create.css">
</head>
<body>

    <div class = "formContainer">
        <p class="createAccountInstruction">Fill up this form and submit to add a new user</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <div class ="data">
            <label>Username</label><input type="text" name="txtUsername" required></br>
        </div>

        <div class ="data">
            <label>Password</label><input type="password" name="txtPassword" required></br>
        </div>

        <div class ="dataUserType">
            <label>User Type: </label> 
            
            <select name="cmbusertype" id="cmbusertype" required>
                <option value="">--Select User Type--</option>
                <option value="ADMINISTRATOR">Administrator</option>
                <option value="TECHNICAL">Technical</option>
                <option value="USER">User</option>
            </select>

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
