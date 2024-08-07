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

// Fetch employee data
function fetchEmployees($conn) {
    $sql = 'SELECT EMPLOYEE_ID, FIRST_NAME, LAST_NAME, EMAIL, PHONE_NUMBER, SALARY FROM HR_EMPLOYEES';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Output employee data
$employees = fetchEmployees($conn);

// Close connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Update Form</title>
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
        <h1>Update Employee Records</h1>
        <form action="employee_update_handler.php" method="POST">
            <table>
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Salary</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($employee['EMPLOYEE_ID']); ?></td>
                        <td><?php echo htmlspecialchars($employee['FIRST_NAME']); ?></td>
                        <td><?php echo htmlspecialchars($employee['LAST_NAME']); ?></td>
                        <td><input type="text" name="email[<?php echo htmlspecialchars($employee['EMPLOYEE_ID']); ?>]" value="<?php echo htmlspecialchars($employee['EMAIL']); ?>"></td>
                        <td><input type="phone_number" name="phone[<?php echo htmlspecialchars($employee['EMPLOYEE_ID']); ?>]" value="<?php echo htmlspecialchars($employee['PHONE_NUMBER']); ?>"></td>
                        <td><input type="number" name="salary[<?php echo htmlspecialchars($employee['EMPLOYEE_ID']); ?>]" step="0.01" value="<?php echo htmlspecialchars($employee['SALARY']); ?>"></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="buttons">
                <button type="submit" class="submit-button">Update</button>
                <button type="button" class="cancel-button" onclick="window.location.href='employee_main_menu.html'">Cancel</button>
                <button type="button" class="back-button" onclick="window.location.href='../index.html'">Back to Main Menu</button>
            </div>
        </form>
    </div>
</body>
</html>
