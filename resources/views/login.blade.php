<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGP - Barreirinhas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<container class="login-box">
    <img src="img/logo-3.png" alt="logotipo do IFMA campus Barreirinhas" id="login-img">
    <br>
    <br>
    <h4>Sistema de Gestão de Pessoas</h4>
    <hr>
    <form method="POST" action="login" class="form-group">
        @csrf
        <label for="usr">Usuário:</label>
        <input type="text" name="usr" id="usr" placeholder="Digite sua matrícula aqui" class="form-control" required autocomplete="off" autofocus>
        <label for="pwd">Senha:</label>
        <input type="password" name="pwd" id="pwd" class="form-control" placeholder="Digite sua senha" required autocomplete="off">
        <br>

        <button type="submit" class="btn-primary form-control">Enviar</button>
        
    <div class="login-error-msg">{{ $msg ?? '' }}</div>
    </form>
</container>
</body>
</html>