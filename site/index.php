<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Posts</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
        <h1>Bem-vindo ao Sistema de Posts</h1>
    </header>
    <main>

        <div class="container">
            <section class="posts">
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
                        echo "<p font-color=blue;>{$row['author']}</p>";
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

                $conn->close(); ?>
            </section>
        </div>
    </main>
    <footer>
        <a href="login.php">Login</a> | <a href="cadastro.php">Cadastro</a>
    </footer>
</body>
</html>
