<?php
session_start();
if (!isset($_SESSION['professor_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['turma_id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data_aplicacao = $_POST['data_aplicacao'];
    $turma_id = $_GET['turma_id'];

    $conn = new mysqli('localhost', 'root', '', 'tb_escola');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $titulo = $conn->real_escape_string($titulo);
    $descricao = $conn->real_escape_string($descricao);
    $data_aplicacao = $conn->real_escape_string($data_aplicacao);

    $sql = "INSERT INTO atividades (titulo, descricao, data_aplicacao, turma_id) VALUES ('$titulo', '$descricao', '$data_aplicacao', $turma_id)";
    if ($conn->query($sql) === TRUE) {
        header('Location: professor_dashboard.php');
    } else {
        echo "Erro ao cadastrar a atividade: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Atividade</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="content">
        <h1>Cadastrar Atividade</h1>
        <form method="post" action="">
            <label>Título da Atividade:</label>
            <input type="text" name="titulo" required>
            <br>
            <label>Descrição da Atividade:</label>
            <input type="text" name="descricao" required>
            <br>
            <label>Data de Aplicação:</label>
            <input type="date" name="data_aplicacao" required>
            <br>
            <button type="submit">Cadastrar</button>
        </form>
        <button class="logout-button" onclick="window.location.href='professor_dashboard.php'">Voltar</button>
    </div>
</body>
</html>
