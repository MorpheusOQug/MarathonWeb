<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Update marathon</title>
</head>
<body>
    <div>
        <?php
            include 'Database.php';

            $marathon_id = $_GET['updateid'];
            $sql = "SELECT * FROM marathon WHERE marathon_id=$marathon_id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $race_name = $row['race_name'];
            $date = $row['date'];

            if (isset($_POST['Update_race'])) {
                $race_name = $_POST['race_name'];
                $date = $_POST['date'];

                $errors = array();

                require_once "Database.php";

                $sql = "SELECT * FROM marathon WHERE race_name ='$race_name'";
                $result = mysqli_query($conn, $sql);
                $rowCount = mysqli_num_rows($result);
                if ($rowCount > 1) {
                    array_push($errors, "Race name already exists");
                }
                if (count($errors) > 1) {
                    foreach ($errors as $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {
                    $sql = "UPDATE marathon SET race_name='$race_name', date='$date' WHERE marathon_id=$marathon_id";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        header('location:Index.php');
                        exit;
                    } else {
                        die("Something went wrong");
                    }
                }
            }
        ?>

        <form action="" method="post">
            <div>
                <label>Race name</label>
                <input type="text" placeholder="Enter your name" name="race_name" autocomplete="off" value="<?php echo $race_name;?>">
            </div>
            <div>
                <label>Date</label>
                <input type="date" name="date" autocomplete="off" value="<?php echo $date;?>">
            </div>
            <button name="Back"><a href="Index.php">Back</a></button>
            <button type="submit" name="Update_race">Update</button>
        </form>
        </div>
</body>
</html>