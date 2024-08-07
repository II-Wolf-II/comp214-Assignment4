<?php
// Database connection settings
$host = '199.212.26.208';
$port = '1521';
$sid = 'SQLD';
$user = 'COMP214_M24_ers_1';
$pass = 'password';

try {
    // Create connection
    $conn = new PDO("oci:dbname=//$host:$port/$sid", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare update statements
    $updateEmailStmt = $conn->prepare("UPDATE HR_EMPLOYEES SET EMAIL = :email WHERE EMPLOYEE_ID = :employee_id");
    $updatePhoneStmt = $conn->prepare("UPDATE HR_EMPLOYEES SET PHONE_NUMBER = :phone WHERE EMPLOYEE_ID = :employee_id");
    $updateSalaryStmt = $conn->prepare("UPDATE HR_EMPLOYEES SET SALARY = :salary WHERE EMPLOYEE_ID = :employee_id");

    // Execute email updates
    if (!empty($_POST['email'])) {
        foreach ($_POST['email'] as $employeeId => $email) {
            $updateEmailStmt->bindParam(':email', $email);
            $updateEmailStmt->bindParam(':employee_id', $employeeId);
            $updateEmailStmt->execute();
        }
    }

    // Execute phone updates
    if (!empty($_POST['phone'])) {
        foreach ($_POST['phone'] as $employeeId => $phone) {
            $updatePhoneStmt->bindParam(':phone', $phone);
            $updatePhoneStmt->bindParam(':employee_id', $employeeId);
            $updatePhoneStmt->execute();
        }
    }

    // Execute salary updates
    if (!empty($_POST['salary'])) {
        foreach ($_POST['salary'] as $employeeId => $salary) {
            $updateSalaryStmt->bindParam(':salary', $salary);
            $updateSalaryStmt->bindParam(':employee_id', $employeeId);
            $updateSalaryStmt->execute();
        }
    }

    echo "Employee records updated successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;
?>
