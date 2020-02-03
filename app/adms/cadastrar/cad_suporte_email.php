<?php
if (!isset($seg)) {
    exit;
}

$result_suporte = "SELECT * FROM adms_usuarios WHERE id='" . $_SESSION['id'] . "' LIMIT 1";

$resultado_suporte = mysqli_query($conn, $result_suporte);

$row_suporte = mysqli_fetch_assoc($resultado_suporte);

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
                        <h2 class="display-4 titulo">Suporte ao Autor</h2>
                        <p>Caso tenho algum problema ou sugestão de melhoria ao utilizar nosso sistema, favor enviar mensagem para nosso suporte preenchendo os campos abaixo:</p>
                    </div>
                </div><hr>
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
                <form method="POST" action="<?php echo pg; ?>/processa/proc_cad_suporte_email">  
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label>
                                <span class="text-danger">*</span> Nome
                                </span>
                            </label>
                            <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome Completo" required="true" value="<?php
                            if (isset($_SESSION['dados']['nome'])) {
                                echo $_SESSION['dados']['nome'];
                            } elseif (isset($row_suporte['nome'])) {
                                echo $row_suporte['nome'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label><span class="text-danger">*</span> E-mail</label>
                            <input name="email" type="email" class="form-control" id="email" required="true" placeholder="Seu E-mail" value="<?php
                            if (isset($_SESSION['dados']['email'])) {
                                echo $_SESSION['dados']['email'];
                            } elseif (isset($row_suporte['email'])) {
                                echo $row_suporte['email'];
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label>
                                <span class="text-danger">*</span> Telefone
                                </span>
                            </label>
                            <input name="fone" type="text" class="form-control phone_with_ddd" id="fone" placeholder="Telefone com DDD" required="true" value="<?php
                            if (isset($_SESSION['dados']['fone'])) {
                                echo $_SESSION['dados']['fone'];
                            } elseif (isset($row_suporte['telefone'])) {
                                echo $row_suporte['telefone'];
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-9">
                            <label><span class="text-danger">*</span> Mensagem</label>
                            <textarea name="mensagem" class="form-control" required=""><?php
                                if (isset($_SESSION['dados']['mensagem'])) {
                                    echo $_SESSION['dados']['mensagem'];
                                }
                                ?></textarea>
                        </div>
                    </div>


                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendCadSuporte" type="submit" class="btn btn-success" value="Enviar">
                </form>
            </div>    
        </div>
        <?php
        unset($_SESSION['dados']);
        include_once 'app/adms/include/rodape_lib.php';
        ?>

    </div>
</body>


