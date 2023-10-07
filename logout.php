<?php
// Iniciar a sessão
session_start();

// Destruir a sessão
session_destroy();

// Redirecionar para a página de login ou qualquer outra página que você desejar após o logout
header("Location: login.php"); // Substitua "login.php" pela página desejada
exit(); // Certifique-se de encerrar o script para evitar qualquer saída adicional
?>
