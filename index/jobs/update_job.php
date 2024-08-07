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

// Fetch all jobs
function fetchJobs($conn) {
    $sql = 'SELECT JOB_ID, JOB_TITLE, MIN_SALARY, MAX_SALARY FROM HR_JOBS';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Update job details
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['job_id'])) {
    $job_id = $_POST['job_id'];
    $job_title = $_POST['job_title'];
    $min_salary = $_POST['min_salary'];
    $max_salary = $_POST['max_salary'];

    $sql = 'UPDATE HR_JOBS
            SET JOB_TITLE = :job_title,
                MIN_SALARY = :min_salary,
                MAX_SALARY = :max_salary
            WHERE JOB_ID = :job_id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':job_id', $job_id);
    $stmt->bindParam(':job_title', $job_title);
    $stmt->bindParam(':min_salary', $min_salary);
    $stmt->bindParam(':max_salary', $max_salary);
    $stmt->execute();

    // Commit the transaction
    $conn->commit();
}

// Fetch job data
$jobs = fetchJobs($conn);

// Close connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Job Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
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
        <h1>Update Job Records</h1>
        <form method="POST" action="">
            <table>
                <thead>
                    <tr>
                        <th>Job ID</th>
                        <th>Job Title</th>
                        <th>Min Salary</th>
                        <th>Max Salary</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jobs as $job): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($job['JOB_ID']); ?></td>
                        <td><input type="text" name="job_title" value="<?php echo htmlspecialchars($job['JOB_TITLE']); ?>"></td>
                        <td><input type="number" name="min_salary" step="0.01" value="<?php echo htmlspecialchars($job['MIN_SALARY']); ?>"></td>
                        <td><input type="number" name="max_salary" step="0.01" value="<?php echo htmlspecialchars($job['MAX_SALARY']); ?>"></td>
                        <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($job['JOB_ID']); ?>">
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="buttons">
                <button type="submit" class="submit-button">Update</button>
                <button type="button" class="cancel-button" onclick="window.location.href='jobs_main_menu.html'">Cancel</button>
                <button type="button" class="back-button" onclick="window.location.href='../index.html'">Back to Main Menu</button>
            </div>
        </form>
    </div>
</body>
</html>
