<?php
// Database connection settings
$dsn = 'oci:dbname=//199.212.26.208:1521/SQLD';
$user = 'COMP214_M24_ers_1';
$pass = 'password';

// Create PDO connection
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Fetch job titles
function fetchJobTitles($pdo) {
    $sql = 'SELECT JOB_ID, JOB_TITLE FROM HR_JOBS';
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch managers
function fetchManagers($pdo) {
    $sql = 'SELECT EMPLOYEE_ID, FIRST_NAME || \' \' || LAST_NAME AS MANAGER_NAME FROM HR_EMPLOYEES WHERE JOB_ID IN (\'SA_MAN\', \'FI_ACCOUNT\')';
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch departments
function fetchDepartments($pdo) {
    $sql = 'SELECT DEPARTMENT_ID, DEPARTMENT_NAME FROM HR_DEPARTMENTS';
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Output data as JSON
$data = [
    'jobs' => fetchJobTitles($pdo),
    'managers' => fetchManagers($pdo),
    'departments' => fetchDepartments($pdo),
];

header('Content-Type: application/json');
echo json_encode($data);

// Close connection (PDO does not require explicit closing, but you can set it to null if you want to close it explicitly)
$pdo = null;
?>
