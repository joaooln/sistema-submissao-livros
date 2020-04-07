<?php

if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if ($id) {
    //Pesquisar os dados da tabela adms_nivacs_pgs
    $result_livro_lib = "SELECT livro.id, livro.adms_sit_id
            FROM adms_livros livro
            WHERE livro.id='$id' LIMIT 1";
    $resultado_livro_lib = mysqli_query($conn, $result_livro_lib);

    //Retornou algum valor do banco de dados e acesso o IF, senão acessa o ELSe
    if (($resultado_livro_lib) AND ( $resultado_livro_lib->num_rows != 0)) {
        $row_livro_lib = mysqli_fetch_assoc($resultado_livro_lib);
        //Verificar o status da página e atribuir o inverso na variável status
        if ($row_livro_lib['adms_sit_id'] == 1) {
            $status = 2;
        } else {
            $status = 1;
        }

        //Liberar o acesso a página
        $result_niv_pg_up = "UPDATE adms_livros SET
                adms_sit_id='$status',
                modified=NOW()
                WHERE id='$id'";
        $resultado_niv_pg_up = mysqli_query($conn, $result_niv_pg_up);
        if (mysqli_affected_rows($conn)) {
            $alteracao = true;
        } else {
            $alteracao = false;
        }

        //Redirecionar o usuário
        if ($alteracao) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Livro editado com sucesso!</div>";
            $url_destino = pg . "/listar/list_livro";
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao editar o livro!</div>";
            $url_destino = pg . "/listar/list_livro";
            header("Location: $url_destino");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Livro não encontrado</div>";
        $url_destino = pg . "/listar/list_livro";
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/listar/list_niv_aces';
    header("Location: $url_destino");
}
