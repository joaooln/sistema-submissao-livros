<?php
if (!isset($seg)) {
    exit;
}

$result_edit_user = "SELECT * FROM adms_usuarios WHERE id='" . $_SESSION['id'] . "' LIMIT 1";


$resultado_edit_user = mysqli_query($conn, $result_edit_user);
//Verificar se encontrou a página no banco de dados
if (($resultado_edit_user) AND ( $resultado_edit_user->num_rows != 0)) {
    $row_edit_user = mysqli_fetch_assoc($resultado_edit_user);
    include_once 'app/adms/include/head.php';
    ?>
    <body>
        <?php
        include_once 'app/adms/include/header.php';
        ?>
        <div class="d-flex">
            <?php
            include_once 'app/adms/include/menu.php';
            ?>

            <div class="content p-1">
                <div class="list-group-item">
                    <div class="d-flex">
                        <div class="mr-auto p-2">
                            <h2 class="display-4 titulo">Editar Perfil</h2>
                        </div>
                        <div class="p-2">
                            <?php
                            $btn_vis = carregar_btn('visualizar/vis_perfil', $conn);
                            if ($btn_vis) {
                                echo "<a href='" . pg . "/visualizar/vis_perfil' class='btn btn-outline-primary btn-sm'>Visualizar </a> ";
                            }
                            ?>
                        </div>
                    </div><hr>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <form method="POST" action="<?php echo pg; ?>/processa/proc_edit_perfil" enctype="multipart/form-data">  
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label>                                
                                    <span class="text-danger">*</span> Nome Completo
                                </label>
                                <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome do usuário completo" value="<?php
                                if (isset($_SESSION['dados']['nome'])) {
                                    echo $_SESSION['dados']['nome'];
                                } elseif (isset($row_edit_user['nome'])) {
                                    echo $row_edit_user['nome'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-5">
                                <label><span class="text-danger">*</span> E-mail</label>
                                <input name="email" type="email" class="form-control" placeholder="O melhor e-mail do usuário" value="<?php
                                if (isset($_SESSION['dados']['email'])) {
                                    echo $_SESSION['dados']['email'];
                                } elseif (isset($row_edit_user['email'])) {
                                    echo $row_edit_user['email'];
                                }
                                ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label>                                
                                    <span class="text-danger">*</span> CPF
                                </label>
                                <input name="cpf" type="text" class="form-control cpf" placeholder="CPF" value="<?php
                                if (isset($_SESSION['dados']['cpf'])) {
                                    echo $_SESSION['dados']['cpf'];
                                } elseif (isset($row_edit_user['cpf'])) {
                                    echo $row_edit_user['cpf'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-5">
                                <label>
                                    <span class="text-danger">*</span> Telefone
                                </label>
                                <input name="telefone" type="text" class="form-control phone_with_ddd" placeholder="Telefone com DDD" value="<?php
                                if (isset($_SESSION['dados']['telefone'])) {
                                    echo $_SESSION['dados']['telefone'];
                                } elseif (isset($row_edit_user['telefone'])) {
                                    echo $row_edit_user['telefone'];
                                }
                                ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>                                
                                    <span class="text-danger">*</span> Endereço
                                </label>
                                <input name="rua" type="text" class="form-control" placeholder="Rua" value="<?php
                                if (isset($_SESSION['dados']['rua'])) {
                                    echo $_SESSION['dados']['rua'];
                                } elseif (isset($row_edit_user['rua'])) {
                                    echo $row_edit_user['rua'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>
                                    <span class="text-danger">*</span> Número
                                </label>
                                <input name="num_end" type="text" class="form-control" placeholder="Número" value="<?php
                                if (isset($_SESSION['dados']['num_end'])) {
                                    echo $_SESSION['dados']['num_end'];
                                } elseif (isset($row_edit_user['num_end'])) {
                                    echo $row_edit_user['num_end'];
                                }
                                ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>                                
                                    <span class="text-danger">*</span> Bairro
                                </label>
                                <input name="bairro" type="text" class="form-control" placeholder="Bairro" value="<?php
                                if (isset($_SESSION['dados']['bairro'])) {
                                    echo $_SESSION['dados']['bairro'];
                                } elseif (isset($row_edit_user['bairro'])) {
                                    echo $row_edit_user['bairro'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>
                                    Complemento
                                </label>
                                <input name="complemento" type="text" class="form-control" placeholder="Complemento" value="<?php
                                if (isset($_SESSION['dados']['complemento'])) {
                                    echo $_SESSION['dados']['complemento'];
                                } elseif (isset($row_edit_user['complemento'])) {
                                    echo $row_edit_user['complemento'];
                                }
                                ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>                                
                                    <span class="text-danger">*</span> Cidade
                                </label>
                                <input name="cidade" type="text" class="form-control" placeholder="Cidade" value="<?php
                                if (isset($_SESSION['dados']['cidade'])) {
                                    echo $_SESSION['dados']['cidade'];
                                } elseif (isset($row_edit_user['cidade'])) {
                                    echo $row_edit_user['cidade'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <span class="text-danger">*</span> Estado
                                </label>
                                <select name="estado" class="custom-select" required>
                                    <option selected>Estado</option>
                                    <?php
                                    $estados = array(
                                        'AC' => 'Acre',
                                        'AL' => 'Alagoas',
                                        'AP' => 'Amapá',
                                        'AM' => 'Amazonas',
                                        'BA' => 'Bahia',
                                        'CE' => 'Ceará',
                                        'DF' => 'Distrito Federal',
                                        'ES' => 'Espirito Santo',
                                        'GO' => 'Goiás',
                                        'MA' => 'Maranhão',
                                        'MS' => 'Mato Grosso do Sul',
                                        'MT' => 'Mato Grosso',
                                        'MG' => 'Minas Gerais',
                                        'PA' => 'Pará',
                                        'PB' => 'Paraíba',
                                        'PR' => 'Paraná',
                                        'PE' => 'Pernambuco',
                                        'PI' => 'Piauí',
                                        'RJ' => 'Rio de Janeiro',
                                        'RN' => 'Rio Grande do Norte',
                                        'RS' => 'Rio Grande do Sul',
                                        'RO' => 'Rondônia',
                                        'RR' => 'Roraima',
                                        'SC' => 'Santa Catarina',
                                        'SP' => 'São Paulo',
                                        'SE' => 'Sergipe',
                                        'TO' => 'Tocantins',
                                    );

                                    foreach ($estados as $sigla_estado => $nome_estado) {
                                        if (isset($_SESSION['dados']['estado']) AND ( $_SESSION['dados']['estado'] == $sigla_estado)) {
                                            echo " <option value=" . $sigla_estado . ">" . $nome_estado . "</option>";
                                        } elseif (!isset($_SESSION['dados']['estado']) AND ( isset($row_edit_user['estado']) AND ( $row_edit_user['estado'] == $sigla_estado))) {
                                            echo "<option value='" . $row_edit_user['estado'] . "' selected>" . $nome_estado . "</option>";
                                        } else {
                                            echo " <option value=" . $sigla_estado . ">" . $nome_estado . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>
                                    <span class="text-danger">*</span> País
                                </label>
                                <input name="pais" type="text-only" class="form-control" placeholder="País" value="<?php
                                if (isset($_SESSION['dados']['pais'])) {
                                    echo $_SESSION['dados']['pais'];
                                } elseif (isset($row_edit_user['pais'])) {
                                    echo $row_edit_user['pais'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <label>
                                    <span class="text-danger">*</span> CEP
                                </label>
                                <input name="cep" type="text-only" class="form-control cep" placeholder="CEP" value="<?php
                                if (isset($_SESSION['dados']['cep'])) {
                                    echo $_SESSION['dados']['cep'];
                                } elseif (isset($row_edit_user['cep'])) {
                                    echo $row_edit_user['cep'];
                                }
                                ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <input type="hidden" name="imagem_antiga" value="<?php echo $row_edit_user['imagem']; ?>">
                            <div class="form-group col-sm-6">
                                <label> Foto </label>
                                <div class="custom-file">
                                    <input id="imagem" name="imagem" type="file" class="custom-file-input" onchange="previewImagem()">
                                    <label class="custom-file-label" for="imagem" data-browse="Escolher">Selecionar a foto</label>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <?php
                                if (isset($row_edit_user['imagem'])) {
                                    $imagem_antiga = pg . '/assets/imagens/usuario/' . $row_edit_user['id'] . '/' . $row_edit_user['imagem'];
                                } else {
                                    $imagem_antiga = pg . '/assets/imagens/usuario/preview_img.png';
                                }
                                ?>
                                <img src="<?php echo $imagem_antiga; ?>" id="preview-user" class="img-thumbnail" style="width: 150px; height: 150px;">
                            </div>                       
                        </div>

                        <p>
                            <span class="text-danger">* </span>Campo obrigatório
                        </p>
                        <input name="SendEditPerfil" type="submit" class="btn btn-warning" value="Salvar">
                    </form>
                </div>    
            </div>

            <?php
            include_once 'app/adms/include/rodape_lib.php';
            ?>
            <script>
                function previewImagem() {
                    var imagem = document.querySelector('input[name=imagem').files[0];
                    var preview = document.querySelector('#preview-user');

                    var reader = new FileReader();

                    reader.onloadend = function () {
                        preview.src = reader.result;
                    }

                    if (imagem) {
                        reader.readAsDataURL(imagem);
                    } else {
                        preview.src = "";
                    }
                }
            </script>  
        </div>
    </body>
    <?php
    unset($_SESSION['dados']);
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Usuário não encontrada!</div>";
    $url_destino = pg . '/listar/list_usuario';
    header("Location: $url_destino");
}