<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Thêm tệp CSS của Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1 class="mb-4">User Profile</h1>

    <form action="User_profile.php" method="GET" class="mb-4">
        <div class="mb-3">
            <label for="user_id" class="form-label">Enter User ID:</label>
            <input type="text" name="user_id" class="form-control" placeholder="Enter ID" required>
        </div>
        <button type="submit" class="btn btn-primary" name="Check_user_id">Check</button>
    </form>

    <?php
        // Kết nối đến cơ sở dữ liệu
        require_once "Database.php";

        // Kiểm tra xem đã truyền user_id vào URL hay chưa
        if (isset($_GET['user_id'])) {
            // Lấy user_id từ URL
            $user_id = $_GET['user_id'];

            // Chuẩn bị câu lệnh truy vấn SQL
            $sql = "SELECT * FROM user_participants WHERE user_id = ?";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt, "i", $user_id);
                mysqli_stmt_execute($stmt);
                
                // Lấy kết quả từ truy vấn
                $result = mysqli_stmt_get_result($stmt);

                if ($result) {
                    // Kiểm tra xem có dòng dữ liệu trả về không
                    if (mysqli_num_rows($result) > 0) {
                        // Lặp qua từng dòng dữ liệu
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Truy xuất thông tin người dùng từ dữ liệu $row
                            $fullname = $row['fullname'];
                            $bestrecord = $row['best_record'];
                            $nationality = $row['nationality'];
                            $passportNO = $row['passport'];
                            $sex = $row['sex'];
                            $age = $row['age'];
                            $email = $row['email'];
                            $phone = $row['phone'];
                            $address = $row['address'];

                            // Hiển thị thông tin người dùng với class của Bootstrap
                            echo "<h2 class='mb-4'>$fullname</h2>";
                            echo "<p><strong>Best Record:</strong> $bestrecord</p>";
                            echo "<p><strong>Nationality:</strong> $nationality</p>";
                            echo "<p><strong>Passport Number:</strong> $passportNO</p>";
                            echo "<p><strong>Sex:</strong> $sex</p>";
                            echo "<p><strong>Age:</strong> $age</p>";
                            echo "<p><strong>Email:</strong> $email</p>";
                            echo "<p><strong>Phone:</strong> $phone</p>";
                            echo "<p><strong>Address:</strong> $address</p>";
                        }
                    } else {
                        echo "<p class='text-danger'>User not found</p>";
                    }
                } else {
                    echo "<p class='text-danger'>Error executing query: " . mysqli_error($conn) . "</p>";
                }
            } else {
                echo "<p class='text-danger'>Error preparing statement: " . mysqli_error($conn) . "</p>";
            }

            // Đóng kết nối
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        } else {
            echo "<p class='text-danger'>Invalid user ID</p>";
        }
    ?>

    <!-- Thêm tệp JS của Bootstrap, Popper.js, và jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2Xof8/J6SOWBAeYa/6IE98J+6WKbQo5t47g" crossorigin="anonymous"></script>
</body>
</html>
