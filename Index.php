<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: Login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Admin page manage marathon_website</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to Admin page</h1>
        <button onclick="goHome()">Back to Home</button>
        <button onclick="goForward()">Back to Login</button>

        <?php
        if(isset($_POST['Submit_race'])) {
            $race_name = $_POST['race_name'];
            $date = $_POST['date'];

            $errors = array();

            require_once "Database.php";

            $sql = "SELECT * FROM marathon WHERE race_name = '$race_name'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount>0) {
                array_push($errors,"Race name already exists");
            }
            if (count($errors)>0) {
                foreach ($errors as  $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            } else {
                $sql = "INSERT INTO marathon (race_name, date) VALUES (?,?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "ss", $race_name, $date);
                    mysqli_stmt_execute($stmt);
                    // echo "<div>Data inserted successfully</div>";
                } else {
                    die("Something went wrong");
                }
            }
        }
        ?>

        <form action="" method="post">
            <div class="mb-3">
                <label class="form-label">Race name:</label>
                <input type="text" class="form-control" placeholder="Enter your name" name="race_name" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Date</label>
                <input type="date" class="form-control" name="date" autocomplete="off" min="2023-12-12" required>
            </div>
            <button type="submit" class="btn btn-primary" name="Submit_race">Submit</button>
        </form>

        <h3>Marathon list:</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Marathon ID</th>
                    <th scope="col">Race name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once "Database.php";
                $sql = "SELECT * FROM marathon";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $marathon_id = $row['marathon_id'];
                        $race_name = $row['race_name'];
                        $date = $row['date'];
                        echo '
                        <tr>
                            <th>'.$marathon_id.'</th>
                            <th>'.$race_name.'</th>
                            <th>'.$date.'</th>

                            <td>
                            <button><a href="Update.php?updateid='.$marathon_id.'" style="text-decoration: none;">Update</a></button>
                            <button><a href="Delete.php?deleteid='.$marathon_id.'" style="text-decoration: none;">Delete</a></button>
                            </td>
                        </tr>';
                    }
                }
                ?>
            </tbody>
        </table>

        <h3>Players list:</h3>
        <button class="btn btn-primary"><a href="User_profile.php" style="color: white; text-decoration: none;">Find profile</a></button>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Best record</th>
                    <th scope="col">Nationality</th>
                    <th scope="col">Passport</th>
                    <th scope="col">Sex</th>
                    <th scope="col">Age</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Address</th>

                    <th scope="col">Marathon ID</th>
                    <th scope="col">Entry NO</th>
                    <th scope="col">Hotel</th>
                    <th scope="col">Time record</th>
                    <th scope="col">Standing</th>

                    <th scope="col">Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once "Database.php";
                $sql = "SELECT * FROM user_participants";
                $sql1 = "SELECT * FROM participate";
                $result = mysqli_query($conn, $sql);
                $result1 = mysqli_query($conn, $sql1);
                if ($result && $result1) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $user_id = $row['user_id'];
                        $fullname = $row['fullname'];
                        $best_record = $row['best_record'];
                        $nationality = $row['nationality'];
                        $passport = $row['passport'];
                        $sex = $row['sex'];
                        $age = $row['age'];
                        $email = $row['email'];
                        $phone = $row['phone'];
                        $address = $row['address'];

                        // Initialize additional fields from the participate table
                        $marathon_id = "";
                        $entry_no = "";
                        $hotel = "";
                        $time_record = "";
                        $standing = "";

                        // Fetch data from the participate table based on user_id
                        while($participate_row = mysqli_fetch_assoc($result1)) {
                            if ($participate_row['user_id'] == $user_id) {
                                $marathon_id = $participate_row['marathon_id'];
                                $entry_no = $participate_row['entry_no'];
                                $hotel = $participate_row['hotel'];
                                $time_record = $participate_row['time_record'];
                                $standings = $participate_row['standings'];
                                break; // Exit the loop once the corresponding row is found
                            }
                        }
                        echo '
                        <tr>
                            <th>'.$user_id.'</th>
                            <th>'.$fullname.'</th>
                            <th>'.$best_record.'</th>
                            <th>'.$nationality.'</th>
                            <th>'.$passport.'</th>
                            <th>'.$sex.'</th>
                            <th>'.$age.'</th>
                            <th>'.$email.'</th>
                            <th>'.$phone.'</th>
                            <th>'.$address.'</th>

                            <th>'.$marathon_id.'</th>
                            <th>'.$entry_no.'</th>
                            <th>'.$hotel.'</th>
                            <th>'.$time_record.'</th>
                            <th>'.$standing.'</th>

                            <td>
                            <button><a href="Delete.php?deleteid='.$user_id.'" style="text-decoration: none;">Delete</a></button>
                            </td>
                        </tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
<script src="Js/js.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2Xof8/J6SOWBAeYa/6IE98J+6WKbQo5t47g" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8r+V9BSwKq5rkpFVJ6Z5L4Wui3+Ex9l9FCpW2GGDbY+orMyKp4R5T5qdjErV" crossorigin="anonymous"></script>
</html>
