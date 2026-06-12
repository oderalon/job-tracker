<?php
require_once 'config.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'list':
            listJobs();
            break;
        case 'create':
            createJob();
            break;
        case 'update':
            updateJob();
            break;
        case 'delete':
            deleteJob();
            break;
        case 'stats':
            getStats();
            break;
        default:
            echo json_encode(['error' => 'Unknown action']);
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}

function listJobs() {
    global $db;
    $jobs = $db->query("SELECT * FROM jobs ORDER BY job_date DESC")->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($jobs);
}

function createJob() {
    global $db;
    $data = json_decode(file_get_contents('php://input'), true);
    
    $stmt = $db->prepare("
        INSERT INTO jobs (customer_name, customer_info, job_date, job_value, costs, amount_paid)
        VALUES (:customer_name, :customer_info, :job_date, :job_value, :costs, :amount_paid)
    ");
    
    $stmt->execute([
        ':customer_name' => $data['customer_name'],
        ':customer_info' => $data['customer_info'] ?? '',
        ':job_date' => $data['job_date'],
        ':job_value' => $data['job_value'],
        ':costs' => $data['costs'] ?? 0,
        ':amount_paid' => $data['amount_paid'] ?? 0
    ]);
    
    echo json_encode(['id' => $db->lastInsertId(), 'success' => true]);
}

function updateJob() {
    global $db;
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    
    $stmt = $db->prepare("
        UPDATE jobs SET
            customer_name = :customer_name,
            customer_info = :customer_info,
            job_date = :job_date,
            job_value = :job_value,
            costs = :costs,
            amount_paid = :amount_paid,
            updated_at = CURRENT_TIMESTAMP
        WHERE id = :id
    ");
    
    $stmt->execute([
        ':id' => $id,
        ':customer_name' => $data['customer_name'],
        ':customer_info' => $data['customer_info'] ?? '',
        ':job_date' => $data['job_date'],
        ':job_value' => $data['job_value'],
        ':costs' => $data['costs'] ?? 0,
        ':amount_paid' => $data['amount_paid'] ?? 0
    ]);
    
    echo json_encode(['success' => true]);
}

function deleteJob() {
    global $db;
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    
    $db->prepare("DELETE FROM jobs WHERE id = :id")->execute([':id' => $id]);
    echo json_encode(['success' => true]);
}

function getStats() {
    global $db;
    
    $result = $db->query("
        SELECT
            COUNT(*) as total_jobs,
            SUM(job_value) as total_value,
            SUM(costs) as total_costs,
            SUM(amount_paid) as total_paid,
            SUM(job_value) - SUM(costs) as total_profit,
            SUM(job_value) - SUM(amount_paid) as total_outstanding
        FROM jobs
    ")->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode($result);
}
?>
