<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Sistema de Posts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <header>
        <?php
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
            require_once "like.php";
            require_once "unlike.php";
       
            if (isset($_SESSION['username'])) {
                $user =  $_SESSION['username'];
            } else {
                header("Location: login.php"); // Redirecionar se não estiver logado
                exit();
            }
        ?>
        <h1>Página Inicial</h1>
        <p>Olá <?php echo" $user !" ?></p>
        <button id="inserir-post-btn" class="btn btn-secondary">Inserir Post</button>
        <a href="logout.php"><button id="inserir-post-btn" class="btn btn-secondary">Sair</button></a>
    </header>
    <main>
        <div class="container">
            <section class="posts">
                <!-- Formulário para criar um novo post -->
                <form id="form" action="processar_post.php" method="POST" style="display: none;">
                    <center><label for="post-title" id="post-title-label">Título:</label>&nbsp;
                    <input type="text" id="post-title" name="post_title" class="form-control" required></center><br/>
                    <center><textarea class="textarea form-control" name="post_content" rows="6" cols="50" required ></textarea></center>
                    <center><br/><input type="submit" class="btn btn-primary" value="Enviar Post" ></center>
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
                            $excerpt = substr($row['post_content'], 0, 150);
                            echo "<p class='post-excerpt'>$excerpt...</p>";
                            echo "<div class='likeunlike'>";
                            echo '<span id="like-count">';
                            echo '<i class="bi bi-hand-thumbs-up"></i>';
                            echo '&nbsp;' . getLikeCount($row['post_id']);
                            echo '</span>';  
                            echo '<span id="unlike-count">';
                            echo '<i class="bi bi-hand-thumbs-down"></i>';
                            echo '&nbsp;' . getUnLikeCount($row['post_id']);
                            echo '</span>';  
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Nenhum post disponível.</p>";
                    }

                    $total_pages = ceil($total_posts / $posts_per_page); // $total_posts é o total de posts no banco de dados

                    // Links para páginas anteriores e próximas
                    if ($page > 1) {
                        echo "<a href='dashboard.php?page=".($page - 1)."' class='btn btn-primary'>Página Anterior</a>";
                    }
                    if ($page < $total_pages) {
                        echo "<a href='dashboard.php?page=".($page + 1)."' class='btn btn-primary'>Próxima Página</a>";
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
