<?php
// Database connection settings
$dsn = 'oci:dbname=//199.212.26.208:1521/SQLD';
$user = 'COMP214_M24_ers_1';
$pass = 'password';

try {
    // Create PDO connection
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Retrieve form data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$hire_date = $_POST['hire_date'];
$salary = $_POST['salary'];
$job_id = $_POST['job_id'];
$manager_id = $_POST['manager_id'];
$department_id = $_POST['department_id'];

// Call stored procedure
try {
    $sql = 'BEGIN Employee_hire_sp(:p_first_name, :p_last_name, :p_email, :p_salary, :p_hire_date, :p_phone, :p_job_id, :p_manager_id, :p_department_id); END;';
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':p_first_name', $first_name);
    $stmt->bindParam(':p_last_name', $last_name);
    $stmt->bindParam(':p_email', $email);
    $stmt->bindParam(':p_salary', $salary);
    $stmt->bindParam(':p_hire_date', $hire_date);
    $stmt->bindParam(':p_phone', $phone);
    $stmt->bindParam(':p_job_id', $job_id);
    $stmt->bindParam(':p_manager_id', $manager_id);
    $stmt->bindParam(':p_department_id', $department_id);

    // Execute the stored procedure
    $stmt->execute();
    echo "Employee hired successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$pdo = null;
?>
