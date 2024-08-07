<?php
// Database connection settings
$host = '199.212.26.208';
$port = '1521';
$sid = 'SQLD';
$user = 'COMP214_M24_ers_1';
$pass = 'password';

// Create connection
$conn = new PDO("oci:dbname=//$host:$port/$sid", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch department data
function fetchDepartments($conn) {
    $sql = 'SELECT DEPARTMENT_ID, DEPARTMENT_NAME, MANAGER_ID, LOCATION_ID FROM HR_DEPARTMENTS';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Output department data
$departments = fetchDepartments($conn);

// Close connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department List</title>
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
            margin-bottom: 20px;
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
        .cancel-button {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            color: #333;
        }
        .cancel-button:hover {
            background-color: #e2e6ea;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Department List</h1>
        <table>
            <thead>
                <tr>
                    <th>Department ID</th>
                    <th>Department Name</th>
                    <th>Manager ID</th>
                    <th>Location ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departments as $department): ?>
                <tr>
                    <td><?php echo htmlspecialchars($department['DEPARTMENT_ID']); ?></td>
                    <td><?php echo htmlspecialchars($department['DEPARTMENT_NAME']); ?></td>
                    <td><?php echo htmlspecialchars($department['MANAGER_ID']); ?></td>
                    <td><?php echo htmlspecialchars($department['LOCATION_ID']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="buttons">
                <button type="button" class="back-button" onclick="window.location.href='../index.html'">Back to Main Menu</button>
                <button type="button" class="cancel-button" onclick="window.location.href='departments.html'">Cancel</button>

            </div>
    </div>
</body>
</html>
