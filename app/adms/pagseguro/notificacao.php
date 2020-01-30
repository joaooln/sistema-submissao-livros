<?php

include_once 'lib/lib_env_email.php';
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$url_host = filter_input(INPUT_SERVER, 'HTTP_HOST');

header("access-control-allow-origin: https://pagseguro.uol.com.br");
header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
require_once("PagSeguro.class.php");

if (isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction') {
    $PagSeguro = new PagSeguro();
    $response = $PagSeguro->executeNotification($_POST);
    if ($response->status == 3 || $response->status == 4) {
        //PAGAMENTO CONFIRMADO
        //ATUALIZAR O STATUS NO BANCO DE DADOS
        $result_artigo_pag_not = "UPDATE adms_artigos SET
                adms_sit_artigo_id=3,
                modified=NOW()
                WHERE id='" . $response->reference . "'";
        $resultado_artigo_pag_not = mysqli_query($conn, $result_artigo_pag_not);

        $result_artigo_pag = "SELECT artigo.id, artigo.tituloLivro ,artigo.tituloArtigo, artigo.nomeCoautor1, artigo.nomeCoautor2, artigo.nomeCoautor3, artigo.nomeCoautor4, artigo.nomeCoautor5, artigo.adms_sit_artigo_id, artigo.adms_usuario_id, user.nome, user.email
                             FROM adms_artigos artigo
                             INNER JOIN adms_usuarios user ON user.id=artigo.adms_usuario_id            
                             WHERE artigo.id='" . $response->reference . "' LIMIT 1";
        $resultado_artigo_pag = mysqli_query($conn, $result_artigo_pag);


        $row_artigo_pag = mysqli_fetch_assoc($resultado_artigo_pag);

        $nome = explode(" ", $row_artigo_pag['nome']);
        $prim_nome = $nome[0];

        $assunto = "Confirmação de Pagamento";

        $mensagem = "<p><strong><img style = 'display: block; margin-left: auto; margin-right: auto;' src = 'https://i1.wp.com/sseditora.com.br/wp-content/uploads/sseditora-1.png' width = '290' height = '112' /></strong></p>"
                . " < br>"
                . " < p style = 'text-align: center;'><span style = 'font-size: 24px;'><strong><span style = 'font-family: Arial, Helvetica, sans-serif;'>CONFIRMAÇÃO DE PAGAMENTO</span></strong></span></p>"
                . " < p><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                . " < br>"
                . " < /span></p>"
                . " < p><span style = 'font-family: Arial, Helvetica, sans-serif; font-size: 12px;'>"
                . "Rio Branco, Acre, "
                . strftime('%d de %B de %Y', strtotime('today'))
                . "  . < /span></p>"
                . " < br>"
                . " < p><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                . " < br>"
                . " < /span></span></p>"
                . " < p style = 'text-align: justify; line-height: 1.5;'><span style = 'font-size: 12px;'><span style = 'font-family: Arial,Helvetica,sans-serif;'>"
                . " & nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                Informamos que foi <strong>confirmado</strong> o pagamento de seu artigo intitulado: "
                . " < strong>“"
                . $row_artigo_pag['tituloArtigo']
                . "”</strong>"
                . ", seu artigo está apto para publicação no livro eletrônico <strong>“"
                . $row_artigo_pag['tituloLivro']
                . "”</strong> em Dezembro de 2019."
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

        $mensagem_texto = "CONFIRMAÇÃO DE PAGAMENTO<br><br>";
        $mensagem_texto .= "Informamos que foi confirmado o pagamento de seu artigo intitulado: "
                . "'" . $row_artigo_pag['tituloArtigo'] . "'"
                . ", seu artigo está apto para publicação no livro eletrônico "
                . "'" . $row_artigo_pag['tituloLivro'] . "'"
                . " em Dezembro de 2019.<br>"
                . "Agradeço a escolha pela Stricto Sensu Editora como meio de publicação.<br><br>"
                . "Prof.ª Msc.ª Naila Fernanda S. P. Meneguetti<br>"
                . "Editora Geral Stricto Sensu Editora<br>";

        (email_phpmailer($assunto, $mensagem, $mensagem_texto, $prim_nome, $row_artigo_pag['email'], $conn));

        //echo $PagSeguro->getStatusText($PagSeguro->status);
    } else {
        //PAGAMENTO PENDENTE
        //echo $PagSeguro->getStatusText($PagSeguro->status);
    }
}
?>