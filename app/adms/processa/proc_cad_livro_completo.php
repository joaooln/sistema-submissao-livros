<?php

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

if (!isset($seg)) {
    exit;
}
$SendCadArtigo = filter_input(INPUT_POST, 'SendCadArtigo', FILTER_SANITIZE_STRING);
if (!empty($SendCadArtigo)) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//var_dump($dados);
//Retirar campo da validação vazio
    $dados_areaLivro = $dados['areaLivro'];
    unset($dados['areaLivro']);
    $dados_nomeCoautor = $dados['nomeCoautor'];
    unset($dados['nomeCoautor']);
    $dados_emailCoautor = $dados['emailCoautor'];
    unset($dados['emailCoautor']);

    $dados_cpf_nota = $dados['cpf_nota'];
    unset($dados['cpf_nota']);
    $dados_cnpj_nota = $dados['cnpj_nota'];
    unset($dados['cnpj_nota']);
    $dados_nome_nota_pf = $dados['nome_nota_pf'];
    unset($dados['nome_nota_pf']);
    $dados_email_nota_pf = $dados['email_nota_pf'];
    unset($dados['email_nota_pf']);
    $dados_nome_nota_pj = $dados['nome_nota_pj'];
    unset($dados['nome_nota_pj']);
    $dados_email_nota_pj = $dados['email_nota_pj'];
    unset($dados['email_nota_pj']);
    $dados_endereco_nota_pj = $dados['endereco_nota_pj'];
    unset($dados['endereco_nota_pj']);
    $dados_endereco_nota_pf = $dados['endereco_nota_pf'];
    unset($dados['endereco_nota_pf']);
    $dados_telefone_nota_pj = $dados['telefone_nota_pj'];
    unset($dados['telefone_nota_pj']);
    $dados_telefone_nota_pf = $dados['telefone_nota_pf'];
    unset($dados['telefone_nota_pf']);
    if (empty($dados_nome_nota_pf)) {
        $dados_nome_nota = $dados_nome_nota_pj;
    } else {
        $dados_nome_nota = $dados_nome_nota_pf;
    }
    if (empty($dados_email_nota_pf)) {
        $dados_email_nota = $dados_email_nota_pj;
    } else {
        $dados_email_nota = $dados_email_nota_pf;
    }
    if (empty($dados_endereco_nota_pf)) {
        $dados_endereco_nota = $dados_endereco_nota_pj;
    } else {
        $dados_endereco_nota = $dados_endereco_nota_pf;
    }
    if (empty($dados_telefone_nota_pf)) {
        $dados_telefone_nota = $dados_telefone_nota_pj;
    } else {
        $dados_telefone_nota = $dados_telefone_nota_pf;
    }

//Grava dados nome e cpf coautores para vetor
    for ($index = 9; $index > 0; $index--) {
        if (empty($dados_nomeCoautor[$index])) {
            $dados_nomeCoautor[$index] = "";
        }
        if (empty($dados_emailCoautor[$index])) {
            $dados_emailCoautor[$index] = "";
        }
    }

// Array com as extensões permitidas

    $tiposPermitidos = array('doc', 'docx', 'odt');

// Array com os tipos de erros de upload do PHP
    $_UP['erros'][0] = 'Não houve erro';
    $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
    $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
    $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
    $_UP['erros'][4] = 'Não foi feito o upload do arquivo';

// Tamanho máximo do arquivo (em Bytes)
    $_UP['tamanho'] = 1024 * 1024 * 10; // 10Mb
// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
    $_UP['renomeia'] = true;

//Remove caractes especiais
    include_once 'lib/lib_caracter_esp.php';
    include_once 'lib/lib_email.php';
    include_once 'lib/lib_env_email.php';
    $arquivo['name'] = caracterEspecial($_FILES['arquivo']['name']);
    $infos = pathinfo($_FILES['arquivo']['name']);
    $extensao = $infos['extension'];

    var_dump($dados);
//validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para cadastrar o livro!</div>";
    }
