<?php

include_once 'lib/lib_env_email.php';
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
if (!isset($seg)) {
    exit;
}
$SendAceite = filter_input(INPUT_POST, 'SendAceite', FILTER_SANITIZE_STRING);

if ($SendAceite) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $result_artigo_aceite = "SELECT artigo.id, artigo.tituloLivro ,artigo.tituloArtigo,
            artigo.nomeCoautor1, artigo.nomeCoautor2, artigo.nomeCoautor3, artigo.nomeCoautor4,
            artigo.nomeCoautor5,  artigo.nomeCoautor6,  artigo.nomeCoautor7,  artigo.nomeCoautor8,
            artigo.nomeCoautor9,  artigo.nomeCoautor10, artigo.normas, artigo.data_validade,
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
        include_once 'lib/lib_valida.php';
        $dados['valor_livro'] = Valor($dados['valor_livro']);
        $data_validade = date('d/m/Y', strtotime('+15 days'));
        //Atualiza o Status
        if ($row_artigo_aceite['adms_tp_subms_id'] == 1) {
            $result_artigo_aceite_up = "UPDATE adms_artigos SET
                adms_sit_artigo_id='$status',
                data_validade = '$data_validade',
                modified=NOW()
                WHERE id=" . $dados['id'] . "";
        } elseif ($row_artigo_aceite['adms_tp_subms_id'] == 2) {
            $result_artigo_aceite_up = "UPDATE adms_artigos SET
                data_validade = '$data_validade',
                valor_livro = '" . $dados['valor_livro'] . "',
                descri_valor_livro = '" . $dados['descri_valor_livro'] . "',
                data_publicacao_livro = '" . $dados['data_publicacao_livro'] . "',
                adms_sit_artigo_id='$status',
                modified=NOW()
                WHERE id=" . $dados['id'] . "";
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

            if ($row_artigo_aceite['normas'] == 1) {
                $valor_livro = "R$ 350,00";
            } else {
                $valor_livro = "R$ 420,00";
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
                    . " de autoria de <strong>"
                    . $autores
                    . "</strong>"
                    . ", foi <strong>aceito</strong> e encontra-se no prelo para publicação no livro eletrônico <strong>“"
                    . $tituloLivro
                    . "”</strong> em "
                    . "<strong>"
                    . strftime('%B de %Y', strtotime($row_artigo_aceite['livro_data']))
                    . "</strong>"
                    . ".<br>"
                    . "</p>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Agradeço a escolha pela Stricto Sensu Editora como meio de publicação e parabenizo os autores pelo aceite.</span></span>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>Prof.ª Dra.ª Naila Fernanda S. P. Meneguetti</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'><strong>Editora Geral Stricto Sensu Editora</strong></span></span></p>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'line-height: 1;'><span style = 'font-size: 10px;'><span style = 'font-family: Arial, Helvetica, sans-serif;'>"
                    . "Stricto Sensu Editora - CNPJ: 32.249.055/0001-26<br>Avenida Recanto Verde, 213, Conjunto Mariana<br>Rio Branco – AC – CEP: 69919-182<br>Site: www.sseditora.com.br<br>E-mail: edgeral@sseditora.com.br<br>Prefixos Editoriais: ISBN 80261 e 86283<br>DOI 10.35170"
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
                    . " de autoria de <strong>"
                    . $autores
                    . ""
                    . "</strong>"
                    . ", foi <strong>aceito</strong> e encontra-se no prelo para publicação em nosso site"
                    . " em "
                    . "<strong>"
                    . strftime('%B de %Y', strtotime($dados['data_publicacao_livro']))
                    . "</strong>"
                    . ".<br>"
                    . "</p>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Agradeço a escolha pela Stricto Sensu Editora como meio de publicação e parabenizo os autores pelo aceite.</span></span>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>Prof.ª Dra.ª Naila Fernanda S. P. Meneguetti</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'><strong>Editora Geral Stricto Sensu Editora</strong></span></span></p>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'line-height: 1;'><span style = 'font-size: 10px;'><span style = 'font-family: Arial, Helvetica, sans-serif;'>"
                    . "Stricto Sensu Editora - CNPJ: 32.249.055/0001-26<br>Avenida Recanto Verde, 213, Conjunto Mariana<br>Rio Branco – AC – CEP: 69919-182<br>Site: www.sseditora.com.br<br>E-mail: edgeral@sseditora.com.br<br>Prefixos Editoriais: ISBN 80261 e 86283<br>DOI 10.35170"
                    . "</span></span></p >";

            $mensagem_texto = "CARTA ACEITE<br><br>";
            $mensagem_texto .= "Após a avaliação técnico científica pelos pares, os membros do Conselho Editorial desta editora, tem a honra de informar que o capítulo de livro intitulado "
                    . "'" . $row_artigo_aceite['tituloArtigo'] . "'"
                    . " de autoria de "
                    . "'" . $autores . "'"
                    . " foi aceito e encontra-se no prelo para publicação no livro eletrônico "
                    . "'" . $tituloLivro . "'"
                    . strftime('%d de %B de %Y', strtotime($row_artigo_aceite['livro_data']))
                    . ".<br>"
                    . "Agradeço a escolha pela Stricto Sensu Editora como meio de publicação e parabenizo os autores pelo aceite.<br><br>"
                    . "Prof.ª Dra.ª Naila Fernanda S. P. Meneguetti<br>"
                    . "Editora Geral Stricto Sensu Editora<br>";

            $mensagem_texto_livro .= "Após a avaliação técnico científica pelos pares, os membros do Conselho Editorial desta editora, tem a honra de informar que o livro intitulado "
                    . "'" . $row_artigo_aceite['tituloLivro'] . "'"
                    . " de autoria de "
                    . "'" . $autores . "'"
                    . " foi aceito e encontra-se no prelo para publicação no nosso site "
                    . "em "
                    . strftime('%d de %B de %Y', strtotime($row_artigo_aceite['data_publicacao_livro']))
                    . ".<br>"
                    . "Agradeço a escolha pela Stricto Sensu Editora como meio de publicação e parabenizo os autores pelo aceite.<br><br>"
                    . "Prof.ª Dra.ª Naila Fernanda S. P. Meneguetti<br>"
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
                    . "<p style = 'text-align: justify; line-height: 2;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prezado(a): "
                    . "<strong>" . $row_artigo_aceite['nome_user'] . "</strong><br><br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Agradecemos a escolha pela <strong>Stricto Sensu Editora</strong> como meio de publicação de sua obra e parabenizamos os autores pelo aceite.<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Já encontra-se disponível na área do autor a opção para efetuar pagamento para a publicação do seu artigo.<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;https://areadoautor.sseditora.com.br/<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Se preferir pode realizar a transferência bancária para:<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Caixa Econômica Federal<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Naila Fernanda S. P. Meneguetti<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ag: 0534<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Op: 003<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C/C: 6285-3<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CNPJ: 32. 249. 055/0001-26<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E enviar o comprovante por e-mail.<br><br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Descrição: Publicação de Capítulo de Livro intitulado: "
                    . "<strong>“"
                    . $row_artigo_aceite['tituloArtigo']
                    . "”</strong>"
                    . " de autoria de <strong> “"
                    . $autores
                    . ""
                    . "”</strong>"
                    . ", do livro eletrônico <strong>“"
                    . $tituloLivro
                    . "”</strong>"
                    . "<br>"
                    . "Valor: <strong>“" . $valor_livro . "”</strong><br><br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Este documento tem validade até dia: "
                    . "<strong>"
                    . $data_validade
                    . "</strong>"
                    . ".<br><br>"
                    . "</span></span></p>"
                    . "</span></span>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>Prof.ª Dra.ª Naila Fernanda S. P. Meneguetti</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'><strong>Editora Geral Stricto Sensu Editora</strong></span></span></p>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'line-height: 1;'><span style = 'font-size: 10px;'><span style = 'font-family: Arial, Helvetica, sans-serif;'>"
                    . "Stricto Sensu Editora - CNPJ: 32.249.055/0001-26<br>Avenida Recanto Verde, 213, Conjunto Mariana<br>Rio Branco – AC – CEP: 69919-182<br>Site: www.sseditora.com.br<br>E-mail: edgeral@sseditora.com.br<br>Prefixos Editoriais: ISBN 80261 e 86283<br>DOI 10.35170"
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
                    . "<p style = 'text-align: justify; line-height: 2;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prezado(a): "
                    . "<strong>" . $row_artigo_aceite['nome_user'] . "</strong><br><br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Agradecemos a escolha pela <strong>Stricto Sensu Editora</strong> como meio de publicação de sua obra e parabenizamos os autores pelo aceite.<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Já encontra-se disponível na área do autor a opção para efetuar pagamento para a publicação do seu livro.<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;https://areadoautor.sseditora.com.br/<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Se preferir pode realizar a transferência bancária para:<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Caixa Econômica Federal<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Naila Fernanda S. P. Meneguetti<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ag: 0534<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Op: 003<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C/C: 6285-3<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CNPJ: 32. 249. 055/0001-26<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E enviar o comprovante por e-mail.<br><br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Descrição: "
                    . "</strong>"
                    . $dados['descri_valor_livro']
                    . "</strong>"
                    . "<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Titulo do Livro: <strong>“"
                    . $row_artigo_aceite['tituloLivro']
                    . "”</strong><br/>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Autores: <strong>"
                    . $autores
                    . ""
                    . "</strong>"
                    . "<br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor: <strong>" . $dados['valor_livro'] . "</strong><br><br>"
                    . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Este documento tem validade até dia: "
                    . "<strong> R$ "
                    . $data_validade
                    . "</strong>"
                    . ".<br><br>"
                    . "</span></span></p>"
                    . "</span></span>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>Prof.ª Dra.ª Naila Fernanda S. P. Meneguetti</span></span></p>"
                    . "<p style = 'text-align: right;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'><strong>Editora Geral Stricto Sensu Editora</strong></span></span></p>"
                    . "<p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                    . "<br>"
                    . "</span></span></p>"
                    . "<p style = 'line-height: 1;'><span style = 'font-size: 10px;'><span style = 'font-family: Arial, Helvetica, sans-serif;'>"
                    . "Stricto Sensu Editora - CNPJ: 32.249.055/0001-26<br>Avenida Recanto Verde, 213, Conjunto Mariana<br>Rio Branco – AC – CEP: 69919-182<br>Site: www.sseditora.com.br<br>E-mail: edgeral@sseditora.com.br<br>Prefixos Editoriais: ISBN 80261 e 86283<br>DOI 10.35170"
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
