<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Index</title>
    <link rel="stylesheet" href="Style_Index.css">
</head>

<body>

    <?php

        session_start();

        $color= "#4e685d";

        echo '<div class="headerText">';

        if(isset($_SESSION['username'])){
            ?> <h1 class="welcomeText"> <?php echo "Welcome, " . $_SESSION['username']; ?> </h1>
            <h4> <?php echo "User Type: " . $_SESSION['usertype']; 
            
            echo '</div>';
            
            ?> </h4> 


        <?php

            } else{
                header("location: Login.php");
            }

            if($_SESSION['usertype'] == 'ADMINISTRATOR'){

                echo '<div class="squareContainer">';

                echo '<div class="squareContent1">';
                echo '<a href="Account-Management-Menu.php">Accounts Management</a>';
                echo '</div>';

                echo "<div class='squareContent2'>";
                echo "<a href='Equipment-Management-Menu.php'>Equipment Management</a>";
                echo "</div>";

                echo "<div class='clear'>";
                echo "</div>";

                echo "</div><br>";
                    }

            if($_SESSION['usertype'] == 'TECHNICAL'){

                echo '<div class="squareContainer">';

                echo "<div class='squareContent2'>";
                echo "<a href='Equipment-Management-Menu.php'>Equipment Management</a>";
                echo "</div>";

                echo "<div class='clear'>";
                echo "</div>";

                echo "</div><br>";

            }

            if($_SESSION['usertype'] == 'USER'){

                echo '<div class="squareContainer">';

                echo "<div class='squareContent2'>";
                echo "<a href='Equipment-Management-View.php'>View Equipment</a>";
                echo "</div>";

                echo "<div class='clear'>";
                echo "</div>";

                echo "</div><br>";

            }

            echo "<div class='logoutRef'>";
            echo '<a href="Logout.php">Logout</a>';
            echo "</div>";

        ?>

</body>
</html>

