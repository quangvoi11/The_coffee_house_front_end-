<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đánh giá hiệu suất nhân viên</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f2f5;
        }

        .container {
            width: 80%;
            max-width: 600px;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 1.1em;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .btn-submit {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1em;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #34495e;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Đánh giá hiệu suất nhân viên</h2>
        <form action="process_evaluation.php" method="POST">
            <div class="form-group">
                <label for="employee_id">Mã nhân viên:</label>
                <input type="text" id="employee_id" name="employee_id" value="<?php echo isset($_GET['employee_id']) ? $_GET['employee_id'] : ''; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="name">Tên nhân viên:</label>
                <input type="text" id="name" name="name" value="<?php echo isset($_GET['name']) ? $_GET['name'] : ''; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="performance_score">Đánh giá hiệu suất:</label>
                <select id="performance_score" name="performance_score" required>
                    <option value="">Chọn đánh giá...</option>
                    <option value="1">1-Tệ</option>
                    <option value="2">2-Trung bình</option>
                    <option value="3">3-Khá</option>
                    <option value="4">4-Tốt</option>
                    <option value="5">5-Xuất sắc</option>
                </select>
            </div>
            <div class="form-group">
                <label for="feedback">Nhận xét:</label>
                <textarea id="feedback" name="feedback" required></textarea>
            </div>
            <button type="submit" class="btn-submit">Đánh giá</button>
        </form>
    </div>
</body>

</html>
