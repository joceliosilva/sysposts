
<!DOCTYPE html>
<html>
<head>
    <title>Login - Sistema de Posts</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Inclua os arquivos CSS e JavaScript do Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    

</head>
<body>
    <header>
        <h1>Cadastro</h1>
    </header>
    </header>
    <main >
        <div class="separator"></div>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="processar_cadastro.php" method="POST">
                <div class="form-group">
                    <label for="username">Usuário:</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Senha:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Cadastar</button>

            </form>
              
              <p>Já tem uma conta? <a href="login.php">Faça login aqui</a>.</p>
        </div>
    </div>
</div>
   

    </main>
     

</body>

</html>

