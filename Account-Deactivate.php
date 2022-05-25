<?php
    require_once "Config.php";
    include("Session-Checker.php");

    if(isset($_POST['btnSubmit'])){
        $sql = "UPDATE tblaccounts SET status = 'INACTIVE' WHERE username =?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", trim($_POST['username']));
            if(mysqli_stmt_execute($stmt)){
                header("Location: Account-Management-Menu.php?success=1");
                $_SESSION['message'] = 'Account successfully deactivated!';
                exit();
            } else{
                echo '<div class ="incorrectText">Error on deactivate statement</div>';
            }
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <title>Deactivate Account</title>
    <link rel="stylesheet" href="Style_Modal-Form.css">
</head>
<body>

    <div class="modalContainer">
        <div class="modalHeaderText">
                <p>Are you sure you want to deactivate this account? </p><br />
        </div>

        <div class="modalBody">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="hidden" name="username" value="<?php echo trim($_GET["username"]); ?>" />
                <input type="submit" name="btnSubmit" value="YES">
                
                <div class="cancelContainer">
                    <a href="Account-Management-Menu.php">NO</a>
                </div>

            </form>
        </div>
    </div>
</body>
</html>