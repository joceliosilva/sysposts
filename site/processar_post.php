<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o usuário está logado
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $post_content = $_POST['post_content'];

    if (strlen($post_content) < 10) {
    $_SESSION['message'] = "O post deve conter pelo menos 10 caracteres.";
    header("Location: dashboard.php");
    exit();
}

    // Insere o novo post no banco de dados
    $sql = "INSERT INTO posts (user_id, post_content) VALUES ($user_id, '$post_content')";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
    } else {
        $_SESSION['message'] = "Erro ao criar o post: " . $conn->error;
        header("Location: dashboard.php");
    }
}

$conn->close();
?>
