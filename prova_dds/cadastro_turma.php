<?php
session_start();
if (!isset($_SESSION['professor_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_turma = $_POST['nome_turma'];
    $professor_id = $_SESSION['professor_id'];

    $conn = new mysqli('localhost', 'root', '', 'tb_escola');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Proteção contra SQL Injection
    $nome_turma = $conn->real_escape_string($nome_turma);

    $sql = "INSERT INTO turmas (nome, professor_id) VALUES ('$nome_turma', $professor_id)";
    if ($conn->query($sql) === TRUE) {
        $sucesso = "Turma cadastrada com sucesso!";
    } else {
        $erro = "Erro ao cadastrar a turma: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Turma</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="content">
        <h1>Cadastrar Turma</h1>
        <form method="post" action="">
            <label>Nome da Turma:</label>
            <input type="text" name="nome_turma" required>
            <button type="submit">Cadastrar</button>
            <?php if (isset($sucesso)): ?>
                <p class="message success"><?php echo $sucesso; ?></p>
            <?php endif; ?>
            <?php if (isset($erro)): ?>
                <p class="message error"><?php echo $erro; ?></p>
            <?php endif; ?>
        </form>
        <button class="logout-button" onclick="window.location.href='professor_dashboard.php'">Voltar</button>
    </div>
</body>
</html>
