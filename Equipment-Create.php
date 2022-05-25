<?php
    
    include("Session-Checker.php");
    require_once "Config.php";
    
    if(isset($_POST['btnSubmit'])){

        //check if the serial_number is existing
        $sql = "SELECT * FROM tblequipment WHERE serial_number = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $_POST['txtSerialNumber']);
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) != 1){

                    //insert new Equipment to the table
                    $sql = "INSERT INTO tblequipment VALUES (?, ?, ?, ?, ?, ?)";
                    if($stmt = mysqli_prepare($link, $sql)){
                        $status = "WORKING";
                        
                        mysqli_stmt_bind_param($stmt, "ssssss", $_POST['txtSerialNumber'], $_POST['model'], $_POST['description'], $_POST['department'], $status, $_SESSION['username']);

                        if(mysqli_stmt_execute($stmt)){
                            header("Location: Equipment-Management-Menu.php?success=1");
                            $_SESSION['message'] = 'Equipment successfully added!';
                            exit();

                        } else {
                            echo '<div class ="incorrectText">Error on insert statement</div>';
                        }
                    }

                } else {
                    echo '<div class ="incorrectText">Equipment already exists</div>';
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
    <title>Add New Equipment</title>
    <link rel="stylesheet" href="Style_Equipment-Create.css">
</head>
<body>

    <div class = "formContainer">
        <p class="createEquipmentInstruction">Fill up this form and submit to add a new equipment</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <div class ="dataSerialNumber">
            <label>Serial Number: </label><input type="text" name="txtSerialNumber" required></br>
        </div>

        <div class ="dataBox">
            <label>Model: </label>

            <select name="model" id="model" required>
                <option value="">--Select Model Type--</option>
                <option value="AVR">AVR</option>
                <option value="CPU">CPU</option>
                <option value="KEYBOARD">Keyboard</option>
                <option value="MAC">MAC</option>
                <option value="MONITOR">Monitor</option>
                <option value="MOUSE">Mouse</option>
                <option value="PRINTER">Printer</option>
                <option value="PROJECTOR">Projector</option>
                <option value="SPEAKER">Speaker</option>
            </select><br>

        </div>

        <div class ="descriptionBox">
                <label>Description: </label><br>
                <textarea name="description" rows="4" cols="70%" wrap="hard" class="descriptionTextBox" required></textarea>
        </div>

        <div class ="dataBox">
            <label>Department: </label>

            <select name="department" id="model" required>
                <option value="">--Select Department--</option>
                <option value="FACULTY OF SACRED THEOLOGY">Faculty of Sacred Theology</option>
                <option value="FACULTY OF PHILOSOPHY">Faculty of Philosophy/option>
                <option value="FACULTY OF CANON LAW">Faculty of Canon Law</option>
                <option value="FACULTY OF CIVIL LAW">Faculty of Civil Law</option>
                <option value="FACULTY OF MEDICINE & SURGERY">Faculty of Medicine & Surgery</option>
                <option value="FACULTY OF PHARMACY">Faculty of Pharmacy</option>
                <option value="FACULTY OF ARTS AND LETTERS">Faculty of Arts and Letters</option>
                <option value="FACULTY OF ENGINEERING">Faculty of Engineering</option>
                <option value="COLLEGE OF EDUCATION">College of Education</option>
                <option value="COLLEGE OF SCIENCE">College of Science</option>
                <option value="COLLEGE OF ARCHITECTURE">College of Architecture</option>
                <option value="COLLEGE OF COMMERCE AND BUSINESS ADMINISTRATION">College of Commerce and Business Administration</option>
                <option value="GRADUATE SCHOOL">Graduate School</option>
                <option value="CONSERVATORY OF MUSIC">Conservatory of Music</option>
                <option value="COLLEGE OF NURSING">College of Nursing</option>
                <option value="COLLEGE OF REHABILITATION SCIENCES">College of Rehabilitation Sciences</option>
                <option value="COLLEGE OF FINE ARTS AND DESIGN">College of Fine Arts and Design</option>
                <option value="INSTITUTE OF PHYSICAL EDUCATION & ATHLETICS">Institute of Physical Education & Athletics</option>
                <option value="ALFREDO M. VELAYO COLLEGE OF ACCOUNTANCY">Alfredo M. Velayo College of Accountancy</option>
                <option value="COLLEGE OF TOURISM & HOSPITALITY MANAGEMENT">College of Tourism & Hospitality Management</option>
                <option value="INSTITUTE OF INFORMATION AND COMPUTING SCIENCES">Institute of Information and Computing Sciences</option>
                <option value="GRADUATE SCHOOL OF LAW">Graduate School of Law</option>
            </select><br>

        </div>

        <div class ="submitBtn">
            <div class = "inner">
                <input type="submit" name="btnSubmit" value ="Submit">
            </div>  
        </div>

        <div class ="cancelRef">
            <a href="Equipment-Management-Menu.php" class="cancelText">Cancel</a>
        </div>

        </form>
    </div>
</body>
</html>
