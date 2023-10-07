<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifique se o nome de usuário já existe
    $check_query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        $_SESSION['message'] = "O nome de usuário já está em uso.";
        header("Location: cadastro.php");
    } else {
        // Insira o novo usuário no banco de dados
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$password_hash')";

        if ($conn->query($insert_query) === TRUE) {
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
        } else {
            $_SESSION['message'] = "Erro no cadastro: " . $conn->error;
            header("Location: cadastro.php");
        }
    }
}

$conn->close();
?>
