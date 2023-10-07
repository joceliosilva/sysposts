<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Sistema de Posts</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.16.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    
</head>
<body>
    <header>

         <?php
           
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
require_once "like.php";
       
        if (isset($_SESSION['username'])) {
          
             $user =  $_SESSION['username'];
        
        } else {
            header("Location: login.php"); // Redirecionar se não estiver logado
            exit();
        }
        
        ?>
        <h1>Dashboard</h1>
        <p>Olá <?php echo" $user !" ?></p>
            <button id="inserir-post-btn">Inserir Post</button>
            <a href="logout.php"><button id="inserir-post-btn">Sair</button></a>

      
    </header>
    <main>

        <div class="container">
            <section class="posts">
                <!-- Formulário para criar um novo post -->
                <form id="form" action="processar_post.php" method="POST" style="display: none;">
               <center> <label for="post-title" id="post-title-label">Título: </label><input type="text" id="post-title" name="post_title" required></center> <br/>
                   <center><textarea class="textarea" name="post_content" rows="6" cols="50" required ></textarea></center>
                   <center><br/> <input type="submit" value="Enviar Post" ></center>
                </form>
                <!-- Exibir os posts dos usuários aqui -->
                <section>
                <?php
                require_once "db.php";


                // Consulta para obter os posts

                $posts_per_page = 10; // Número de posts por página
                $page = isset($_GET['page']) ? $_GET['page'] : 1; // Página atual

                $start = ($page - 1) * $posts_per_page;

                $sql = "SELECT posts.*, users.username AS author FROM posts INNER JOIN users ON posts.user_id = users.user_id ORDER BY post_id DESC LIMIT $start, $posts_per_page";

                $result = $conn->query($sql);

                
                 // Consulta SQL para contar o número total de posts
                $count_sql = "SELECT COUNT(*) as total FROM posts";
                $count_result = $conn->query($count_sql);

                if ($count_result) {
                    $row = $count_result->fetch_assoc();
                    $total_posts = $row['total'];
                } else {
                    $total_posts = 0; // Defina um valor padrão em caso de erro
                }


               if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='post'>";
                    echo "<p><strong><a href='post_completo.php?post_id={$row['post_id']}'>{$row['title']}</a></strong></p>"; // Título como link
                    //echo "<p>Autor: {$row['author']}</p>";
                   

                     $excerpt = substr($row['post_content'], 0, 150);

                    echo "<p class='post-excerpt'>$excerpt...</p>";
                    
                    echo "<div class='likeunlike'>";
                     
                   echo '<span id="like-count">';
echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">';
echo '<path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>';
echo '</svg>';
echo '&nbsp;'. getLikeCount($row['post_id']);
echo '</span>';  
                     echo "<span id='unlike-count'>" . getLikeCount($row['post_id']) . "</span>";
                    echo "</div>";

                    echo "</div>";
                }
}           else {
    echo "<p>Nenhum post disponível.</p>";
}
                    
                    $total_pages = ceil($total_posts / $posts_per_page); // $total_posts é o total de posts no banco de dados

                    // Links para páginas anteriores e próximas
                    if ($page > 1) {
                        echo "<a href='dashboard.php?page=".($page - 1)."'>Página Anterior</a>";
                    }
                    if ($page < $total_pages) {
                        echo "<a href='dashboard.php?page=".($page + 1)."'>Próxima Página</a>";
                    }

              //  $conn->close();
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
