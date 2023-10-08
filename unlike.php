
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "db.php";

if (isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];
    $userId = $_SESSION['user_id'];

    // Verifique se o usuário já curtiu este post
    $sql = "SELECT * FROM likes WHERE post_id = $postId AND user_id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows === 0) {
        // O usuário ainda não curtiu este post, registre a curtida
        $insertSql = "INSERT INTO unlikes (post_id, user_id) VALUES ($postId, $userId)";
        if ($conn->query($insertSql) === TRUE) {
            echo "Unlike registrado com sucesso.";
        } else {
            echo "Erro ao registrar a curtida: " . $conn->error;
        }
    } else {
        echo "Você já curtiu este postS.";
    }
}// else {
//    echo "ID do post não especificado.";
//}

//$conn->close();

function getUnLikeCount($postId) {
    global $conn; // Declare a variável global para acessar a conexão

    // Reabra a conexão com o banco de dados, se necessário
    if ($conn->connect_error) {
        $conn = new mysqli($db_host, $db_user, $db_password, $db_name);
    }

    $sql = "SELECT COUNT(*) AS like_count FROM unlikes WHERE post_id = $postId";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['like_count'];
    } else {
        return 0; // Retorna 0 se não houver curtidas para o post
    }


}


?>