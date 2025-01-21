<?php
$conn = new mysqli("localhost", "root", "", "the_coffee_house");

if ($conn->connect_error) {
    die("Connection failed: " . mysqli_connect_error());
}

$employee_id = isset($_POST['employee_id']) ? $_POST['employee_id'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$performance_score = isset($_POST['performance_score']) ? $_POST['performance_score'] : '';
$feedback = isset($_POST['feedback']) ? $_POST['feedback']: '';

$sql = "INSERT INTO employee_evaluations (employee_id, name, performance_score, feedback) 
        VALUES ('$employee_id', '$name', '$performance_score', '$feedback')";

if ($conn->query($sql) === TRUE) {
   
    header("Location: danhgia.php");
    exit();
} else {
    echo "Lỗi: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
