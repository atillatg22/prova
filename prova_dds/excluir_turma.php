<?php
session_start();
if (!isset($_SESSION['professor_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['turma_id'])) {
    header('Location: professor_dashboard.php');
    exit;
}

$turma_id = intval($_GET['turma_id']);
$conn = new mysqli('localhost', 'root', '', 'tb_escola');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$delete_atividades_sql = "DELETE FROM atividades WHERE turma_id = ?";
$stmt = $conn->prepare($delete_atividades_sql);
$stmt->bind_param("i", $turma_id);
$stmt->execute();
$stmt->close();

$delete_turma_sql = "DELETE FROM turmas WHERE id = ?";
$stmt = $conn->prepare($delete_turma_sql);
$stmt->bind_param("i", $turma_id);
$stmt->execute();
$stmt->close();

$conn->close();

header('Location: professor_dashboard.php');
exit;
?>
