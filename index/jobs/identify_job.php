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

$job_title = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['job_id'])) {
    $job_id = $_POST['job_id'];

    // Fetch job title directly
    $sql = 'SELECT JOB_TITLE FROM HR_JOBS WHERE JOB_ID = :job_id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':job_id', $job_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $job_title = $result['JOB_TITLE'];
    } else {
        $job_title = 'No job found for the given JOB_ID';
    }
}

// Close connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identify Job Description</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Identify Job Description</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="job_id">Enter Job ID:</label>
                <input type="text" id="job_id" name="job_id" required>
            </div>
            <div class="form-group">
                <label for="job_title">Job Description:</label>
                <input type="text" id="job_title" name="job_title" value="<?php echo htmlspecialchars($job_title); ?>" readonly>
            </div>
            <div class="buttons">
                <button type="submit" class="submit-button">Submit</button>
                <button type="button" class="cancel-button" onclick="window.location.href='jobs_main_menu.html'">Cancel</button>
                <button type="button" class="back-button" onclick="window.location.href='../index.html'">Back to Main Menu</button>
        </form>
    </div>
</body>
</html>
