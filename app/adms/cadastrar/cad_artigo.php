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
                            <input name="cpfCoautor[]" type="text" class="form-control" placeholder="CPF" id="cpfCoautor[]" value="<?php
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
                        <div class="form-group col-sm-5">
                            <label for="normas">
                                <span class="text-danger">*</span> Trabalho está formatado nas normas?
                            </label>
                            <div class="custom-file">
                                <select name="normas" id="normas" class="custom-select" required>
                                    <?php
                                    if (isset($_SESSION['dados']['normas']) AND ( $_SESSION['dados']['normas'] == 1)) {
                                        echo "<option value=''>Selecione</option>";
                                        echo "<option value='1' selected>Sim</option>";
                                        echo "<option value='2' onclick='cadastrarInstituicao();'>Não. Desejo que a empresa realize a normatização</option>";
                                    } elseif (isset($_SESSION['dados']['normas']) AND ( $_SESSION['dados']['normas'] == 2)) {
                                        echo "<option value=''>Selecione</option>";
                                        echo "<option value='1'>Sim</option>";
                                        echo "<option value='2' onclick='cadastrarInstituicao();' selected>Não. Desejo que a empresa realize a normatização</option>";
                                    } else {
                                        echo "<option value='' selected>Selecione</option>";
                                        echo "<option value='1'>Sim</option>";
                                        echo "<option value='2' onclick='cadastrarInstituicao();'>Não. Desejo que a empresa realize a normatização</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-5">
                            <label>
                                <span class="text-danger">*</span> Nota Fiscal será no seu nome?
                            </label>
                            <div class="custom-file">
                                <select name="normas" id="normas" class="custom-select" required>
                                    <?php
                                    if (isset($_SESSION['dados']['normas']) AND ( $_SESSION['dados']['normas'] == 1)) {
                                        echo "<option value=''>Selecione</option>";
                                        echo "<option value='1' selected>Sim</option>";
                                        echo "<option value='2'>Não. A Nota Fiscal deverá ser no nome de outra pessoa</option>";
                                        echo "<option value='3'>Não. A Nota Fiscal deverá ser no nome de uma instituição ou empresa</option>";
                                    } elseif (isset($_SESSION['dados']['normas']) AND ( $_SESSION['dados']['normas'] == 2)) {
                                        echo "<option value=''>Selecione</option>";
                                        echo "<option value='1'>Sim</option>";
                                        echo "<option value='2' selected>Não. A Nota Fiscal deverá ser no nome de outra pessoa</option>";
                                        echo "<option value='3'>Não. A Nota Fiscal deverá ser no nome de uma instituição ou empresa</option>";
                                    } elseif (isset($_SESSION['dados']['normas']) AND ( $_SESSION['dados']['normas'] == 2)) {
                                        echo "<option value=''>Selecione</option>";
                                        echo "<option value='1'>Sim</option>";
                                        echo "<option value='2'>Não. A Nota Fiscal deverá ser no nome de outra pessoao</option>";
                                        echo "<option value='3' selected>Não. A Nota Fiscal deverá ser no nome de uma instituição ou empresa</option>";
                                    } else {
                                        echo "<option value='' selected>Selecione</option>";
                                        echo "<option value='1'>Sim</option>";
                                        echo "<option value='2'>Não. A Nota Fiscal deverá ser no nome de outra pessoao</option>";
                                        echo "<option value='3'>Não. A Nota Fiscal deverá ser no nome de uma instituição ou empresa</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row" id="nota-pessoal-fisica" hidden="true">
                        <div class="form-group col-md-5">
                            <label>                                
                                Nome
                            </label>
                            <input name="nome_nota" type="text" class="form-control" id="nome_nota" placeholder="Nome para ser emitido a Nota Fiscal" value="<?php
                            if (isset($_SESSION['dados']['nome_nota'])) {
                                echo $_SESSION['dados']['nome_nota'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>                                
                                CPF
                            </label>
                            <input name="cpf_nota" type="text" class="form-control cpf" id="cpf_nota" placeholder="CPF para ser emitido a Nota Fiscal" value="<?php
                            if (isset($_SESSION['dados']['cpf_nota'])) {
                                echo $_SESSION['dados']['cpf_nota'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>
                                E-mail
                            </label>
                            <input name="email-nota" type="email" class="form-control email" placeholder="E-mail para ser emitido a Nota Fiscal" id="email-nota" value="<?php
                            if (isset($_SESSION['dados']['email-nota'])) {
                                echo $_SESSION['dados']['email-nota'];
                            }
                            ?>">
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
                                <div id="campo_cpf' + cont + '" class="form-group col-md-4"><input name="cpfCoautor[]" type="text" class="form-control" id="cpfCoautor[]" placeholder="CPF" value=""></div>\
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

            function nota_pessoal_fisica() {
//Abre a função que mostra o campo CadastrarInstituicao se a opção "Instituição não encontrada" no select instituicao.
                var normas = document.getElementById("normas").value;
                if (instituicao === 'novaInstituicao') {
                    document.getElementById("cadastrarInstituicao").style.display = "block";
                    document.getElementById("lblCadastrarInstituicao").style.display = "block";
                } else {
                    document.getElementById("cadastrarInstituicao").style.display = "none";
                    document.getElementById("lblCadastrarInstituicao").style.display = "none";
                }
            }//Fecha a função
        </script>
    </div>
</body>


