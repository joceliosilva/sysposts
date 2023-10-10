<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Sistema de Posts</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="js/script.js"></script>

    
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
        echo '<div id= "tt">';
        echo '<span id="like-count">';
        echo "<a href='like.php?post_id={$row['post_id']}'><i class='glyphicon glyphicon-thumbs-up'></i></a>";
        echo '</span>';

         
        echo '<span id="unlike-count">';
        echo "<a href='unlike.php?post_id={$row['post_id']}' ><i class='glyphicon glyphicon-thumbs-down'></i></a>";
        echo '</span>';
        echo "</div>" ;
        
        if (isset($_SESSION['likesend'])) {
            echo "<script> toastr.success('Curtido!');</script>";
            unset($_SESSION['likesend']); // Limpa a mensagem após exibi-la
            echo "<script>exibir();</script>";
            
        }
         if (isset($_SESSION['likeexist'])) {
            echo "<script> toastr.warning('Você ja curtiu esse post!');</script>";
            unset($_SESSION['likeexist']); // Limpa a mensagem após exibi-la
        } 
        if (isset($_SESSION['unlikesend'])) {
            echo "<script> toastr.success('Iremos Melhorar!');</script>";
             unset($_SESSION['unlikesend']); // Limpa a mensagem após exibi-la
             echo "<script>exibir();</script>";
        }
         if (isset($_SESSION['unlikeexist'])) {
            echo "<script> toastr.warning('Você ja descurtiu esse post!');</script>";
            unset($_SESSION['unlikeexist']); // Limpa a mensagem após exibi-la
        } 

       
      

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

      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
     <script src="js/script.js"></script>


</body>
<?php include 'includes/footer.php'; ?>

</html>
