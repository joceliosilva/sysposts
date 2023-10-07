<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Sistema de Posts</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>

         <?php
        session_start();
        if (isset($_SESSION['username'])) {
          
             $user =  $_SESSION['username'];
        
        } else {
            header("Location: login.php"); // Redirecionar se não estiver logado
            exit();
        }
        
        ?>
        <h1>Dashboard</h1>
        <p>Olá <?php echo" $user !" ?></p>
        

      
    </header>
    <main>

        <div class="container">
            
                     <section class="posts">
   <?php
require_once "db.php";

// Verifique se o ID do post foi fornecido na URL
if (isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];

    // Consulta para obter o post completo com base no ID, incluindo o autor
    $sql = "SELECT posts.*, users.username AS author FROM posts INNER JOIN users ON posts.user_id = users.user_id WHERE post_id = $postId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<h1>{$row['title']}</h1>";
        echo "<p>Autor: {$row['author']}</p>";
        echo "<p class='post-content'>{$row['post_content']}</p>";
         echo "<a href='like.php?post_id={$row['post_id']}'>Curtir</a>";
                     

    } else {
        echo "<p>Post não encontrado.</p>";
    }

    $conn->close();
} else {
    echo "<p>ID do post não especificado.</p>";
}
?>


            </section>
        </div>
    </main>
    <script>
    // Adicione um evento de clique ao botão "Inserir Post"
    document.getElementById('inserir-post-btn').addEventListener('click', function() {
        // Encontre a text area e o label usando seus IDs
        var textarea = document.getElementById('form');
        

        // Alterne a visibilidade da text area e do label
        if (textarea.style.display === 'none') {
            textarea.style.display = 'block';
           
        } else {
            textarea.style.display = 'none';
            
        }
    });
</script>

</body>
<?php include 'includes/footer.php'; ?>

</html>
