<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $conn = new mysqli('localhost', 'root', '', 'tb_escola');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($email);
    $senha = $conn->real_escape_string($senha);

    $sql = "SELECT * FROM professores WHERE email = '$email' AND senha = '$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $professor = $result->fetch_assoc();
        $_SESSION['professor_id'] = $professor['id'];
        $_SESSION['professor_nome'] = $professor['nome'];
        header('Location: professor_dashboard.php');
        exit;
    } else {
        $erro = "Email ou senha inválidos.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <form method="post" action="">
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Senha:</label>
        <input type="password" name="senha" required>
        <button type="submit">Entrar</button>
        <?php if (isset($erro)): ?>
            <p class="message"><?php echo $erro; ?></p>
        <?php endif; ?>
    </form>
</body>
</html>
