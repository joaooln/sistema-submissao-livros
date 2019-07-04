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
        <link href="css/signin.css" rel="stylesheet">
    </head>
    <body class="text-center">

        <form method="POST" class="form-signin" action="valida.php">
            <img class="mb-4" src="imagens/logo.png" alt="" width="290" height="112">
            <h1 class="h3 mb-3 font-weight-normal">Área do Autor</h1>
            <label for="inputEmail" class="sr-only">E-mail</label>
            <input type="email" name="email" class="form-control" placeholder="E-mail" required autofocus>
            <label for="inputPassword" class="sr-only">Senha</label>
            <input type="password" name="senha" class="form-control" placeholder="Senha" required>

            <button name="btnLogin" class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>

            <p class="text-center text-danger">
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
            </p>

            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Ainda não tem cadastro? Cadastre-se</a>
            <a class="dropdown-item" href="#">Esqueceu a senha?</a>

            <p class="mt-5 mb-3 text-muted">&copy; 2019</p>
        </form>



        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </body>
</html>
