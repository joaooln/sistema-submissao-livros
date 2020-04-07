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
                        <h2 class="display-4 titulo">Cadastrar Novo Livro Completo</h2>
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
                <form id="formCadArtigo" method="POST" action="<?php echo pg; ?>/processa/proc_cad_livro_completo" enctype="multipart/form-data">  
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>
                                <span class="text-danger">*</span> Título do Livro
                            </label>
                            <input name="tituloLivro" type="text" class="form-control" id="tituloLivro" maxlength="220" placeholder="Título do Livro" required value="<?php
                            if (isset($_SESSION['dados']['tituloLivro'])) {
                                echo $_SESSION['dados']['tituloLivro'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <?php
                            $result_areas = "SELECT id, nome FROM adms_areas ORDER BY nome ASC";
                            $resultado_areas = mysqli_query($conn, $result_areas);
                            ?>
                            <label>                                
                                <span class="text-danger">*</span> Áre de Conhecimento do Livro
                            </label>
                            <select name="adms_area_id" id="adms_area_id" class="custom-select" onchange="mostradivtitulolivro(this.value)" required>
                                <option value="">Selecione</option>
                                <?php
                                while ($row_areas = mysqli_fetch_assoc($resultado_areas)) {
                                    if (isset($_SESSION['dados']['adms_area_id']) AND ( $_SESSION['dados']['adms_area_id'] == $row_areas['id'])) {
                                        echo " <option selected value=" . $row_areas['id'] . ">" . $row_areas['nome'] . "</option>";
                                    } else {
                                        echo " <option value=" . $row_areas['id'] . ">" . $row_areas['nome'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row" id="1000" name="1" style="display:none">
                        <div class="form-group col-sm-6">
                            <input name="areaLivro" type="text" class="form-control" id="areaLivro" maxlength="220" placeholder="Informe o área do livro que deseja" value="<?php
                            if (isset($_SESSION['dados']['areaLivro'])) {
                                echo $_SESSION['dados']['areaLivro'];
                            }
                            ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-5">
                            <label for="normas">
                                <span class="text-danger">*</span> O livro está formatado nas normas?
                            </label>
                            <div class="custom-file">
                                <select name="normas" id="normas" class="custom-select" required>
                                    <?php
                                    if (isset($_SESSION['dados']['normas']) AND ( $_SESSION['dados']['normas'] == 1)) {
                                        echo "<option value=''>Selecione</option>";
                                        echo "<option value='1' selected>Sim</option>";
                                        echo "<option value='2'>Não. Desejo que a empresa realize a normatização</option>";
                                    } elseif (isset($_SESSION['dados']['normas']) AND ( $_SESSION['dados']['normas'] == 2)) {
                                        echo "<option value=''>Selecione</option>";
                                        echo "<option value='1'>Sim</option>";
                                        echo "<option value='2' selected>Não. Desejo que a empresa realize a normatização</option>";
                                    } else {
                                        echo "<option value='' selected>Selecione</option>";
                                        echo "<option value='1'>Sim</option>";
                                        echo "<option value='2'>Não. Desejo que a empresa realize a normatização</option>";
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
                                <select name="nota_outro_nome" id="nota_outro_nome" class="custom-select" required onchange="mostradiv(this.value)">
                                    <?php
                                    if (isset($_SESSION['dados']['nota_outro_nome']) AND ( $_SESSION['dados']['nota_outro_nome'] == 1)) {
                                        echo "<option value=''>Selecione</option>";
                                        echo "<option value='1' selected>Sim</option>";
                                        echo "<option value='2'>Não. A Nota Fiscal deverá ser no nome de outra pessoa</option>";
                                        echo "<option value='3' onclick='cadastrarInstituicao();'>Não. A Nota Fiscal deverá ser no nome de uma instituição ou empresa</option>";
                                    } elseif (isset($_SESSION['dados']['nota_outro_nome']) AND ( $_SESSION['dados']['nota_outro_nome'] == 2)) {
                                        echo "<option value=''>Selecione</option>";
                                        echo "<option value='1'>Sim</option>";
                                        echo "<option value='2' selected>Não. A Nota Fiscal deverá ser no nome de outra pessoa</option>";
                                        echo "<option value='3' onclick='cadastrarInstituicao();'>Não. A Nota Fiscal deverá ser no nome de uma instituição ou empresa</option>";
                                    } elseif (isset($_SESSION['dados']['nota_outro_nome']) AND ( $_SESSION['dados']['nota_outro_nome'] == 2)) {
                                        echo "<option value=''>Selecione</option>";
                                        echo "<option value='1'>Sim</option>";
                                        echo "<option value='2'>Não. A Nota Fiscal deverá ser no nome de outra pessoa</option>";
                                        echo "<option value='3' onclick='cadastrarInstituicao();'  selected>Não. A Nota Fiscal deverá ser no nome de uma instituição ou empresa</option>";
                                    } else {
                                        echo "<option value='' selected>Selecione</option>";
                                        echo "<option value='1'>Sim</option>";
                                        echo "<option value='2'>Não. A Nota Fiscal deverá ser no nome de outra pessoa</option>";
                                        echo "<option value='3' onclick='cadastrarInstituicao();'>Não. A Nota Fiscal deverá ser no nome de uma instituição ou empresa</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-row" id="2" name="2" style="display:none">
                        <div class="form-group col-md-5">
                            <label>                                
                                Nome p/ Nota Fiscal
                            </label>
                            <input name="nome_nota_pf" type="text" class="form-control" id="nome_nota_pf" maxlength="220" placeholder="Nome para ser emitido a Nota Fiscal" value="<?php
                            if (isset($_SESSION['dados']['nome_nota_pf'])) {
                                echo $_SESSION['dados']['nome_nota_pf'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>                                
                                CPF p/ Nota Fiscal
                            </label>
                            <input name="cpf_nota" type="text" class="form-control cpf" id="cpf_nota" maxlength="14" placeholder="CPF p/ Nota Fiscal" value="<?php
                            if (isset($_SESSION['dados']['cpf_nota'])) {
                                echo $_SESSION['dados']['cpf_nota'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>
                                Telefone p/ Nota Fiscal
                            </label>
                            <input name="telefone_nota_pf" type="text" class="form-control phone_with_ddd" placeholder="Telefone p/ Nota Fiscal" id="telefone_nota_pf" value="<?php
                            if (isset($_SESSION['dados']['telefone_nota_pf'])) {
                                echo $_SESSION['dados']['telefone_nota_pf'];
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="form-row" id="4" name="4" style="display:none">
                        <div class="form-group col-md-5">
                            <label>                                
                                Endereço p/ Nota Fiscal
                            </label>
                            <textarea name="endereco_nota_pf" type="text" class="form-control" id="endereco_nota_pf" placeholder="Endereço Completo para emissão da nota fiscal: Rua, Bairro, CEP, Cidade, Estado"><?php
                                if (isset($_SESSION['dados']['endereco_nota_pf'])) {
                                    echo $_SESSION['dados']['endereco_nota_pf'];
                                }
                                ?></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                E-mail p/ Nota Fiscal
                            </label>
                            <input name="email_nota_pf" type="email" class="form-control email" maxlength="220" placeholder="E-mail para ser emitido a Nota Fiscal" id="email_nota_pf" value="<?php
                            if (isset($_SESSION['dados']['email_nota_pf'])) {
                                echo $_SESSION['dados']['email_nota_pf'];
                            }
                            ?>">
                        </div>
                    </div>

                    <div class="form-row" id="3" name="3" style="display:none">
                        <div class="form-group col-md-5">
                            <label>                                
                                Razão Social
                            </label>
                            <input name="nome_nota_pj" type="text" class="form-control" maxlength="220" id="nome_nota_pj" placeholder="Razão Social para ser emitido a Nota Fiscal" value="<?php
                            if (isset($_SESSION['dados']['nome_nota_pj'])) {
                                echo $_SESSION['dados']['nome_nota_pj'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>                                
                                CNPJ
                            </label>
                            <input name="cnpj_nota" type="text" class="form-control cnpj" maxlength="18" id="cnpj_nota" placeholder="CNPJ para ser emitido a Nota Fiscal" value="<?php
                            if (isset($_SESSION['dados']['cnpj_nota'])) {
                                echo $_SESSION['dados']['cnpj_nota'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label>
                                Telefone p/ Nota Fiscal
                            </label>
                            <input name="telefone_nota_pj" type="text" class="form-control phone_with_ddd" placeholder="Telefone p/ Nota Fiscal" id="telefone_nota_pj" value="<?php
                            if (isset($_SESSION['dados']['telefone_nota_pj'])) {
                                echo $_SESSION['dados']['telefone_nota_pj'];
                            }
                            ?>">
                        </div>
                    </div>

                    <div class="form-row" id="5" name="5" style="display:none">
                        <div class="form-group col-md-5">
                            <label>                                
                                Endereço p/ Nota Fiscal
                            </label>
                            <textarea name="endereco_nota_pj" type="text" class="form-control" id="endereco_nota_pj" placeholder="Endereço Completo para emissão da nota fiscal: Rua, Bairro, CEP, Cidade, Estado"><?php
                                if (isset($_SESSION['dados']['endereco_nota_pj'])) {
                                    echo $_SESSION['dados']['endereco_nota_pj'];
                                }
                                ?></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                E-mail p/ Nota Fiscal
                            </label>
                            <input name="email_nota_pj" type="email" class="form-control email" maxlength="220" placeholder="E-mail para ser emitido a Nota Fiscal" id="email_nota_pj" value="<?php
                            if (isset($_SESSION['dados']['email_nota_pj'])) {
                                echo $_SESSION['dados']['email_nota_pj'];
                            }
                            ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="form-row" id="co-autores" name="co-autores">
                        <div class="form-group col-md-5">
                            <label>                                
                                Coautores (limite 10)
                            </label>
                            <input name="nomeCoautor[]" type="text" class="form-control" id="nomeCoautor[]" maxlength="220" placeholder="Nome" value="<?php
                            if (isset($_SESSION['dados']['nomeCoautor[]'])) {
                                echo $_SESSION['dados']['nomeCoautor[]'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                E-mails
                            </label>
                            <input name="emailCoautor[]" type="email" class="form-control" placeholder="E-mail" id="emailCoautor[]"  maxlength="100"  value="<?php
                            if (isset($_SESSION['dados']['emailCoautor[]'])) {
                                echo $_SESSION['dados']['emailCoautor[]'];
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
            function mostradivtitulolivro2() {
                var select = $("#adms_area_id").val();
                if (select == "1000") {
                    document.getElementById('1000').style = '';

                } else {
                    document.getElementById('1000').style.display = 'none';
                }
            }
            function mostradiv2() {
                var select = $("#nota_outro_nome").val();
                if (select == "2") {
                    document.getElementById('2').style = '';
                    document.getElementById('4').style = '';
                    document.getElementById('3').style.display = 'none';
                    document.getElementById('5').style.display = 'none';
                }
                if (select == "3") {
                    document.getElementById('2').style.display = 'none';
                    document.getElementById('4').style.display = 'none';
                    document.getElementById('3').style = '';
                    document.getElementById('5').style = '';
                } else {
                    document.getElementById('1').style.display = 'none';
                }
            }
            mostradivtitulolivro2();
            mostradiv2();

            function mostradivtitulolivro(div) {
                if (div == '1000') {
                    document.getElementById('1000').style = '';

                } else {
                    document.getElementById('1000').style.display = 'none';
                }
            }

            function mostradiv(div) {
                if (div == '1') {
                    document.getElementById('2').style.display = 'none';
                    document.getElementById('3').style.display = 'none';
                    document.getElementById('4').style.display = 'none';
                    document.getElementById('5').style.display = 'none';

                }
                if (div == '2') {
                    document.getElementById('2').style = '';
                    document.getElementById('4').style = '';
                    document.getElementById('3').style.display = 'none';
                    document.getElementById('5').style.display = 'none';

                }
                if (div == '3') {
                    document.getElementById('2').style.display = 'none';
                    document.getElementById('4').style.display = 'none';
                    document.getElementById('3').style = '';
                    document.getElementById('5').style = '';

                }
            }

            function ocutardiv(div) {
                document.getElementById(div).style.display = 'none';
            }

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
                var campos_max = 10;   //max de 5 campos
                var x = 1; // campos iniciais
                var cont = 1;
                $('#add_field').click(function (e) {
                    cont++;
                    e.preventDefault();     //prevenir novos clicks
                    if (x < campos_max) {
                        $('#co-autores').append('\
                                <div id="campo_nome' + cont + '" class="form-group col-md-5"><input name="nomeCoautor[]" type="text" class="form-control" maxlength="220" id="nomeCoautor[]" placeholder="Nome" value=""></div>\
                                <div id="campo_email' + cont + '" class="form-group col-md-4"><input name="emailCoautor[]" type="text" class="form-control" id="emailCoautor[]" maxlength="14" placeholder="E-mail" value=""></div>\
                                <div id="campo_botao' + cont + '" class="form-group col-md-3"><button id="' + cont + '" type="button" class="btn btn-danger btn-remover_campo"><i class="fas fa-minus-circle"></i></button></div>\
                                ');
                        x++;
                    }
                });

                // Remover o div anterior
                $('form').on('click', '.btn-remover_campo', function () {
                    var button_id = $(this).attr("id");
                    $('#campo_nome' + button_id + '').remove();
                    $('#campo_email' + button_id + '').remove();
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


