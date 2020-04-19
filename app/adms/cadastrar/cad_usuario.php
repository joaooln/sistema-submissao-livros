<?php
if (!isset($seg)) {
    exit;
}
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
                        <h2 class="display-4 titulo">Cadastrar Usuário</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_list = carregar_btn('listar/list_usuario', $conn);
                        if ($btn_list) {
                            echo "<a href='" . pg . "/listar/list_usuario' class='btn btn-outline-info btn-sm'>Listar</a> ";
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
                <form method="POST" action="<?php echo pg; ?>/processa/proc_cad_usuario" enctype="multipart/form-data">  
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>                                
                                <span class="text-danger">*</span> Nome
                            </label>
                            <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome do usuário completo" value="<?php
                            if (isset($_SESSION['dados']['nome'])) {
                                echo $_SESSION['dados']['nome'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label><span class="text-danger">*</span> E-mail</label>
                            <input name="email" type="text" class="form-control" id="email" placeholder="O melhor e-mail do usuário" value="<?php
                            if (isset($_SESSION['dados']['email'])) {
                                echo $_SESSION['dados']['email'];
                            }
                            ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label><span class="text-danger">*</span> Senha</label>
                            <input name="senha" type="password" class="form-control" id="email" placeholder="A senha deve ter 6 caracteres" value="<?php
                            if (isset($_SESSION['dados']['senha'])) {
                                echo $_SESSION['dados']['senha'];
                            }
                            ?>">
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <?php
                            $result_niv_ac = "SELECT id, nome FROM adms_niveis_acessos ORDER BY nome ASC";
                            $resultado_niv_ac = mysqli_query($conn, $result_niv_ac);
                            ?>
                            <label><span class="text-danger">*</span> Nível de Acesso </label>
                            <select name="adms_niveis_acesso_id" id="adms_niveis_acesso_id" class="form-control">
                                <option value="">Selecione</option>
                                <?php
                                while ($row_niv_ac = mysqli_fetch_assoc($resultado_niv_ac)) {
                                    if (isset($_SESSION['dados']['adms_niveis_acesso_id']) AND ( $_SESSION['dados']['adms_niveis_acesso_id'] == $row_niv_ac['id'])) {
                                        echo "<option value='" . $row_niv_ac['id'] . "' selected>" . $row_niv_ac['nome'] . "</option>";
                                    } else {
                                        echo "<option value='" . $row_niv_ac['id'] . "'>" . $row_niv_ac['nome'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <?php
                            $result_sit_user = "SELECT id, nome FROM adms_sits_usuarios ORDER BY nome ASC";
                            $resultado_sit_user = mysqli_query($conn, $result_sit_user);
                            ?>
                            <label><span class="text-danger">*</span> Situação do Usuário </label>
                            <select name="adms_sits_usuario_id" id="adms_sits_usuario_id" class="form-control">
                                <option value="">Selecione</option>
                                <?php
                                while ($row_sit_user = mysqli_fetch_assoc($resultado_sit_user)) {
                                    if (isset($_SESSION['dados']['adms_sits_usuario_id']) AND ( $_SESSION['dados']['adms_sits_usuario_id'] == $row_sit_user['id'])) {
                                        echo "<option value='" . $row_sit_user['id'] . "' selected>" . $row_sit_user['nome'] . "</option>";
                                    } else {
                                        echo "<option value='" . $row_sit_user['id'] . "'>" . $row_sit_user['nome'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label> Foto </label>
                            <div class="custom-file">
                                <input id="imagem" name="imagem" type="file" class="custom-file-input" onchange="previewImagem()">
                                <label class="custom-file-label" for="imagem" data-browse="Escolher">Selecionar a foto</label>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <img src="<?php echo pg . '/assets/imagens/usuario/preview_img.png'; ?>" id="preview-user" class="img-thumbnail" style="width: 200px; height: 200px;">
                        </div>
                    </div>

                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendCadUser" type="submit" class="btn btn-success" value="Cadastrar">
                </form>
            </div>    
        </div>
        <?php
        unset($_SESSION['dados']);
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


