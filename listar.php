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
                            <h2 class="display-4 titulo">Usuários</h2>
                        </div>
                    </div>
                    <div class="alert alert-success" role="alert">
                        Usuário apagado com sucesso!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th class="d-none d-sm-table-cell">E-mail</th>
                                    <th class="d-none d-lg-table-cell">Data de Cadastro</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>1</th>
                                    <td>Cesár</td>
                                    <td class="d-none d-sm-table-cell">cesar@celke.com.br</td>
                                    <td class="d-none d-lg-table-cell">05/12/2017 11:44:39</td>
                                    <td class="text-center">
                                        <span class="d-none d-md-block">
                                            <a href="visualizar.php" class="btn btn-outline-primary btn-sm">Visualizar</a>
                                            <a href="editar.php" class="btn btn-outline-warning btn-sm">Editar</a>
                                            <a href="apagar.php" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#apagarRegistro">Apagar</a>
                                        </span>
                                        <div class="dropdown d-block d-md-none">
                                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Ações
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                                <a class="dropdown-item" href="visualizar.php">Visualizar</a>
                                                <a class="dropdown-item" href="editar.php">Editar</a>
                                                <a class="dropdown-item" href="apagar.php" data-toggle="modal" data-target="#apagarRegistro">Apagar</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
