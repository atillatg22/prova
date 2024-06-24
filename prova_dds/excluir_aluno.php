<?php
session_start();
if (!isset($_SESSION['professor_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['aluno_id'])) {
    header('Location: professor_dashboard.php');
    exit;
}

$aluno_id = $_GET['aluno_id'];

$conn = new mysqli('localhost', 'root', '', 'tb_escola');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM alunos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $aluno_id);

if ($stmt->execute()) {
    header('Location: professor_dashboard.php');
} else {
    echo "Erro ao excluir o aluno: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
