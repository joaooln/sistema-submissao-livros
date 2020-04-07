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
                        <h2 class="display-4 titulo">Cadastrar Área de Conhecimento</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_list = carregar_btn('listar/list_area', $conn);
                        if ($btn_list) {
                            echo "<a href='" . pg . "/listar/list_area' class='btn btn-outline-info btn-sm'>Listar</a> ";
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
                <form method="POST" action="<?php echo pg; ?>/processa/proc_cad_area">  
                    <div class="form-group">
                        <label>
                            <span class="text-danger">*</span> Nome
                            <span data-placement="top" tabindex="0" data-toggle="tooltip" title="Nome da área">
                                <i class="fas fa-question-circle"></i>
                            </span>
                        </label>
                        <input name="nome" type="text" class="form-control" placeholder="Nome da área" value="<?php
                        if (isset($_SESSION['dados']['nome'])) {
                            echo $_SESSION['dados']['nome'];
                        }
                        ?>">
                    </div>

                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendCadArea" type="submit" class="btn btn-success" value="Cadastrar">
                </form>
            </div>
        </div>
        <?php
        unset($_SESSION['dados']);
        include_once 'app/adms/include/rodape_lib.php';
        ?>

    </div>
</body>


