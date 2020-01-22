<?php

if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$SendRejeicao = filter_input(INPUT_POST, 'SendRejeicao', FILTER_SANITIZE_STRING);
//$motivo_rejeite = mysqli_real_escape_string($conn, $_POST['motivo_rejeicao']);
if ($SendRejeicao) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $result_artigo_aceite = "SELECT artigo.id, artigo.tituloLivro ,artigo.tituloArtigo, artigo.nomeCoautor1, artigo.nomeCoautor2, artigo.nomeCoautor3, artigo.nomeCoautor4, artigo.nomeCoautor5, motivo_rejeicao, artigo.adms_sit_artigo_id, artigo.adms_usuario_id, user.nome, user.email
            FROM adms_artigos artigo
            INNER JOIN adms_usuarios user ON user.id=artigo.adms_usuario_id            
            WHERE artigo.id='" . $dados['id'] . "' LIMIT 1";
    $resultado_artigo_aceite = mysqli_query($conn, $result_artigo_aceite);

    //Retornou algum valor do banco de dados e acesso o IF, senão acessa o ELSe
    if (($resultado_artigo_aceite) AND ( $resultado_artigo_aceite->num_rows != 0)) {
        $row_artigo_aceite = mysqli_fetch_assoc($resultado_artigo_aceite);
        //Verificar se o artigo está em status 1 - em avaliação
        if ($row_artigo_aceite['adms_sit_artigo_id'] == 1) {
            $status = 4;
        }
        //Atualiza o Status
        $result_artigo_aceite_up = "UPDATE adms_artigos SET
                adms_sit_artigo_id='$status', motivo_rejeicao='" . $dados['motivo_rejeicao'] . "',
                modified=NOW()
                WHERE id='" . $dados['id'] . "'";
        $resultado_artigo_aceite_up = mysqli_query($conn, $result_artigo_aceite_up);
        if (mysqli_affected_rows($conn)) {
            $alteracao = true;

            $autores = 0;
            for ($index = 1; $index <= 5; $index++) {
                if ($row_artigo_aceite['nomeCoautor' . $index] != "") {
                    $autores .= ", " . $row_artigo_aceite['nomeCoautor' . $index];
                }
            }

            $nome = explode(" ", $row_artigo_aceite['nome']);
            $prim_nome = $nome[0];

            $assunto = "Carta Aceite";

            $mensagem = "<p><strong><img style='display: block; margin-left: auto; margin-right: auto;' src='https://i1.wp.com/sseditora.com.br/wp-content/uploads/sseditora-1.png' width='290' height='112' /></strong></p>"
                    . "<br>"
                    . "<p style='text-align: center;'><span style='font-size: 24px;'><strong><span style='font-family: Arial, Helvetica, sans-serif;'>AVALIAÇÃO DE ARTIGO</span></strong></span></p>"
                    . "<p><span style='font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></p>"
                    . "<p><span style='font-family: Arial, Helvetica, sans-serif; font-size: 12px;'>"
                    . "Rio Branco, Acre, "
                    . strftime('%d de %B de %Y', strtotime('today'))
                    . ".</span></p>"
                    . "<br>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'text-align: justify; line-height: 1.5;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Após a avaliação técnico científica pelos pares, os membros do Conselho Editorial desta editora, informa que infelizmente o capítulo de livro intitulado "
                    . "<strong>“"
                    . $row_artigo_aceite['tituloArtigo']
                    . "”</strong>"
                    . " de autoria de <strong> “"
                    . $row_artigo_aceite['nome'] . $autores
                    . ""
                    . "”</strong>"
                    . ", foi <strong>rejeitado</strong> pelo seguinte motivo: <strong>“"
                    . $row_artigo_aceite['motivo_rejeicao']
                    . "”</strong>."
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'text-align: justify;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Agradeço a escolha pela Stricto Sensu Editora como meio de publicação.</span></span></p>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>Prof.ª Msc.ª Naila Fernanda S. P. Meneguetti</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'><strong>Editora Geral Stricto Sensu Editora</strong></span></span></p>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'line-height: 0.5;'><span style = 'font-size: 10px;'><span style = 'font-family: Arial, Helvetica, sans-serif;'>"
                    . "Stricto Sensu Editora - CNPJ: 32.249.055/0001-26<br>Avenida Recanto Verde, 213, Conjunto Mariana<br>Rio Branco – AC – CEP: 69919-182<br>Site: www.sseditora.com.br<br>E-mail: edgeral@sseditora.com.br<br>Prefixos Editoriais: ISBN 80261<br>DOI 10.35170"
                    . "</span></span></p >";

            $mensagem_texto = "AVALIAÇÃO DE ARTIGO<br><br>";
            $mensagem_texto .= "Após a avaliação técnico científica pelos pares, os membros do Conselho Editorial desta editora, informa que infelizmente o capítulo de livro intitulado "
                    . $row_artigo_aceite['tituloArtigo']
                    . " de autoria de "
                    . $row_artigo_aceite['nome'] . $autores
                    . ", foi rejeitado pelo seguinte motivo: "
                    . $row_artigo_aceite['motivo_rejeicao']
                    . ".<br>"
                    . "Agradeço a escolha pela Stricto Sensu Editora como meio de publicação.<br><br>"
                    . "Prof.ª Msc.ª Naila Fernanda S. P. Meneguetti<br>"
                    . "Editora Geral Stricto Sensu Editora<br>";


            (email_phpmailer($assunto, $mensagem, $mensagem_texto, $prim_nome, $row_artigo_aceite['email'], $conn));
        } else {
            $alteracao = false;
        }

        //Redirecionar o usuário
        if ($alteracao) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Artigo rejeitado com sucesso!</div>";
            $url_destino = pg . "/listar/list_artigo_adm";
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao efetuar o Rejeição!</div>";
            $url_destino = pg . "/listar/list_artigo_adm";
            header("Location: $url_destino");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Artigo não encontrado</div>";
        $url_destino = pg . "/listar/list_artigo_adm";
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/listar/list_artigo_adm';
    header("Location: $url_destino");
}
