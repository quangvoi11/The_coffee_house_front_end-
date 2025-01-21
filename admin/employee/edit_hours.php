<?php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $conn = new mysqli("localhost", "root", "", "the_coffee_house");
    if ($conn->connect_error) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $id = $_GET["id"];
    $sql = "SELECT id, employee_id, name, date, hours_worked FROM employee_work_hours WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Record not found.";
        $conn->close();
        exit();
    }
    $conn->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $conn = new mysqli("localhost", "root", "", "the_coffee_house");
    if ($conn->connect_error) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $id = $_POST["id"];
    $employee_id = $_POST["employee_id"];
    $name = $_POST["name"];
    $date = $_POST["date"];
    $hours_worked = $_POST["hours_worked"];

    $sql = "UPDATE employee_work_hours SET employee_id = '$employee_id', name = '$name', date = '$date', hours_worked = '$hours_worked' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
    header("Location: theodoi.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa giờ làm nhân viên</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #f0f2f5;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h3 {
            font-size: 1.5em;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 1em;
            border-radius: 5px;
        }
        button:hover {
            background-color: #34495e;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h3>Chỉnh sửa giờ làm việc</h3>
        <form action="edit_hours.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label for="employee_id">Mã nhân viên:</label>
            <input type="number" id="employee_id" name="employee_id" value="<?php echo $row['employee_id']; ?>" required><br>
            <label for="name">Họ và tên:</label>
            <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required><br>
            <label for="date">Ngày:</label>
            <input type="date" id="date" name="date" value="<?php echo $row['date']; ?>" required><br>
            <label for="hours_worked">Giờ làm việc:</label>
            <input type="number" step="0.01" id="hours_worked" name="hours_worked" value="<?php echo $row['hours_worked']; ?>" required><br>
            <button type="submit">Cập nhật</button>
        </form>
    </div>
</body>
</html>
