<?php
session_start();
if (!isset($_SESSION['professor_id'])) {
    header('Location: login.php');
    exit;
}

$professor_id = $_SESSION['professor_id'];
$professor_nome = $_SESSION['professor_nome'];

$conn = new mysqli('localhost', 'root', '', 'tb_escola');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$turmas_sql = "SELECT * FROM turmas WHERE professor_id = $professor_id";
$turmas_result = $conn->query($turmas_sql);

$alunos_sql = "SELECT * FROM alunos";
$alunos_result = $conn->query($alunos_sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Professor</title>
    <link rel="stylesheet" type="text/css" href="css/professor_dashboard.css">
</head>
<body>
    <div class="content">
        <h1>Bem-vindo, <?php echo $professor_nome; ?></h1>
        <button class="logout-button" onclick="window.location.href='logout.php'">Sair</button>
        <button onclick="window.location.href='cadastro_turma.php'">Cadastrar Turma</button>
        <button onclick="window.location.href='cadastro_aluno.php'">Cadastrar Criança</button>
        
        <h2>Suas Turmas</h2>
        <table>
            <tr>
                <th>Número da Turma</th>
                <th>Nome da Turma</th>
                <th>Atividades</th>
                <th>Ações</th>
            </tr>
            <?php while($turma = $turmas_result->fetch_assoc()): ?>
                <tr>
                    <td data-label="Número da Turma"><?php echo $turma['id']; ?></td>
                    <td data-label="Nome da Turma"><?php echo $turma['nome']; ?></td>
                    <td data-label="Atividades">
                        <?php
                        $atividades_sql = "SELECT * FROM atividades WHERE turma_id = " . $turma['id'];
                        $atividades_result = $conn->query($atividades_sql);
                        if ($atividades_result->num_rows > 0) {
                            while ($atividade = $atividades_result->fetch_assoc()) {
                                echo '<p>' . $atividade['descricao'] . '</p>';
                            }
                        } else {
                            echo '<p>Nenhuma atividade cadastrada</p>';
                        }
                        ?>
                    </td>
                    <td data-label="Ações">
                        <button onclick="confirmExclusaoTurma(<?php echo $turma['id']; ?>)">Excluir</button>
                        <button onclick="window.location.href='cadastro_atividade.php?turma_id=<?php echo $turma['id']; ?>'">Cadastrar Atividade</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <h2>Crianças Cadastradas</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF do reposavel</th>
                <th>Email do responsavel</th>
                <th>Telefone do responsavel</th>
                <th>Ações</th>
            </tr>
            <?php while($aluno = $alunos_result->fetch_assoc()): ?>
                <tr>
                    <td data-label="ID"><?php echo $aluno['id']; ?></td>
                    <td data-label="Nome"><?php echo $aluno['nome']; ?></td>
                    <td data-label="CPF"><?php echo $aluno['cpf']; ?></td>
                    <td data-label="Email"><?php echo $aluno['email']; ?></td>
                    <td data-label="Telefone"><?php echo $aluno['telefone']; ?></td>
                    <td data-label="Ações">
                        <button onclick="confirmExclusaoAluno(<?php echo $aluno['id']; ?>)">Excluir</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <script>
        function confirmExclusaoTurma(turmaId) {
            if (confirm('Você realmente quer excluir a turma?')) {
                window.location.href = 'excluir_turma.php?turma_id=' + turmaId;
            }
        }

        function confirmExclusaoAluno(alunoId) {
            if (confirm('Você realmente quer excluir a criança?')) {
                window.location.href = 'excluir_aluno.php?aluno_id=' + alunoId;
            }
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
