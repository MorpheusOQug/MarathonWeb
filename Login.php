<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: Index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login for Admin</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

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
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Login for Admin</h3>
        <?php
        if (isset($_POST["login"])) {
           $email = $_POST["email"];
           $password = $_POST["password"];
            require_once "Database.php";
            $sql = "SELECT * FROM admins WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $admin_acc = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($admin_acc) {
                if (password_verify($password, $admin_acc["password"])) {
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("Location: Index.php");
                    die();
                } else {
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Email does not match</div>";
            }
        }
        ?>
        <form action="Login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Password" name="password" class="form-control">
            </div>
            <div class="submit_button">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div><p>Not registered yet <a href="Register.php">Register Here</a></p></div>

        <button onclick="goHome()" class="btn btn-secondary">Back to Home</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-pzjw8r+V9BSwKq5rkpFVJ6Z5L4Wui3+Ex9l9FCpW2GGDbY+orMyKp4R5T5qdjErV" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2Xof8/J6SOWBAeYa/6IE98J+6WKbQo5t47g" crossorigin="anonymous"></script>
    <script src="Js/js.js"></script>
</body>
</html>
