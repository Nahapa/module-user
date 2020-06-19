<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet" href="{{ asset(mix('assets/admin/css/reset.css')) }}"/>
    <link rel="stylesheet" href="{{ asset(mix('assets/admin/css/boot.css')) }}"/>
    <link rel="stylesheet" href="{{ asset(mix('assets/admin/css/login.css')) }}"/>
    <link rel="icon" type="image/png" href="{{ asset('assets/admin/images/favicon.png') }}"/>

    <title>{{ config('app.name') }} - Login</title>
</head>
<body>

<div class="ajax_response"></div>

<div class="dash_login">
    <div class="dash_login_left">
        <article class="dash_login_left_box">
            <header class="dash_login_box_headline">
                <div class="dash_login_box_headline_logo icon-imob icon-notext"></div>
                <h1>Login</h1>
            </header>

            <form name="login" action="{{ route(\Section::get('login.route_login')) }}" method="POST" autocomplete="off">
                @csrf
                <label>
                    <span class="field icon-user">Usuário:</span>
                    <input type="text" name="username" placeholder="Informe seu usuário ou email" required/>

                    @error('username')
                        <span class="text-red" role="alert">
                            <h5><strong>{{ $message }}</strong></h5>
                        </span>
                    @enderror
                </label>

                <label>
                    <span class="field icon-unlock-alt">Senha:</span>
                    <input type="password" name="password" placeholder="Informe sua senha" required/>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </label>

                <button class="gradient gradient-primary radius icon-sign-in">Entrar</button>
            </form>

            <footer>
                <p>Desenvolvido por <a href="https://www.sistemasige.com.br">www.<b>sistemasige</b>.com.br</a></p>
                <p>&copy; <?= date("Y"); ?> - Todos os Direitos Reservados</p>
                <p class="dash_login_left_box_support">
                    <a target="_blank"
                       class="icon-whatsapp transition text-green"
                       href="https://api.whatsapp.com/send?phone=DDI+DDD+TELEFONE&text=Olá, preciso de ajuda com o login."
                    >Precisa de Suporte?</a>
                </p>
            </footer>
        </article>
    </div>

    <div class="dash_login_right"></div>

</div>

<script src="{{ asset(mix('assets/admin/js/libs.js')) }}"></script>

</body>
</html>
