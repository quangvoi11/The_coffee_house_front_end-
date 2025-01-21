<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm nhân viên</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 600px;
            width: 100%;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h3 {
            font-size: 1.8em;
            margin-bottom: 20px;
            color: #2c3e50;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 1em;
            margin-bottom: 5px;
            color: #333;
        }

        input, select {
            padding: 12px;
            margin-bottom: 20px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fafafa;
            transition: border-color 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #2c3e50;
            outline: none;
        }

        button, .back-link {
            padding: 12px;
            font-size: 1em;
            text-align: center;
            color: white;
            background-color: #2c3e50;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        button:hover, .back-link:hover {
            background-color: #34495e;
        }

        .back-link {
            display: inline-block;
            margin-top: 10px;
            background-color: #34495e;
        }

        .back-link:hover {
            background-color: #95a5a6;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>Thêm nhân viên mới</h3>
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">

            <label for="name">Họ và tên:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone_number">Số điện thoại:</label>
            <input type="text" id="phone_number" name="phone_number" required>

            <label for="position">Chức vụ:</label>
            <input type="text" id="position" name="position" required>

            <label for="salary">Lương:</label>
            <input type="text" id="salary" name="salary" value="1000.00" required>

            <label for="hire_date">Ngày thuê:</label>
            <input type="date" id="hire_date" name="hire_date" required>

            <label for="employee_photo">Ảnh nhân viên:</label>
            <input type="file" id="employee_photo" name="employee_photo" accept="image/*" required>

            <br>
            <button type="submit">Thêm nhân viên</button>
            <a href="manage_employees.php" class="back-link">Quay lại</a>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "the_coffee_house";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $position = $_POST['position'];
        $salary = $_POST['salary'];
        $hire_date = $_POST['hire_date'];

        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES["employee_photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        
        $check = getimagesize($_FILES["employee_photo"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

      
        if ($_FILES["employee_photo"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

       
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["employee_photo"]["tmp_name"], $target_file)) {
                $image = basename($_FILES["employee_photo"]["name"]);

                $sql = "INSERT INTO employees (name, email, phone_number, position, salary, hire_date, image, created_at, updated_at)
                        VALUES ('$name', '$email', '$phone_number', '$position', '$salary', '$hire_date', '$image', NOW(), NOW())";

                if ($conn->query($sql) === TRUE) {
                    echo '<p>Nhân viên mới đã được thêm thành công!</p>';
                } else {
                    echo '<p>Lỗi khi thêm nhân viên: ' . $conn->error . '</p>';
                }
            } else {
                echo "Đã xảy ra lỗi.";
            }
        }

        $conn->close();
    }
    ?>
</body>

</html>
