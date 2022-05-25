<?php
    require_once "Config.php";
    include("Session-Checker.php");

    if(isset($_POST['btnSubmit'])){
        $sql = "DELETE FROM tblequipment WHERE serial_number =?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", trim($_POST['serial_number']));
            
            if(mysqli_stmt_execute($stmt)){

                header("Location: Equipment-Management-Menu.php?success=1");
                $_SESSION['message'] = 'Equipment successfully deleted!';
                exit();

            } else{
                echo '<div class ="incorrectText">Error on delete statement</div>';
            }
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <title>Delete Equipment</title>
    <link rel="stylesheet" href="Style_Equipment-Modal-Form.css">
</head>
<body>
    <div class="modalContainer">
        <div class="modalHeaderText">
            <p>Are you sure you want to delete this equipment? </p><br />
        </div>
        <div class="modalBody">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="hidden" name="serial_number" value="<?php echo trim($_GET["serial_number"]); ?>" />
                <input type="submit" name="btnSubmit" value="YES">
                
                <div class="cancelContainer">
                    <a href="Equipment-Management-Menu.php">NO</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>