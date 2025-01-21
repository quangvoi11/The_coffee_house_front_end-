<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật nhân viên</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f2f5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        input, select {
            padding: 10px;
            margin-bottom: 20px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            font-size: 1.2em;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #34495e;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Cập nhật thông tin nhân viên</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['employee_id'])) {
            $employee_id = $_GET['employee_id'];

            $conn = new mysqli("localhost", "root", "", "the_coffee_house");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT employee_id, name, email, phone_number, position, salary, hire_date, image FROM employees WHERE employee_id = $employee_id";
            $result = $conn->query($sql);

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
        ?>
                <form action="update.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">

                    <label for="name">Họ và tên:</label>
                    <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>

                    <label for="phone_number">Số điện thoại:</label>
                    <input type="text" id="phone_number" name="phone_number" value="<?php echo $row['phone_number']; ?>" required>

                    <label for="position">Chức vụ:</label>
                    <input type="text" id="position" name="position" value="<?php echo $row['position']; ?>" required>

                    <label for="salary">Lương:</label>
                    <input type="number" id="salary" name="salary" value="<?php echo $row['salary']; ?>" required>

                    <label for="hire_date">Ngày thuê:</label>
                    <input type="date" id="hire_date" name="hire_date" value="<?php echo $row['hire_date']; ?>" required>

                    <label for="employee_photo">Ảnh nhân viên:</label>
                    <input type="file" id="employee_photo" name="employee_photo" accept="image/*">

                    <button type="submit">Cập nhật</button>
                    <a href="manage_employees.php">Quay lại</a>
                </form>
        <?php
            } else {
                echo "Employee not found.";
            }
            $conn->close();
        } else {
            echo "Invalid request.";
        }
        ?>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $employee_id = $_POST['employee_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $position = $_POST['position'];
        $salary = $_POST['salary'];
        $hire_date = $_POST['hire_date'];

        $conn = new mysqli("localhost", "root", "", "the_coffee_house");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "UPDATE employees SET name='$name', email='$email', phone_number='$phone_number', position='$position', salary='$salary', hire_date='$hire_date' WHERE employee_id=$employee_id";

        if ($conn->query($sql) === TRUE) {
            if (isset($_FILES['employee_photo']) && $_FILES['employee_photo']['error'] == 0) {
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

                
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }

               
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
             
                } else {
                    if (move_uploaded_file($_FILES["employee_photo"]["tmp_name"], $target_file)) {
                        $image = basename($_FILES["employee_photo"]["name"]);
                        $sql = "UPDATE employees SET image='$image' WHERE employee_id=$employee_id";
                        if ($conn->query($sql) !== TRUE) {
                            echo "Error updating employee image: " . $conn->error;
                        }
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
            echo "Employee updated successfully";
        } else {
            echo "Error updating employee: " . $conn->error;
        }

        $conn->close();

        header("Location: manage_employees.php");
        exit();
    }
    ?>
</body>

</html>
