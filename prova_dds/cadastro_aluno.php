<?php
session_start();
if (!isset($_SESSION['professor_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    $conn = new mysqli('localhost', 'root', '', 'tb_escola');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO alunos (nome, cpf, email, telefone) VALUES ('$nome', '$cpf', '$email', '$telefone')";
    if ($conn->query($sql) === TRUE) {
        header('Location: professor_dashboard.php');
    } else {
        echo "Erro ao cadastrar o aluno: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Crianças</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="content">
        <h1>Cadastrar Crianças</h1>
        <form method="post" action="">
            <label>Nome:</label>
            <input type="text" name="nome" required>
            <label>CPF do responsavel:</label>
            <input type="text" name="cpf" required>
            <label>Email do responsavel:</label>
            <input type="email" name="email" required>
            <label>Telefone do responsavel:</label>
            <input type="text" name="telefone" required>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>
