<?php
$conn = new mysqli("localhost", "root", "", "the_coffee_house");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $name = $_POST['name'];
    $date = $_POST['date'];
    $hours_worked = $_POST['hours_worked'];

    $stmt_check = $conn->prepare("SELECT employee_id, salary FROM employees WHERE employee_id = ?");
    $stmt_check->bind_param("i", $employee_id);
    $stmt_check->execute();
    $stmt_check->store_result();
    $stmt_check->bind_result($employee_id_db, $base_salary);

    if ($stmt_check->num_rows == 0) {
        echo "<script>alert('Mã nhân viên không tồn tại');</script>";
    } else {
        $stmt_check->fetch();

        $stmt = $conn->prepare("INSERT INTO employee_work_hours (employee_id, name, date, hours_worked) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issd", $employee_id, $name, $date, $hours_worked);

        if ($stmt->execute()) {
            echo "<script>alert('Thêm thành công');</script>";

            $total_salary = $base_salary * $hours_worked;
           
            $stmt_salary_check = $conn->prepare("SELECT id FROM employee_salary WHERE employee_id = ? AND date = ?");
            $stmt_salary_check->bind_param("is", $employee_id, $date);
            $stmt_salary_check->execute();
            $stmt_salary_check->store_result();

            if ($stmt_salary_check->num_rows > 0) {
               
                $stmt_update_salary = $conn->prepare("UPDATE employee_salary SET hours_worked = ?, total_salary = ? WHERE employee_id = ? AND date = ?");
                $stmt_update_salary->bind_param("ddis", $hours_worked, $total_salary, $employee_id, $date);
                $stmt_update_salary->execute();
                $stmt_update_salary->close();
            } else {
                
                $stmt_insert_salary = $conn->prepare("INSERT INTO employee_salary (employee_id, name, date, salary, hours_worked, total_salary) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt_insert_salary->bind_param("issddd", $employee_id, $name, $date, $base_salary, $hours_worked, $total_salary);
                $stmt_insert_salary->execute();
                $stmt_insert_salary->close();
            }

            $stmt_salary_check->close();
        } else {
            echo "<script>alert('Thêm không thành công');</script>";
        }

        $stmt->close();
    }

    $stmt_check->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theo dõi giờ làm</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 1em;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #34495e;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            text-decoration: none;
            color: #2c3e50;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Thêm giờ làm việc nhân viên</h2>
        <form method="POST" action="add_hours.php">
            <label for="employee_id">Mã nhân viên:</label>
            <input type="number" id="employee_id" name="employee_id" value="<?php echo isset($_GET['employee_id']) ? $_GET['employee_id'] : ''; ?>" required>
            <label for="name">Họ và tên:</label>
            <input type="text" id="name" name="name" value="<?php echo isset($_GET['name']) ? $_GET['name'] : ''; ?>" required>
            <label for="date">Ngày làm việc:</label>
            <input type="date" id="date" name="date" required>
            <label for="hours_worked">Số giờ làm việc:</label>
            <input type="number" id="hours_worked" name="hours_worked" step="0.01" required>
            <button type="submit">Lưu giờ làm</button>
        </form>
        <div class="back-link">
            <a href="theodoi.php">Quay lại trang Theo dõi giờ làm</a>
        </div>
    </div>
</body>

</html>
