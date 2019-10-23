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
                        <h2 class="display-4 titulo">Cadastrar Novo Artigo</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_list = carregar_btn('listar/list_artigo', $conn);
                        if ($btn_list) {
                            echo "<a href='" . pg . "/listar/list_artigo' class='btn btn-outline-info btn-sm'>Listar</a> ";
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
                <form id="formCadArtigo" method="POST" action="<?php echo pg; ?>/processa/proc_cad_artigo" enctype="multipart/form-data">  
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>                                
                                <span class="text-danger">*</span> Título do Livro
                            </label>
                            <input name="tituloLivro" type="text" class="form-control" id="tituloLivro" placeholder="Título do Livro" required value="<?php
                            if (isset($_SESSION['dados']['tituloLivro'])) {
                                echo $_SESSION['dados']['tituloLivro'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>
                                <span class="text-danger">*</span> Título do Artigo
                            </label>
                            <input name="tituloArtigo" type="text" class="form-control" id="tituloArtigo" placeholder="Título do Artigo" required value="<?php
                            if (isset($_SESSION['dados']['tituloArtigo'])) {
                                echo $_SESSION['dados']['tituloArtigo'];
                            }
                            ?>">
                        </div>
                    </div>

                    <div class="form-row" id="co-autores">
                        <div class="form-group col-md-5">
                            <label>                                
                                Coautores
                            </label>
                            <input name="nomeCoautor[]" type="text" class="form-control" id="nomeCoautor[]" placeholder="Nome" value="<?php
                            if (isset($_SESSION['dados']['nomeCoautor[]'])) {
                                echo $_SESSION['dados']['nomeCoautor[]'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                CPFs
                            </label>
                            <input name="cpfCoautor[]" type="text" class="form-control cpf" placeholder="CPF" id="cpfCoautor[]" placeholder="CPF" value="<?php
                            if (isset($_SESSION['dados']['cpfCoautor[]'])) {
                                echo $_SESSION['dados']['cpfCoautor[]'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label> Opções </label>
                            <br/>
                            <button id="add_field" type="button" class="btn btn-primary"><i class="fas fa-plus-circle"></i></button>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label>
                                <span class="text-danger">*</span> Arquivo
                            </label>
                            <div class="custom-file">
                                <input id="arquivo" name="arquivo" type="file" class="custom-file-input" onchange="previewImagem()" required>
                                <label class="custom-file-label" for="arquivo" data-browse="Escolher">Selecionar o aquivo Word</label>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <img src="<?php echo pg . '/assets/imagens/usuario/preview_img.png'; ?>" id="preview-user" class="img-thumbnail" style="width: 200px; height: 200px;">
                        </div>
                    </div>

                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendCadArtigo" id="SendCadArtigo" type="submit" class="btn btn-success" value="Cadastrar">
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

            $(document).ready(function () {
                var campos_max = 5;   //max de 5 campos
                var x = 1; // campos iniciais
                var cont = 1;
                $('#add_field').click(function (e) {
                    cont++;
                    e.preventDefault();     //prevenir novos clicks
                    if (x < campos_max) {
                        $('#co-autores').append('\
                                <div id="campo_nome' + cont + '" class="form-group col-md-5"><input name="nomeCoautor[]" type="text" class="form-control" id="nomeCoautor[]" placeholder="Nome" value=""></div>\
                                <div id="campo_cpf' + cont + '" class="form-group col-md-4"><input name="cpfCoautor[]" type="text" class="form-control" id="cpfCoautor" placeholder="CPF" value=""></div>\
                                <div id="campo_botao' + cont + '" class="form-group col-md-3"><button id="' + cont + '" type="button" class="btn btn-danger btn-remover_campo"><i class="fas fa-minus-circle"></i></button></div>\
                                ');
                        x++;
                    }
                });

                // Remover o div anterior
                $('form').on('click', '.btn-remover_campo', function () {
                    var button_id = $(this).attr("id");
                    $('#campo_nome' + button_id + '').remove();
                    $('#campo_cpf' + button_id + '').remove();
                    $('#campo_botao' + button_id + '').remove();
                    x--;
                });
                
                $("#SendCadArtigo").click(function () {
                    //Receber os dados do formulário
                    var dadosCoautores = $("#formCadArtigo").serialize();
                    //alert ("<?php echo pg; ?>/processa/proc_cad_artigo");
                    $.post("<?php echo pg; ?>/processa/proc_cad_artigo.php", dadosCoautores, function () {
                        //$("#msg").slideDown('slow').html(retorna);

                        //Limpar os campos
                        //$('#add-aula')[0].reset();
                    });
                });
            });
        </script>
    </div>
</body>


