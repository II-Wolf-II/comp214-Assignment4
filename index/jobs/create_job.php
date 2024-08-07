<?php
// Database connection settings
$host = '199.212.26.208';
$port = '1521';
$sid = 'SQLD';
$user = 'COMP214_M24_ers_1';
$pass = 'password';

// Create connection using PDO
try {
    $conn = new PDO("oci:dbname=$host:$port/$sid", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $job_id = $_POST['job_id'];
    $job_title = $_POST['job_title'];
    $min_salary = $_POST['min_salary'];
    $max_salary = $_POST['max_salary'];

    // Call the PL/SQL procedure to insert the new job
    $sql = 'BEGIN new_job(:job_id, :job_title, :min_salary, :max_salary); END;';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':job_id', $job_id);
    $stmt->bindParam(':job_title', $job_title);
    $stmt->bindParam(':min_salary', $min_salary);
    $stmt->bindParam(':max_salary', $max_salary);
    $stmt->execute();

    // Close connection
    $conn = null;

    $message = "A new job has been created.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Job</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .buttons {
            text-align: center;
            margin-top: 20px;
        }
        .buttons button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .submit-button {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }
        .submit-button:hover {
            background-color: #0056b3;
        }
        .back-button {
            background-color: #6c757d;
            border: 1px solid #6c757d;
            color: white;
        }
        .back-button:hover {
            background-color: #5a6268;
        }
        .message {
            color: green;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create New Job</h1>
        <?php if (isset($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="job_id">Job ID</label>
                <input type="text" id="job_id" name="job_id" required>
            </div>
            <div class="form-group">
                <label for="job_title">Job Title</label>
                <input type="text" id="job_title" name="job_title" required>
            </div>
            <div class="form-group">
                <label for="min_salary">Minimum Salary</label>
                <input type="number" id="min_salary" name="min_salary" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="max_salary">Maximum Salary</label>
                <input type="number" id="max_salary" name="max_salary" step="0.01" required>
            </div>
            <div class="buttons">
                <button type="submit" class="submit-button">Create Job</button>
                <button type="button" class="cancel-button" onclick="window.location.href='jobs_main_menu.html'">Cancel</button>
                <button type="button" class="back-button" onclick="window.location.href='../index.html'">Back to Main Menu</button>
            </div>
        </form>
    </div>
</body>
</html>
