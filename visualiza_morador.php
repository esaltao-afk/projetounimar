<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moradores Cadastrados</title>
    <link rel="stylesheet" href="formulario.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 id="titulo">Moradores Cadastrados</h1>

        <table border="4" class="table">
            <tr>
                <th>NOME</th>
                <th>SOBRENOME</th>
                <th>BLOCO</th>
                <th>APARTAMENTO</th>
                <th>TIPO</th>
                <th>AÇÕES</th>
            </tr>
            <?php
                require("conecta.php");

                $dados_select = mysqli_query($conn, "SELECT id, nome, sobrenome, bloco, apartamento, tipo FROM moradores");

                while($dado = mysqli_fetch_assoc($dados_select)) {
                    echo '<tr>';
                    echo '<td>'.$dado['nome'].'</td>';
                    echo '<td>'.$dado['sobrenome'].'</td>';
                    echo '<td>'.$dado['bloco'].'</td>';
                    echo '<td>'.$dado['apartamento'].'</td>';
                    echo '<td>'.ucfirst($dado['tipo']).'</td>';
                    echo '<td>
                            <a href="edit_morador.php?id='.$dado['id'].'" class="button-link"><input type="button" value="Editar" class="botao-small"></a>
                            <a href="#" class="button-link" onclick="return confirmDelete('.$dado['id'].')"><input type="button" value="Deletar" class="botao-small"></a>
                        </td>';
                    echo '</tr>';
                }
            ?>
        </table>
        <br />
        <a href="index.html" class="button-link"><input type="button" value="Voltar" class="botao"></a>
    </div>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Tem certeza?',
                text: "Você não poderá reverter esta ação!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, deletar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'processar.php?acao=deletar&id=' + id;
                }
            });
            return false;
        }
    </script>
</body>
</html>