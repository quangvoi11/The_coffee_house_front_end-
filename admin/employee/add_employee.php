<?php

$conn = new mysqli("localhost", "root", "", "the_coffee_house");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    
   
    $target_dir = "uploads/";
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
            $sql = "INSERT INTO employees (name, email, phone_number, position, salary, image) 
                    VALUES ('$name', '$email', '$phone_number', '$position', '$salary', '$image')";

            if ($conn->query($sql) === TRUE) {
                echo "New employee added successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>
