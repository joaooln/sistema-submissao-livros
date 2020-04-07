<?php

include_once 'lib/lib_env_email.php';
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$SendAceite = filter_input(INPUT_POST, 'SendAceite', FILTER_SANITIZE_STRING);
if ($SendAceite) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if ($id == NULL) {
        $id = $dados['id'];
    }

    $result_artigo_aceite = "SELECT artigo.id, artigo.tituloLivro ,artigo.tituloArtigo,
            artigo.nomeCoautor1, artigo.nomeCoautor2, artigo.nomeCoautor3, artigo.nomeCoautor4,
            artigo.nomeCoautor5,  artigo.nomeCoautor6,  artigo.nomeCoautor7,  artigo.nomeCoautor8,
            artigo.nomeCoautor9,  artigo.nomeCoautor10,
            artigo.valor_livro, artigo.descri_valor_livro, artigo.data_publicacao_livro,
            artigo.adms_tp_subms_id, artigo.adms_livro_id, artigo.adms_sit_artigo_id, artigo.adms_usuario_id,
            livro.nome livro_nome, livro.data_publicacao livro_data,            
            user.nome nome_user, user.email
            FROM adms_artigos artigo
            LEFT JOIN adms_livros livro ON livro.id=artigo.adms_livro_id
            INNER JOIN adms_usuarios user ON user.id=artigo.adms_usuario_id
            WHERE artigo.id=" . $dados['id'] . " LIMIT 1";
    $resultado_artigo_aceite = mysqli_query($conn, $result_artigo_aceite);

    //Retornou algum valor do banco de dados e acesso o IF, senão acessa o ELSe
    if (($resultado_artigo_aceite) AND ( $resultado_artigo_aceite->num_rows != 0)) {
        $row_artigo_aceite = mysqli_fetch_assoc($resultado_artigo_aceite);
        //Verificar se o artigo está em status 1 - em avaliação
        if ($row_artigo_aceite['adms_sit_artigo_id'] == 1) {
            $status = 2;
        }
        //Atualiza o Status
        if ($row_artigo_aceite['adms_tp_subms_id'] == 1) {
            $result_artigo_aceite_up = "UPDATE adms_artigos SET
                adms_sit_artigo_id='$status',
                modified=NOW()
                WHERE id='$id'";
        } elseif ($row_artigo_aceite['adms_tp_subms_id'] == 2) {
            $result_artigo_aceite_up = "UPDATE adms_artigos SET
                valor_livro = '" . $dados['valor_livro'] . "',
                descri_valor_livro = '" . $dados['descri_valor_livro'] . "',
                data_publicacao_livro = '" . $dados['data_publicacao_livro'] . "',
                adms_sit_artigo_id='$status',
                modified=NOW()
                WHERE id='$id'";
        }
        $resultado_artigo_aceite_up = mysqli_query($conn, $result_artigo_aceite_up);
        if (mysqli_affected_rows($conn)) {
            $alteracao = true;
        } else {
            $alteracao = false;
        }

        //Redirecionar o usuário
        if ($alteracao) {
            if ($row_artigo_aceite['adms_livro_id'] == 1) {
                $tituloLivro = $row_artigo_aceite['tituloLivro'];
            } else {
                $tituloLivro = $row_artigo_aceite['livro_nome'];
            }

            $nome = explode(" ", $row_artigo_aceite['nome_user']);
            $prim_nome = $nome[0];

            $autores = $prim_nome;
            for ($index = 1; $index <= 10; $index++) {
                if ($row_artigo_aceite['nomeCoautor' . $index] != "") {
                    $autores .= ", " . $row_artigo_aceite['nomeCoautor' . $index];
                }
            }

            $assunto = "Carta Aceite";

            $mensagem = "<p><strong><img style='display: block; margin-left: auto; margin-right: auto;' src='https://i1.wp.com/sseditora.com.br/wp-content/uploads/sseditora-1.png' width='290' height='112' /></strong></p>"
                    . "<br>"
                    . "<p style='text-align: center;'><span style='font-size: 24px;'><strong><span style='font-family: Arial, Helvetica, sans-serif;'>CARTA ACEITE</span></strong></span></p>"
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
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Após a avaliação técnico científica pelos pares, os membros do Conselho Editorial desta editora, tem a honra de informar que o capítulo de livro intitulado "
                    . "<strong>“"
                    . $row_artigo_aceite['tituloArtigo']
                    . "”</strong>"
                    . " de autoria de <strong> “"
                    . $row_artigo_aceite['nome_user'] . $autores
                    . ""
                    . "”</strong>"
                    . ", foi <strong>aceito</strong> e encontra-se no prelo para publicação no livro eletrônico <strong>“"
                    . $tituloLivro
                    . "”</strong> em "
                    . strftime('%d de %B de %Y', strtotime($row_artigo_aceite['livro_data']))
                    . ".<br>"
                    . "</p>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Agradeço a escolha pela Stricto Sensu Editora como meio de publicação e parabenizo os autores pelo aceite.</span></span>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>Prof.ª Msc.ª Naila Fernanda S. P. Meneguetti</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'><strong>Editora Geral Stricto Sensu Editora</strong></span></span></p>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'line-height: 1;'><span style = 'font-size: 10px;'><span style = 'font-family: Arial, Helvetica, sans-serif;'>"
                    . "Stricto Sensu Editora - CNPJ: 32.249.055/0001-26<br>Avenida Recanto Verde, 213, Conjunto Mariana<br>Rio Branco – AC – CEP: 69919-182<br>Site: www.sseditora.com.br<br>E-mail: edgeral@sseditora.com.br<br>Prefixos Editoriais: ISBN 80261<br>DOI 10.35170"
                    . "</span></span></p >";

            $mensagem_livro = "<p><strong><img style='display: block; margin-left: auto; margin-right: auto;' src='https://i1.wp.com/sseditora.com.br/wp-content/uploads/sseditora-1.png' width='290' height='112' /></strong></p>"
                    . "<br>"
                    . "<p style='text-align: center;'><span style='font-size: 24px;'><strong><span style='font-family: Arial, Helvetica, sans-serif;'>CARTA ACEITE</span></strong></span></p>"
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
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Após a avaliação técnico científica pelos pares, os membros do Conselho Editorial desta editora, tem a honra de informar que o livro intitulado "
                    . "<strong>“"
                    . $row_artigo_aceite['tituloLivro']
                    . "”</strong>"
                    . " de autoria de <strong> “"
                    . $row_artigo_aceite['nome_user'] . $autores
                    . ""
                    . "”</strong>"
                    . ", foi <strong>aceito</strong> e encontra-se no prelo para publicação em nosso site"
                    . " em "
                    . strftime('%d de %B de %Y', strtotime($row_artigo_aceite['data_publicacao_livro']))
                    . ".<br>"
                    . "</p>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Agradeço a escolha pela Stricto Sensu Editora como meio de publicação e parabenizo os autores pelo aceite.</span></span>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>Prof.ª Msc.ª Naila Fernanda S. P. Meneguetti</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'><strong>Editora Geral Stricto Sensu Editora</strong></span></span></p>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'line-height: 1;'><span style = 'font-size: 10px;'><span style = 'font-family: Arial, Helvetica, sans-serif;'>"
                    . "Stricto Sensu Editora - CNPJ: 32.249.055/0001-26<br>Avenida Recanto Verde, 213, Conjunto Mariana<br>Rio Branco – AC – CEP: 69919-182<br>Site: www.sseditora.com.br<br>E-mail: edgeral@sseditora.com.br<br>Prefixos Editoriais: ISBN 80261<br>DOI 10.35170"
                    . "</span></span></p >";

            $mensagem_texto = "CARTA ACEITE<br><br>";
            $mensagem_texto .= "Após a avaliação técnico científica pelos pares, os membros do Conselho Editorial desta editora, tem a honra de informar que o capítulo de livro intitulado "
                    . "'" . $row_artigo_aceite['tituloArtigo'] . "'"
                    . " de autoria de "
                    . "'" . $row_artigo_aceite['nome_user'] . $autores . "'"
                    . " foi aceito e encontra-se no prelo para publicação no livro eletrônico "
                    . "'" . $tituloLivro . "'"
                    . strftime('%d de %B de %Y', strtotime($row_artigo_aceite['livro_data']))
                    . ".<br>"
                    . "Agradeço a escolha pela Stricto Sensu Editora como meio de publicação e parabenizo os autores pelo aceite.<br><br>"
                    . "Prof.ª Msc.ª Naila Fernanda S. P. Meneguetti<br>"
                    . "Editora Geral Stricto Sensu Editora<br>";

            $mensagem_texto_livro .= "Após a avaliação técnico científica pelos pares, os membros do Conselho Editorial desta editora, tem a honra de informar que o livro intitulado "
                    . "'" . $row_artigo_aceite['tituloLivro'] . "'"
                    . " de autoria de "
                    . "'" . $row_artigo_aceite['nome_user'] . $autores . "'"
                    . " foi aceito e encontra-se no prelo para publicação no nosso site "
                    . "em "
                    . strftime('%d de %B de %Y', strtotime($row_artigo_aceite['data_publicacao_livro']))
                    . ".<br>"
                    . "Agradeço a escolha pela Stricto Sensu Editora como meio de publicação e parabenizo os autores pelo aceite.<br><br>"
                    . "Prof.ª Msc.ª Naila Fernanda S. P. Meneguetti<br>"
                    . "Editora Geral Stricto Sensu Editora<br>";

            if ($row_artigo_aceite['adms_tp_subms_id'] == 1) {
                email_phpmailer($assunto, $mensagem, $mensagem_texto, $prim_nome, $row_artigo_aceite['email'], $conn);
            } elseif ($row_artigo_aceite['adms_tp_subms_id'] == 2) {
                email_phpmailer($assunto, $mensagem_livro, $mensagem_texto_livro, $prim_nome, $row_artigo_aceite['email'], $conn);
            }


            $assunto_pg = "Informação para Pagamento";

            $mensagem_pg = "<p><strong><img style='display: block; margin-left: auto; margin-right: auto;' src='https://i1.wp.com/sseditora.com.br/wp-content/uploads/sseditora-1.png' width='290' height='112' /></strong></p>"
                    . "<br>"
                    . "<p style='text-align: center;'><span style='font-size: 24px;'><strong><span style='font-family: Arial, Helvetica, sans-serif;'>INFORMAÇÃO PARA PAGAMENTO</span></strong></span></p>"
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
                    . "</p>"
                    . "<p style = 'text-align: justify; line-height: 1.5;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Informamos que seu artigo intitulado:  "
                    . "<strong>“"
                    . $row_artigo_aceite['tituloArtigo']
                    . "”</strong>"
                    . " de autoria de <strong> “"
                    . $row_artigo_aceite['nome_user'] . $autores
                    . ""
                    . "”</strong>"
                    . ", do livro eletrônico <strong>“"
                    . $tituloLivro
                    . "”</strong>"
                    . ". Já encontra-se disponível para pagamento na área do autor, segue link abaixo. Lembrando que seu artigo só será publicado mediante pagamento."
                    . "<br>"
                    . "</span></span></p>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                    . "https://areadoautor.sseditora.com.br/"
                    . "</span></span>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>Prof.ª Msc.ª Naila Fernanda S. P. Meneguetti</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'><strong>Editora Geral Stricto Sensu Editora</strong></span></span></p>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'line-height: 1;'><span style = 'font-size: 10px;'><span style = 'font-family: Arial, Helvetica, sans-serif;'>"
                    . "Stricto Sensu Editora - CNPJ: 32.249.055/0001-26<br>Avenida Recanto Verde, 213, Conjunto Mariana<br>Rio Branco – AC – CEP: 69919-182<br>Site: www.sseditora.com.br<br>E-mail: edgeral@sseditora.com.br<br>Prefixos Editoriais: ISBN 80261<br>DOI 10.35170"
                    . "</span></span></p >";

            $mensagem_pg_livro = "<p><strong><img style='display: block; margin-left: auto; margin-right: auto;' src='https://i1.wp.com/sseditora.com.br/wp-content/uploads/sseditora-1.png' width='290' height='112' /></strong></p>"
                    . "<br>"
                    . "<p style='text-align: center;'><span style='font-size: 24px;'><strong><span style='font-family: Arial, Helvetica, sans-serif;'>INFORMAÇÃO PARA PAGAMENTO</span></strong></span></p>"
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
                    . "</p>"
                    . "<p style = 'text-align: justify; line-height: 1.5;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Informamos que seu livro intitulado:  "
                    . "<strong>“"
                    . $row_artigo_aceite['tituloLivro']
                    . "”</strong>"
                    . " após analise técnica, chegamos ao valor de: R$: <strong> “"
                    . $row_artigo_aceite['valor_livro']
                    . ""
                    . "”</strong>"
                    . ", sendo o valor descriminado com: <strong>“"
                    . $row_artigo_aceite['descri_valor_livro']
                    . "”</strong>"
                    . ". Já encontra-se disponível para pagamento na área do autor, segue link abaixo. Lembrando que seu livro só será publicado mediante pagamento."
                    . "<br>"
                    . "</span></span></p>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                    . "https://areadoautor.sseditora.com.br/"
                    . "</span></span>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>Prof.ª Msc.ª Naila Fernanda S. P. Meneguetti</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'><strong>Editora Geral Stricto Sensu Editora</strong></span></span></p>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'line-height: 1;'><span style = 'font-size: 10px;'><span style = 'font-family: Arial, Helvetica, sans-serif;'>"
                    . "Stricto Sensu Editora - CNPJ: 32.249.055/0001-26<br>Avenida Recanto Verde, 213, Conjunto Mariana<br>Rio Branco – AC – CEP: 69919-182<br>Site: www.sseditora.com.br<br>E-mail: edgeral@sseditora.com.br<br>Prefixos Editoriais: ISBN 80261<br>DOI 10.35170"
                    . "</span></span></p >";
            
            if ($row_artigo_aceite['adms_tp_subms_id'] == 1) {
                email_phpmailer($assunto_pg, $mensagem_pg, $mensagem_texto_pg, $prim_nome, $row_artigo_aceite['email'], $conn);
            } elseif ($row_artigo_aceite['adms_tp_subms_id'] == 2) {
                email_phpmailer($assunto_pg, $mensagem_pg_livro, $mensagem_texto_pg_livro, $prim_nome, $row_artigo_aceite['email'], $conn);
            }

            $_SESSION['msg'] = "<div class='alert alert-success'>Aceite efetuado em sucesso!</div>";
            $url_destino = pg . "/listar/list_artigo_adm";
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao efetuar o Aceite!</div>";
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
