<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register to attend Marathon</title>
    <!-- Thêm tệp CSS của Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            padding: 35px;
            max-width: 500px;
            width: 100%;
        }
    </style>
</head>
<body>
    <button onclick="goHome()" class="btn btn-primary">Back to Home</button>
    <div class="container mt-4">
        <?php
            if (isset($_POST['User_attend'])) {
                $fullname = $_POST['fullname'];
                $bestrecord = $_POST['bestrecord'];
                $nationality = $_POST['nationality'];
                $passport = $_POST['passport'];
                $sex = $_POST['sex'];
                $age = $_POST['age'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];

                $errors = array();

                require_once "Database.php";

                $sql1 = "SELECT * FROM user_participants WHERE email = '$email'";
                $sql2 = "SELECT * FROM user_participants WHERE passport = '$passport'";
                $sql3 = "SELECT * FROM user_participants WHERE phone = '$phone'";
                $result1 = mysqli_query($conn, $sql1);
                $result2 = mysqli_query($conn, $sql2);
                $result3 = mysqli_query($conn, $sql3);
                $rowCount1 = mysqli_num_rows($result1);
                $rowCount2 = mysqli_num_rows($result2);
                $rowCount3 = mysqli_num_rows($result3);
                if ($rowCount1 > 0) {
                    array_push($errors, "Email already exists");
                }
                if ($rowCount2 > 0) {
                    array_push($errors, "Passport number already exists");
                }
                if ($rowCount3 > 0) {
                    array_push($errors, "Phone number already exists");
                }
                if (count($errors) > 0) {
                    foreach ($errors as $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {
                    $sql = "INSERT INTO user_participants (fullname, best_record, nationality, passport, sex, age, email, phone, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                    if ($prepareStmt) {
                        mysqli_stmt_bind_param($stmt, "sssssssss", $fullname, $bestrecord, $nationality, $passport, $sex, $age, $email, $phone, $address);
                        mysqli_stmt_execute($stmt);

                        // Get the ID of the inserted record
                        $user_id = mysqli_insert_id($conn);
                    
                        // Redirect to "list_marathon.php" with the user ID as a parameter
                        header("Location: list_marathon.php?user_id=$user_id");
                        exit();
                    } else {
                        die("Something went wrong");
                    }
                }
            }
        ?>

        <form action="User_participant.php" method="POST">
            <div class="mb-3">
                <input type="text" name="fullname" class="form-control" placeholder="Full name" required>
            </div>
            <div class="mb-3">
                <input type="text" name="bestrecord" class="form-control" placeholder="Your best time record" required pattern="\d{2}:\d{2}:\d{2}" title="Please enter the time in the format HH:MM:SS">
            </div>
            <div class="mb-3">
                <input type="text" name="nationality" class="form-control" placeholder="Your country" required pattern="[A-Za-z\s]+" title="Please enter a valid country name">
            </div>
            <div class="mb-3">
                <input type="text" name="passport" class="form-control" placeholder="Passport number" required pattern="[0-9]+" title="Please enter a valid passport number">
            </div>
            <div class="mb-3">
                <label for="sex">Sex:</label>
                <select id="sex" name="sex" class="form-select" required>
                    <option value="">-- Select --</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="number" name="age" class="form-control" placeholder="Age" required min="18" max="60">
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address">
            </div>
            <div class="mb-3">
                <input type="tel" name="phone" class="form-control" placeholder="Phone number" required pattern="[0-9]{11}" title="Please enter a valid phone number (11 digits)">
            </div>
            <div class="mb-3">
                <input type="text" name="address" class="form-control" placeholder="Address" required>
            </div>
            <div>
                <button type="submit" name="User_attend" class="btn btn-primary">Update information</button>
            </div>
        </form>
        <br>
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <button class="btn btn-primary"><a href="User_profile.php" style="color: white; text-decoration: none;">Find profile</a></button>
            <button class="btn btn-primary"><a href="List_marathon.php" style="color: white; text-decoration: none;">Participate</a></button>
        </div>
    </div>

    <!-- Thêm tệp JS của Bootstrap, Popper.js, và jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2Xof8/J6SOWBAeYa/6IE98J+6WKbQo5t47g" crossorigin="anonymous"></script>
    <script src="Js/js.js"></script>
</body>
</html>
