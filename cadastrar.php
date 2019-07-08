<?php
session_start();
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Sistema de Submissão de Capitulos e Livros">
        <meta name="author" content="João de Oliveira Lima Neto">
        <meta name="generator" content="Jekyll v3.8.5">
        <title>SS Editora - Área do Autor</title>

        <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/sign-in/">

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
        <!-- Custom styles for this template -->
        <link href="css/dashboard.css" rel="stylesheet">
        <link href="css/all.min.css" rel="stylesheet">

    </head>
    <body>

        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <a class="sidebar-toggle text-light mr-3">
                <span class="navbar-toggler-icon"></span>
            </a>
            <a class="navbar-brand" href="#">SS Editora</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle menu-header" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown">
                            <img class="rounded-circle" src="imagens/logo.png" width="20" height="20"> &nbsp;<span class="d-none d-sm-inline">Usuário</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#"><i class="fas fa-user"></i> Perfil</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt"></i> Sair</a>
                        </div>
                    </li>
                </ul>                
            </div>
        </nav>

        <div class="d-flex">
            <nav class="sidebar">
                <ul class="list-unstyled">
                    <li><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li>
                        <a href="#submenu1" data-toggle="collapse">
                            <i class="fas fa-user"></i> Usuário
                        </a>
                        <ul id="submenu1" class="list-unstyled collapse">
                            <li><a href="listar.php"><i class="fas fa-users"></i> Usuários</a></li>
                            <li><a href="#"><i class="fas fa-key"></i> Nível de Acesso</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#submenu2" data-toggle="collapse"><i class="fas fa-list-ul"></i> Menu</a>
                        <ul id="submenu2" class="list-unstyled collapse">
                            <li><a href="#"><i class="fas fa-file-alt"></i> Páginas</a></li>
                            <li><a href="#"><i class="fab fa-elementor"></i> Item de Menu</a></li>
                        </ul>

                    </li>
                    <li><a href="#"> Item 1</a></li>
                    <li><a href="#"> Item 2</a></li>
                    <li><a href="#"> Item 3</a></li>
                    <li class="active"><a href="#"> Item 4</a></li>
                    <li><a href="#"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                </ul>
            </nav>
            <div class="content p-1">
                <div class="list-group-item">
                    <div class="d-flex">
                        <div class="mr-auto p-2">
                            <h2 class="display-4 titulo">Cadastrar</h2>
                        </div>
                        <a href="listar.php">
                            <div class="p-2">
                                <button class="btn btn-outline-info btn-sm">
                                    Listar
                                </button>
                            </div>
                        </a>
                    </div>
                    <hr>
                    <form>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label><span class="text-danger">* </span>Nome</label>
                                <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome Completo " required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><span class="text-danger">* </span>E-mail</label>
                                <input name="email" type="email" class="form-control" id="email" placeholder="E-mail" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label><span class="text-danger">* </span>Senha</label>
                                <input name="senha" type="password" class="form-control" id="senha" placeholder="Informe a senha" required>
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Sua senha deve ter de 8 a 20 caracteres, conter letras e números e não conter espaços, caracteres especiais ou emojis.
                                </small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><span class="text-danger">* </span>Confirmar a Senha</label>
                                <input name="conf_senha" type="password" class="form-control" id="conf_senha" placeholder="Confirme a senha" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label><span class="text-danger">* </span>Endereço</label>
                                <input name="endereco" type="text" class="form-control" id="endereco" placeholder="Rua João..." required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label><span class="text-danger">* </span>Número</label>
                                <input name="numero" type="text" class="form-control" id="numero" placeholder="123" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Complemento</label>
                                <input name="complemento" type="text" class="form-control" id="complemento" placeholder="Bloco, Apartamento..." required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-5 mb-3">
                                <label><span class="text-danger">* </span>Estado</label>
                                <select name="estado" id="estado" class="custom-select" required>
                                    <option value="">Selecione</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label><span class="text-danger">* </span>Cidade</label>
                                <select name="cidade" id="cidade" class="custom-select" required>
                                    <option value="">Selecione</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label><span class="text-danger">* </span>CEP</label>
                                <input name="cep" type="text" class="form-control" id="cep" placeholder="12345-678" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Exemplo 1</label>
                            <input name="exemplo1" type="text" class="form-control" id="exemplo1" placeholder="Exemplo 1" required>
                        </div>
                        <p>
                            <span class="text-danger">* </span>Campo Obrigatório
                        </p>
                        <button class="btn btn-success" type="submit">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="apagarRegistro" tabindex="-1" role="dialog" aria-labelledby="apagarRegistroLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Excluir Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Tem certeza que deseja exluir o item selecionado?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger">Apagar</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="js/dashboard.js" ></script>
        <script defer src="js/all.min.js"></script>

    </body>
</html>