// Faz a verificação da extensão do arquivo
    if (in_array($extensao, $tiposPermitidos) == false) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Por favor, envie arquivos com as seguintes extensões: doc ou docx</div>";
    }

// Faz a verificação do tamanho do arquivo
    if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>O arquivo enviado é muito grande, envie arquivos de até 5Mb.</div>";
    }

//echo "Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro";
    if ($_FILES['arquivo']['error'] != 0) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Não foi possível fazer o upload. Verifique se o arquivo é menor que 5 MB.</div>";
    }

//Houve erro em algum campo será redirecionado para o formulário, não há erro no formulário tenta cadastrar no banco
    if ($erro) {

        $dados['areaLivro'] = $dados_areaLivro;
        $dados['nomeCoautor'] = $dados_nomeCoautor;
        $dados['emailCoautor'] = $dados_emailCoautor;
        $dados['tituloArtigo'] = $dados_tituloArtigo;
        $dados['cpf_nota'] = $dados_cpf_nota;
        $dados['cnpj_nota'] = $dados_cnpj_nota;
        $dados['nome_nota_pf'] = $dados_nome_nota_pf;
        $dados['email_nota_pf'] = $dados_email_nota_pf;
        $dados['nome_nota_pj'] = $dados_nome_nota_pj;
        $dados['email_nota_pj'] = $dados_email_nota_pj;
        $dados['endereco_nota_pj'] = $dados_endereco_nota_pj;
        $dados['endereco_nota_pf'] = $dados_endereco_nota_pf;
        $dados['telefone_nota_pj'] = $dados_telefone_nota_pj;
        $dados['telefone_nota_pf'] = $dados_telefone_nota_pf;
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/cadastrar/cad_livro_completo';
        header("Location: $url_destino");
    } else {

        $valor_arquivo = "'" . $dados_validos['tituloLivro'] . "." . $extensao . "',";
        $nome_final = $dados_validos['tituloLivro'] . "." . $extensao;

        $result_cad_artigo = "INSERT INTO adms_artigos (tituloLivro, areaLivro, nomeCoautor1, emailCoautor1, nomeCoautor2, emailCoautor2, nomeCoautor3, emailCoautor3, nomeCoautor4, emailCoautor4,
      nomeCoautor5, emailCoautor5, nomeCoautor6, emailCoautor6, nomeCoautor7, emailCoautor7, nomeCoautor8, emailCoautor8, nomeCoautor9, emailCoautor9, nomeCoautor10, emailCoautor10, normas,
      nota_outro_nome, nome_nota, cpf_nota, cnpj_nota, email_nota, endereco_nota, telefone_nota, arquivo, adms_tp_subms_id, adms_area_id, adms_sit_artigo_id ,adms_usuario_id, created) VALUES (
      '" . $dados_validos['tituloLivro'] . "',
      '" . $dados_areaLivro . "',
      '" . $dados_nomeCoautor[0] . "',
      '" . $dados_emailCoautor[0] . "',
      '" . $dados_nomeCoautor[1] . "',
      '" . $dados_emailCoautor[1] . "',
      '" . $dados_nomeCoautor[2] . "',
      '" . $dados_emailCoautor[2] . "',
      '" . $dados_nomeCoautor[3] . "',
      '" . $dados_emailCoautor[3] . "',
      '" . $dados_nomeCoautor[4] . "',
      '" . $dados_emailCoautor[4] . "',
      '" . $dados_nomeCoautor[5] . "',
      '" . $dados_emailCoautor[5] . "',
      '" . $dados_nomeCoautor[6] . "',
      '" . $dados_emailCoautor[6] . "',
      '" . $dados_nomeCoautor[7] . "',
      '" . $dados_emailCoautor[7] . "',
      '" . $dados_nomeCoautor[8] . "',
      '" . $dados_emailCoautor[8] . "',
      '" . $dados_nomeCoautor[9] . "',
      '" . $dados_emailCoautor[9] . "',
      '" . $dados_validos['normas'] . "',
      '" . $dados_validos['nota_outro_nome'] . "',
      '" . $dados_nome_nota . "',
      '" . $dados_cpf_nota . "',
      '" . $dados_cnpj_nota . "',
      '" . $dados_email_nota . "',
      '" . $dados_endereco_nota . "',
      '" . $dados_telefone_nota . "',    
      $valor_arquivo
      '" . 2 . "',
      '" . $dados_validos['adms_area_id'] . "',
      '" . 1 . "',
      '" . $_SESSION['id'] . "',
      NOW())";
        mysqli_query($conn, $result_cad_artigo);
        if (mysqli_insert_id($conn) and $erro == false) {
//Fazer upload
//echo "Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar";
// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
//Pasta onde o arquivo vai ser salvo
            $_UP['pasta'] = "assets/artigosRecebidos/" . mysqli_insert_id($conn) . "/";

//Cria pasta
            mkdir($_UP['pasta'], 0755);
// Depois verifica se é possível mover o arquivo para a pasta escolhida
            if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
//echo "Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo";
//echo '<br /><a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
            } else {
//echo $nome_final;
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Falha no Upload!</div>";
                $url_destino = pg . '/listar/list_artigo';
                header("Location: $url_destino");
// Não foi possível fazer o upload, provavelmente a pasta está incorreta
            }
            $_SESSION['msg'] = "<div class='alert alert-success'>Livro cadastrado com sucesso!</div>";
            $url_destino = pg . '/listar/list_artigo';
            header("Location: $url_destino");

            $result_user = "SELECT user.*
            FROM adms_usuarios user
            WHERE user.id=" . $_SESSION['id'] . " LIMIT 1";

            $resultado_user = mysqli_query($conn, $result_user);
            if (($resultado_user) AND ( $resultado_user->num_rows != 0)) {
                $row_user = mysqli_fetch_assoc($resultado_user);
            }

            $nome = explode(" ", $row_user['nome']);
            $prim_nome = $nome[0];

            $assunto = "Confirmação de Recebimento";


            $mensagem = "Caro(a) $prim_nome, <br><br>";
            $mensagem .= "Confirmamos o recebimento do seu trabalho conforme especificações abaixo:<br><br>";
            $mensagem .= "Título do Livro: " . $dados_validos['tituloLivro'] . "<br>";

            $result_areas = "SELECT id, nome FROM adms_areas WHERE id=" . $dados_validos['adms_area_id'] . " LIMIT 1";
            $resultado_areas = mysqli_query($conn, $result_areas);
            $row_areas = mysqli_fetch_assoc($resultado_areas);
            if ($dados_validos['adms_area_id'] == 1000) {
                $areaLivro = $dados_validos['areaLivro'];
            } else {
                $areaLivro = $row_areas['nome'];
            }

            $mensagem .= "Área de Conhecimento do Livro: " . $areaLivro . "<br>";
            $mensagem .= "Coautores: <br>";
            for ($index = 0; $index < 9; $index++) {
                if ($dados_nomeCoautor[$index] != "") {
                    $mensagem .= "Nome: " . $dados_nomeCoautor[$index] . " - E-mail: " . dados_emailCoautor[$index] . "<br>";
                }
            }
            $mensagem .= "Trabalho está nas Normas?: ";
            if ($dados_validos['normas'] == 1) {
                $normas_texto = "Sim <br>";
            } else {
                $normas_texto = "Não. A empresa irá realizar a normatização <br>";
            }
            $mensagem .= $normas_texto;
            $mensagem .= "Nota Fiscal será emitida em seu nome?: ";
            if ($dados_validos['nota_outro_nome'] == 1) {
                $nota_outro_nome_texto = "Sim <br>";
            } elseif ($dados_validos['nota_outro_nome'] == 2) {
                $nota_outro_nome_texto = "Não. A Nota Fiscal deverá ser no nome de outra pessoa. <br>";
            } else {
                $nota_outro_nome_texto = "Não. A Nota Fiscal deverá ser no nome de uma instituição ou empresa. <br>";
            }
            $mensagem .= $nota_outro_nome_texto;
            if (!empty($dados_nome_nota)) {
                $mensagem .= "Nome para emissão da nota fiscal: '" . $dados_nome_nota . "' - ";
            }
            if (!empty($dados_cpf_nota)) {
                $mensagem .= "CPF: '" . $dados_cpf_nota . "' <br>";
            }
            if (!empty($dados_cnpj_nota)) {
                $mensagem .= "CNPJ: '" . $dados_cnpj_nota . "' <br>";
            }
            if (!empty($dados_email_nota_pf)) {
                $mensagem .= "E-mail para emissão da nota fiscal: '" . $dados_email_nota_pf . "' <br>";
            }
            if (!empty($dados_email_nota_pj)) {
                $mensagem .= "E-mail para emissão da nota fiscal: '" . $dados_email_nota_pj . "' <br>";
            }
            if (!empty($dados_telefone_nota_pj)) {
                $mensagem .= "Telefone para nota fiscal: '" . $dados_telefone_nota_pj . "' <br>";
            }
            if (!empty($dados_telefone_nota_pf)) {
                $mensagem .= "Telefone para nota fiscal: '" . $dados_telefone_nota_pf . "' <br>";
            }
            if (!empty($dados_endereco_nota_pj)) {
                $mensagem .= "Endereço para emissão da nota fiscal: '" . $dados_endereco_nota_pj . "' <br>";
            }
            if (!empty($dados_endereco_nota_pf)) {
                $mensagem .= "Endereço para emissão da nota fiscal: '" . $dados_endereco_nota_pf . "' <br>";
            }
            $mensagem .= "Data da Submissão: " . date('d/m/y') . "<br>";
            $mensagem .= "Situação: Em Avaliação <br>";
            $mensagem .= "Arquivo: ";
            $mensagem .= "<a href = '" . pg . "/" . $_UP['pasta'] . "" . $nome_final . "'>" . $nome_final . "</a><br><br>";
            $mensagem .= "Em breve entraremos em contato para dar continuidade aos termos editoriais.<br><br>";
            $mensagem .= "At.te<br>Prof. Dr. Dionatas Meneguetti<br><br>";
            $mensagem .= "<img src='https://i1.wp.com/sseditora.com.br/wp-content/uploads/sseditora-1.png' width='290' height='112' />";

            //echo $mensagem;

            $mensagem_texto = "Caro(a) $prim_nome, <br><br>";
            $mensagem_texto .= "Confirmamos o recebimento do seu trabalho conforme especificações abaixo:<br><br>";
            $mensagem_texto .= "Titulo do Livro: " . $dados_validos['tituloLivro'] . "<br>";
            $mensagem_texto .= "Área de Conhecimento do Livro" . $areaLivro . "<br>";
            $mensagem_texto .= "Coautores: <br>";
            for ($index = 0; $index < 9; $index++) {
                if (!empty($dados['nomeCoautor'][$index])) {
                    $mensagem .= "Nome: '" . $dados_nomeCoautor[$index] . "' - CPF: '" . dados_emailCoautor[$index] . "'<br>";
                }
            }
            $mensagem_texto .= "Data da Submissão: '" . date('d/m/y') . "'<br>";
            $mensagem_texto .= "Situação: Em Avaliação <br>";
            $mensagem_texto .= "Em breve entraremos em contato para dar continuidade aos termos editoriais.<br><br>";
            $mensagem_texto .= "At.te<br>Prof. Dr. Dionatas Meneguetti";

            if (email_phpmailer($assunto, $mensagem, $mensagem_texto, $prim_nome, $row_user['email'], $conn)) {
                $_SESSION['msgcad'] = "<div class = 'alert alert-success'>Email Enviado</div>";
            } else {
                $_SESSION['msgcad'] = "<div class = 'alert alert-danger'>Erro ao enviar o email</div>";
            }
        } else {
            $erro = true;
            echo $result_cad_artigo;
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class = 'alert alert-danger'>Erro: O livro não foi cadastrado com sucesso!</div>";
            $url_destino = pg . '/cadastrar/cad_livro_completo';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class = 'alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
