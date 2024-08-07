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

// Begin transaction
$conn->beginTransaction();

// Prepare and execute update statements
if (!empty($_POST['department_name']) || !empty($_POST['manager_id']) || !empty($_POST['location_id'])) {
    foreach ($_POST['department_name'] as $departmentId => $departmentName) {
        $managerId = $_POST['manager_id'][$departmentId];
        $locationId = $_POST['location_id'][$departmentId];

        $sql = 'UPDATE HR_DEPARTMENTS SET DEPARTMENT_NAME = :department_name, MANAGER_ID = :manager_id, LOCATION_ID = :location_id WHERE DEPARTMENT_ID = :department_id';
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':department_name', $departmentName);
        $stmt->bindParam(':manager_id', $managerId);
        $stmt->bindParam(':location_id', $locationId);
        $stmt->bindParam(':department_id', $departmentId);
        $stmt->execute();
    }

    // Commit the transaction
    $conn->commit();

    echo "Department records updated successfully!";
} else {
    echo "No data to update.";
}

// Close connection
$conn = null;
?>
