<?php
if (!isset($seg)) {
    exit;
}

$result_conf_email = "SELECT * FROM adms_confs_emails WHERE id='1' LIMIT 1";

$resultado_conf_email = mysqli_query($conn, $result_conf_email);
//Verificar se encontrou a página no banco de dados
if (($resultado_conf_email) AND ( $resultado_conf_email->num_rows != 0)) {
    $row_conf_email = mysqli_fetch_assoc($resultado_conf_email);
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
                            <h2 class="display-4 titulo">Editar Credencias de e-mail</h2>
                        </div>                        
                    </div><hr>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <form method="POST" action="<?php echo pg; ?>/processa/proc_edit_cred_email" enctype="multipart/form-data">                       
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" title="Nome do remetente no E-mail ">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> Nome
                                </label>
                                <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome do remetente" value="<?php
                                if (isset($_SESSION['dados']['nome'])) {
                                    echo $_SESSION['dados']['nome'];
                                } elseif (isset($row_conf_email['nome'])) {
                                    echo $row_conf_email['nome'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" title="E-mail do remetente">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> E-mail
                                </label>
                                <input name="email" type="email" class="form-control" id="nome" placeholder="E-mail do remetente" value="<?php
                                if (isset($_SESSION['dados']['email'])) {
                                    echo $_SESSION['dados']['email'];
                                } elseif (isset($row_conf_email['email'])) {
                                    echo $row_conf_email['email'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" title="SMTP do servidor">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> Host
                                </label>
                                <input name="host" type="text" class="form-control" id="nome" placeholder="SMTP do servidor" value="<?php
                                if (isset($_SESSION['dados']['host'])) {
                                    echo $_SESSION['dados']['host'];
                                } elseif (isset($row_conf_email['host'])) {
                                    echo $row_conf_email['host'];
                                }
                                ?>">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" title="E-mail do remetente">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> Usuário
                                </label>
                                <input name="usuario" type="text" class="form-control" id="nome" placeholder="E-mail do remetente" value="<?php
                                if (isset($_SESSION['dados']['usuario'])) {
                                    echo $_SESSION['dados']['usuario'];
                                } elseif (isset($row_conf_email['usuario'])) {
                                    echo $row_conf_email['usuario'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label>
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" title="Senha do E-mail do remetente">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> Senha
                                </label>
                                <input name="senha" type="password" class="form-control" id="nome" placeholder="Senha do E-mail" value="<?php
                                if (isset($_SESSION['dados']['senha'])) {
                                    echo $_SESSION['dados']['senha'];
                                } elseif (isset($row_conf_email['senha'])) {
                                    echo $row_conf_email['senha'];
                                }
                                ?>">
                            </div>
                        </div>
                        
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" title="Porta para envio de E-mail ">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> Porta
                                </label>
                                <input name="porta" type="text" class="form-control" id="nome" placeholder="Porta de envio" value="<?php
                                if (isset($_SESSION['dados']['porta'])) {
                                    echo $_SESSION['dados']['porta'];
                                } elseif (isset($row_conf_email['porta'])) {
                                    echo $row_conf_email['porta'];
                                }
                                ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label>
                                    <span class="text-danger">*</span> Encriptação
                                </label>
                                <select name="smtpsecure" id="smtpsecure" class="form-control">
                                    <?php
                                    if ((isset($_SESSION['dados']['smtpsecure']) AND ( $_SESSION['dados']['smtpsecure'] == "ssl")) OR ( isset($row_conf_email['smtpsecure']) AND ( $row_conf_email['smtpsecure'] == "ssl"))) {
                                        echo "<option value=''>Selecione</option>";
                                        echo "<option value='ssl' selected>ssl</option>";
                                        echo "<option value='tls'>tls</option>";
                                    } elseif ((isset($_SESSION['dados']['smtpsecure']) AND ( $_SESSION['dados']['smtpsecure'] == "tls")) OR ( isset($row_conf_email['smtpsecure']) AND ( $row_conf_email['smtpsecure'] == "tls"))) {
                                        echo "<option value=''>Selecione</option>";
                                        echo "<option value='ssl'>ssl</option>";
                                        echo "<option value='tls' selected>tls</option>";
                                    } else {
                                        echo "<option value='' selected>Selecione</option>";
                                        echo "<option value='ssl'>ssl</option>";
                                        echo "<option value='tls'>tls</option>";
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>

                        <p>
                            <span class="text-danger">* </span>Campo obrigatório
                        </p>
                        <input name="SendEditCredEmail" type="submit" class="btn btn-warning" value="Salvar">
                    </form>
                </div>    
            </div>

            <?php
            include_once 'app/adms/include/rodape_lib.php';
            ?>
        </div>
    </body>
    <?php
    unset($_SESSION['dados']);
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Usuário não encontrada!</div>";
    $url_destino = pg . '/listar/list_usuario';
    header("Location: $url_destino");
}