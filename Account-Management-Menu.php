<!doctype html>
<html lang="en">
<head>
    <title>Account Management</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="Style_Account-Management-Menu.css">
</head>
    <body>
    <div class ="center">

        <div class="formContainer">

                <?php

                session_start();

                $color= "#4e685d";

                if ( isset($_GET['success']) && $_GET['success'] == 1 ){
                    echo  '<div style="color: #4e685d; font-weight: bold; ">' . $_SESSION['message'] . '</div>';
                    $_SESSION['message'] = null;
                }

                if(isset($_SESSION['username'])){
                ?> <h1 class="welcomeText"> <?php echo $_SESSION['username']; ?> </h1>
                <h4> <?php echo "User Type: " . $_SESSION['usertype']; ?> </h4> 
                
                <?php

                } else{
                    header("location: Login.php");
                }
                ?>

            <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <a href ="Index.php" class="logoutRef">Go Back</a>
            <a href ="Account-Create.php" class="createAccountRef">Add New User</a><br>

            <br><br>
            <div class="searchBorder">Search: <input type="text" name="txtSearch">
            <input type="submit" name="btnSubmit" value="SUBMIT">
            </div>
            <br>

            <?php 
            function build_table($result){
                if(mysqli_num_rows($result) > 0){
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Username</th>";
                    echo "<th>User Type</th>";
                    echo "<th>Status</th>";
                    echo "<th>Created By</th>";
                    echo "</tr>";

                    //table data (loop each row of the result)
                    while($row = mysqli_fetch_array($result)){
                        echo "<tr>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['usertype'] . "</td>";	
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . $row['createdby'] . "</td>";
                        echo "<td>";
                            echo "<a href='Account-Update.php?username=" . $row['username'] . "'>Update</a>|";
                            echo "<a data-toggle='modal' href='Account-Activate.php?username=" . $row['username'] . "' data-target='#activateModal'>Activate</a>|";
                            echo "<a data-toggle='modal' href='Account-Deactivate.php?username=" . $row['username'] . "' data-target='#deactivateModal'>Deactivate</a>|";
                            echo "<a data-toggle='modal' href='Account-Delete.php?username=" . $row['username'] . "' data-target='#deleteModal'>Delete<br></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                echo "</table>";
                } else{
                    echo '<br><div class="incorrectText">No User Account/s found.</div>';
                    }

            }

            require_once "Config.php";

            if(isset($_POST['btnSubmit'])){
                $sql = "SELECT * FROM tblaccounts WHERE username <> ? AND username LIKE ? OR usertype LIKE ? ORDER BY username";
                if($stmt = mysqli_prepare($link, $sql)){
                    $search = '%' . $_POST['txtSearch'] . '%';
                    mysqli_stmt_bind_param($stmt, "sss", $_SESSION['username'], $search, $search);
                    if(mysqli_stmt_execute($stmt)){
                        $result = mysqli_stmt_get_result($stmt);
                        build_table($result);
                    } else{
                        echo '<br><div class="incorrectText">Error on search button.</div>';
                        }
                }
            }

            else{
                $sql = "SELECT * FROM tblaccounts WHERE username <> ? ORDER BY username";
                if($stmt = mysqli_prepare($link, $sql)){
                    mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
                    if(mysqli_stmt_execute($stmt)){
                        $result = mysqli_stmt_get_result($stmt);
                        build_table($result);
                    } else{
                        echo '<br><div class="incorrectText">Error on form load.</div>';
                        }
                }
            }
                ?>

        </div>

    </div>

        <div id="activateModal">
            <div class="modal-dialog">
                <div class="modal-content">
                </div>
            </div>
        </div>

        <div id="deactivateModal">
            <div class="modal-dialog">
                <div class="modal-content">
                </div>
            </div>
        </div>

        <div id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                </div>
            </div>
        </div>

    </body>
</html>