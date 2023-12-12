<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marathon page</title>

    <!-- Thêm tệp CSS của Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Style/General.css">
    <link rel="stylesheet" href="Style/Home.css">

    <style>
    body {
        background-image: url('Image/900X603-6889-1672321989.jpg');
        background-size: cover;
        background-position: center; 
        background-repeat: no-repeat; 
        height: 100vh;
        margin: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .container {
        background-color: rgba(255, 255, 255, 0.8); /* Một màu nền trắng trong suốt để làm nổi bật nội dung */
        padding: 20px;
        border-radius: 10px; /* Bo tròn góc của container */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Hiển thị bóng đổ nhẹ */
    }
</style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="Image/Sadboy.jpg" alt="Logo" class="photo_image">
            </a>

            <h2>Marathon web</h2>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <!-- 
                            if not login yet:
                            Login for admin
                            else:
                            Logout for admin  -->
                        <p class="nav-link"><a href="Login.php">Login</a></p>
                    </li>
                    <li class="nav-item">
                        <!-- Participate marathon for players -->
                        <p class="nav-link"><a href="User_participant.php">Marathon</a></p>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="table-container">
            <!-- Show list marathon had been created by admin -->
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Marathon ID</th>
                        <th scope="col">Race name</th>
                        <th scope="col">Date</th>
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
                                <td>'.$marathon_id.'</td>
                                <td>'.$race_name.'</td>
                                <td>'.$date.'</td>
                            </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>

            <!-- Show list players attend -->
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Nationality</th>

                        <th scope="col">Time record</th>
                        <th scope="col">Standing</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM user_participants";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $user_id = $row['user_id'];
                            $fullname = $row['fullname'];
                            $nationality = $row['nationality'];
                            echo '
                            <tr>
                                <td>'.$user_id.'</td>
                                <td>'.$fullname.'</td>
                                <td>'.$nationality.'</td>
                                <td>Time record data</td>
                                <td>Standing data</td>
                            </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Thêm tệp JS của Bootstrap, Popper.js, và jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2Xof8/J6SOWBAeYa/6IE98J+6WKbQo5t47g" crossorigin="anonymous"></script>
</body>
</html>
