<?php
require("conecta.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // inputs
        $nome = trim($_POST['nome'] ?? '');
        $sobrenome = trim($_POST['sobrenome'] ?? '');
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $apartamento = trim($_POST['apartamento'] ?? '');
        $bloco = trim($_POST['bloco'] ?? '');
        $tipo = trim($_POST['tipo'] ?? '');
        $servicos = isset($_POST['servicos']) ? implode(', ', array_map('trim', $_POST['servicos'])) : '';
        $observacoes = trim($_POST['observacoes'] ?? '');
        
        // Validações básicas
        if (empty($nome) || empty($sobrenome) || empty($email) || empty($apartamento) || empty($bloco) || empty($tipo)) {
            throw new Exception("Todos os campos obrigatórios devem ser preenchidos");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido");
        }

        // Acão no cadastrar
        $acao = $_POST['acao'] ?? 'cadastrar';
        
        if ($acao == 'cadastrar') {
            $stmt = $conn->prepare("INSERT INTO moradores (nome, sobrenome, email, apartamento, bloco, tipo, servicos, observacoes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $nome, $sobrenome, $email, $apartamento, $bloco, $tipo, $servicos, $observacoes);
        } 
        else if ($acao == 'atualizar' && isset($_POST['id'])) {
            $id = $_POST['id'];
            $stmt = $conn->prepare("UPDATE moradores SET nome=?, sobrenome=?, email=?, apartamento=?, bloco=?, tipo=?, servicos=?, observacoes=? WHERE id=?");
            $stmt->bind_param("ssssssssi", $nome, $sobrenome, $email, $apartamento, $bloco, $tipo, $servicos, $observacoes, $id);
        }

        if (!$stmt->execute()) {
            throw new Exception("Erro ao executar operação: " . $stmt->error);
        }

        echo "success";
        $stmt->close();

    } catch (Exception $e) {
        error_log("Erro no processamento: " . $e->getMessage());
        echo "error: " . $e->getMessage();
    }
    $conn->close();
} 
// Delete da base
else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['acao']) && $_GET['acao'] == 'deletar' && isset($_GET['id'])) {
    try {
        $id = $_GET['id'];
        $stmt = $conn->prepare("DELETE FROM moradores WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            header("Location: visualiza_morador.php");
        } else {
            throw new Exception("Erro ao deletar registro");
        }
        $stmt->close();
    } catch (Exception $e) {
        error_log("Erro ao deletar: " . $e->getMessage());
        echo "error: " . $e->getMessage();
    }
    $conn->close();
}
?>
