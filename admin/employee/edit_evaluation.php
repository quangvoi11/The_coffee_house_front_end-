<?php

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: danhgia.php");
    exit();
}

$id = $_GET['id'];

$conn = new mysqli("localhost", "root", "", "the_coffee_house");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, employee_id, name, performance_score, feedback FROM employee_evaluations WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $employee_id = $row['employee_id'];
    $name = $row['name'];
    $performance_score = $row['performance_score'];
    $feedback = $row['feedback'];
} else {
    echo "No evaluation found with ID: $id";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa đánh giá hiệu suất nhân viên</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1em;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #34495e;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Chỉnh sửa đánh giá hiệu suất nhân viên</h2>
        <form action="update_evaluation.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="employee_id">Mã nhân viên:</label>
            <input type="text" id="employee_id" name="employee_id" value="<?php echo $employee_id; ?>" readonly>

            <label for="name">Họ và tên:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" readonly>

            <label for="performance_score">Điểm hiệu suất:</label>
            <input type="text" id="performance_score" name="performance_score" value="<?php echo $performance_score; ?>" required>

            <label for="feedback">Nhận xét:</label>
            <textarea id="feedback" name="feedback" rows="4" required><?php echo $feedback; ?></textarea>

            <input type="submit" value="Lưu">
        </form>
    </div>
</body>

</html>
