<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check_query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($check_query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            header("Location: dashboard.php");
        } else {
            $_SESSION['message'] = "Senha incorreta. Tente novamente.";
            header("Location: login.php");
        }
    } else {
        $_SESSION['message'] = "Nome de usuário não encontrado.";
        header("Location: login.php");
    }
}

$conn->close();
?>
