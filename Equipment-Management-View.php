<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Equipment Management</title>
    <link rel="stylesheet" href="Style_Equipment-Management-Menu.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
    
</head>

<body>

    <div class ="center">

        <div class="formContainer">

        <?php

        session_start();
        
        ?>

        <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <br><br>
        <a href ="Index.php" class="logoutRef">Go Back</a>

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
                    echo "<th>Serial Number</th>";
                    echo "<th>Model</th>";
                    echo "<th>Description</th>";
                    echo "<th>Department</th>";
                    echo "<th>Status</th>";
                    echo "<th>Created By</th>";

                    echo "</tr>";

                    //table data (loop each row of the result)
                    while($row = mysqli_fetch_array($result)){
                    
                        echo "<tr>";
                        echo "<td >" . $row['serial_number'] . "</td>";
                        echo "<td>" . $row['model'] . "</td>";	
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['department'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . $row['createdby'] . "</td>";
                        echo "</tr>";
                     }

                echo "</table>";
                } else {
                    echo '<br><div class="incorrectText">No equipment/s found.</div>';
                    }
                }

                require_once "Config.php";
            
                if(isset($_POST['btnSubmit'])){
                    $sql = "SELECT * FROM tblequipment WHERE serial_number <> ? AND serial_number LIKE ? OR model LIKE ? OR department LIKE ? OR status LIKE ? ORDER BY serial_number";
                    if($stmt = mysqli_prepare($link, $sql)){
                        $search = '%' . $_POST['txtSearch'] . '%';
                        mysqli_stmt_bind_param($stmt, "sssss", $_SESSION['username'], $search, $search, $search, $search);
                        if(mysqli_stmt_execute($stmt)){
                            $result = mysqli_stmt_get_result($stmt);
                            build_table($result);
                        }
                        else{
                            echo '<br><div class="incorrectText">Error on search button.</div>';
                        }
                    }
                }

                else{
                    $sql = "SELECT * FROM tblequipment WHERE serial_number <> ? ORDER BY serial_number";
                    if($stmt = mysqli_prepare($link, $sql)){
                        mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
                        if(mysqli_stmt_execute($stmt)){
                            $result = mysqli_stmt_get_result($stmt);
                            build_table($result);
                        }
                        else{
                            echo '<br><div class="incorrectText">Error on form load.</div>';
                        }
                    }
                }
        ?>

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
