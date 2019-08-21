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
                        <h2 class="display-4 titulo">Cadastrar Tipo de Página</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_list = carregar_btn('listar/list_tps_pgs', $conn);
                        if ($btn_list) {
                            echo "<a href='" . pg . "/listar/list_tps_pgs' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        ?>
                    </div>
                </div><hr>
                <?php
                if(isset($_SESSION['msg'])){
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
                <form method="POST" action="<?php echo pg; ?>/processa/proc_cad_tps_pgs">                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>                                
                                <span class="text-danger">*</span> Tipo
                            </label>
                            <input name="tipo" type="text" class="form-control" id="tipo" placeholder="Tipo da página exe: adms" value="<?php
                            if (isset($_SESSION['dados']['tipo'])) {
                                echo $_SESSION['dados']['tipo'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label><span class="text-danger">*</span> Nome</label>
                            <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome do tipo da página" value="<?php
                            if (isset($_SESSION['dados']['nome'])) {
                                echo $_SESSION['dados']['nome'];
                            }
                            ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label><span class="text-danger">*</span> Observação</label>
                        <textarea name="obs" class="form-control"><?php
                            if (isset($_SESSION['dados']['obs'])) {
                                echo $_SESSION['dados']['obs'];
                            }
                            ?></textarea>
                    </div>
                    
                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendCadTpsPgs" type="submit" class="btn btn-success" value="Cadastrar">
                </form>
            </div>    
        </div>
        <?php
        include_once 'app/adms/include/rodape_lib.php';
        ?>

    </div>
</body>


