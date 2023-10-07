<!DOCTYPE html>
<html>
<head>
    <title>Cadastro - Sistema de Posts</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
        <h1>Cadastro</h1>
    </header>
    <main>
        <div class="container">
            <form action="processar_cadastro.php" method="POST">
                <label for="username">Nome de Usuário:</label>
                <input type="text" id="username" name="username" required><br><br>

                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required><br><br>

                <input type="submit" value="Cadastrar">
            </form>
            <p>Já tem uma conta? <a href="login.php">Faça login aqui</a>.</p>
        </div>
    </main>
</body>
</html>
