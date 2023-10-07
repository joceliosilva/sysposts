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
            <button id="inserir-post-btn">Inserir Post</button>
            <button id="inserir-post-btn">Sair</button>

      
    </header>
    <main>

        <div class="container">
            <section class="posts">
                <!-- Formulário para criar um novo post -->
                <form id="form" action="processar_post.php" method="POST" style="display: none;">
                    <center><label for="post-title" id="post-title-label">Título:</label></center> <br/>
                <center><input type="text" id="post-title" name="post_title"></center> <br/>
                   <center><textarea class="textarea" name="post_content" rows="6" cols="50" ></textarea></center>
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
                        echo "<p>{$row['author']}</p>";
                        echo "<p>{$row['post_content']}</p>";
                        echo "<a href='like.php?post_id={$row['post_id']}'>Curtir</a>";
                        echo "</div>";
                    }
                } else {
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

                $conn->close();
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
