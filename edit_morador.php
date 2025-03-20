<?php
require("conecta.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM moradores WHERE id = $id");
    $morador = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Editar Morador</title>
    <link rel="stylesheet" href="formulario.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 id="titulo">Editar Informações</h1>
        <p id="subtitulo">Atualize as informações do morador</p>

        <form action="processar.php" method="post">
            <input type="hidden" name="acao" value="atualizar">
            <input type="hidden" name="id" value="<?php echo $morador['id']; ?>">
            
            <fieldset class="grupo">
                <div class="campo">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" value="<?php echo $morador['nome']; ?>" required>
                </div>
                <div class="campo">
                    <label for="sobrenome">Sobrenome</label>
                    <input type="text" name="sobrenome" id="sobrenome" value="<?php echo $morador['sobrenome']; ?>" required>
                </div>
            </fieldset>

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo $morador['email']; ?>" required>
            </div>

            <div class="campo">
                <label for="apartamento">Apartamento</label>
                <input type="text" name="apartamento" id="apartamento" value="<?php echo $morador['apartamento']; ?>" required>
            </div>

            <div class="campo">
                <label for="bloco">Bloco</label>
                <select id="bloco" name="bloco" required>
                    <option value="" disabled>Selecione</option>
                    <option value="A" <?php echo ($morador['bloco'] == 'A') ? 'selected' : ''; ?>>Bloco A</option>
                    <option value="B" <?php echo ($morador['bloco'] == 'B') ? 'selected' : ''; ?>>Bloco B</option>
                    <option value="C" <?php echo ($morador['bloco'] == 'C') ? 'selected' : ''; ?>>Bloco C</option>
                    <option value="D" <?php echo ($morador['bloco'] == 'D') ? 'selected' : ''; ?>>Bloco D</option>
                </select>
            </div>

            <div class="campo">
                <label>Tipo de Morador</label>
                <div class="radio-grupo">
                    <div class="radio-item">
                        <input type="radio" id="proprietario" name="tipo" value="proprietario" <?php echo ($morador['tipo'] == 'proprietario') ? 'checked' : ''; ?>>
                        <label for="proprietario">Proprietário</label>
                    </div>
                    <div class="radio-item">
                        <input type="radio" id="inquilino" name="tipo" value="inquilino" <?php echo ($morador['tipo'] == 'inquilino') ? 'checked' : ''; ?>>
                        <label for="inquilino">Inquilino</label>
                    </div>
                </div>
            </div>

            <fieldset class="grupo">
                <div class="campo">
                    <label>Serviços Contratados:</label>
                    <div class="checkbox-grupo">
                        <div class="checkbox-item">
                            <input type="checkbox" id="servico1" name="servicos[]" value="Garagem" <?php echo (strpos($morador['servicos'], 'Garagem') !== false) ? 'checked' : ''; ?>>
                            <label for="servico1">Garagem</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="servico2" name="servicos[]" value="Piscina" <?php echo (strpos($morador['servicos'], 'Piscina') !== false) ? 'checked' : ''; ?>>
                            <label for="servico2">Piscina</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="servico3" name="servicos[]" value="Salão de Festas" <?php echo (strpos($morador['servicos'], 'Salão de Festas') !== false) ? 'checked' : ''; ?>>
                            <label for="servico3">Salão de Festas</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="servico4" name="servicos[]" value="Academia" <?php echo (strpos($morador['servicos'], 'Academia') !== false) ? 'checked' : ''; ?>>
                            <label for="servico4">Academia</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="servico5" name="servicos[]" value="Churrasqueira" <?php echo (strpos($morador['servicos'], 'Churrasqueira') !== false) ? 'checked' : ''; ?>>
                            <label for="servico5">Churrasqueira</label>
                        </div>
                    </div>
                </div>
            </fieldset>

            <div class="campo">
                <label for="observacoes">Observações Adicionais:</label>
                <textarea id="observacoes" name="observacoes" rows="6"><?php echo $morador['observacoes']; ?></textarea>
            </div>

            <button class="botao" type="submit">Atualizar</button>
            <br><br>
            <a href="visualiza_morador.php" class="button-link"><input type="button" value="Cancelar" class="botao"></a>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'processar.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        if(response === 'success') {
                            Swal.fire({
                                title: 'Sucesso!',
                                text: 'Informações atualizadas com sucesso!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'visualiza_morador.php';
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Erro!',
                                text: 'Ocorreu um erro ao atualizar.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>