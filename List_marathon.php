<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Marathon list</title>

    <!-- Thêm Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Style/General.css">
</head>
<body>
    <button onclick="goHome()">Back to Home</button>
    <!-- Hiển thị danh sách Marathon đã được tạo bởi admin -->
    <div class="container mt-4">
        <h2>Marathon List</h2>
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

        <!-- Form đăng ký Marathon -->
        <div class="mt-4">
            <h3>Register for Marathon</h3>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="marathon_id" class="form-label">Choose Marathon ID:</label>
                    <input type="text" class="form-control" name="marathon_id" placeholder="Enter Marathon ID" required>
                </div>
                <div class="mb-3">
                    <label for="user_id" class="form-label">User ID:</label>
                    <input type="text" class="form-control" name="user_id" placeholder="Enter User ID" required>
                </div>
                <div class="mb-3">
                    <label for="hotel" class="form-label">Choose hotel:</label>
                    <select class="form-select" name="hotel" required>
                        <option value="">-- Select --</option>
                        <option value="hotel1">Hotel Q</option>
                        <option value="hotel2">Hotel U</option>
                        <option value="hotel3">Hotel A</option>
                        <option value="hotel4">Hotel N</option>
                        <option value="hotel5">Hotel G</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="Register_marathon">Register</button>
            </form>

            <?php
            if (isset($_POST['Register_marathon'])) {
                $marathon_id = $_POST['marathon_id'];
                $user_id = $_POST['user_id'];
                $hotel = $_POST['hotel'];

                // Kiểm tra xem user_id và marathon_id có tồn tại trong bảng users và marathon không
                $checkUser = mysqli_query($conn, "SELECT * FROM user_participants WHERE user_id = '$user_id'");
                $checkMarathon = mysqli_query($conn, "SELECT * FROM marathon WHERE marathon_id = '$marathon_id'");

                if (mysqli_num_rows($checkUser) > 0 && mysqli_num_rows($checkMarathon) > 0) {
                    // Thêm dữ liệu vào bảng participate
                    $sqlInsert = "INSERT INTO participate (marathon_id, user_id, hotel) VALUES ('$marathon_id', '$user_id', '$hotel')";
                    if (mysqli_query($conn, $sqlInsert)) {
                        echo '<div class="alert alert-success">Registration successful!</div>';
                    } else {
                        echo '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger">Invalid user_id or marathon_id.</div>';
                }
            }
            ?>
        </div>
    </div>
    <!-- Thêm Bootstrap JS, Popper.js, và jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2Xof8/J6SOWBAeYa/6IE98J+6WKbQo5t47g" crossorigin="anonymous"></script>
</body>
<script src="Js/js.js"></script>
</html>
