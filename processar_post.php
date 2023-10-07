<?php
// Desativa o cache
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o usuário está logado
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    if (isset($_SESSION['user_id']) && isset($_POST['post_title']) && isset($_POST['post_content'])) {
    $userId = $_SESSION['user_id'];
    $postTitle = $_POST['post_title'];
    $postContent = $_POST['post_content'];

    // Evite SQL Injection usando declarações preparadas
    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, post_content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $userId, $postTitle, $postContent);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Post enviado com sucesso!";
    } else {
        $_SESSION['message'] = "Erro ao enviar o post.";
    }

    $stmt->close();
    $conn->close();
} else {
    $_SESSION['message'] = "Erro ao enviar o post. Certifique-se de estar logado e que todos os campos foram preenchidos.";
}

header("Location: dashboard.php");
exit();
}
?>


 if (strlen($post_content) < 10) {
    $_SESSION['message'] = "O post deve conter pelo menos 10 caracteres.";
    header("Location: dashboard.php");
    exit();
