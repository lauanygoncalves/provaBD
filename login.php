<?php
// Permite que criem paginas com conteudo dinamico com saida personalizada para contrlolar como os dados do script são exibidos para o usuário final
ob_start();

session_start(); // Inicia a sessão

require_once 'config.php';
// verifica se o método de solicitação HTPP utilizado para acessar uma pagina é do tipo "Post" - Requisição do login 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email_login'];
    $senha = $_POST['senha_login'];

    // Verifica se o email e senha são válidos
    $query = "SELECT id, nome FROM fatec_admin WHERE email='$email' AND senha=md5('$senha')";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['id'];
        $_SESSION['nome'] = $row['nome'];
        header('Location: dashboard.html'); // Redireciona para a página de dashboard
    } else { // Se estiver incorretos aparece a mensagem que estão incorretos
        echo '<script>alert("Email ou senha incorretos!")</script>'; 
        header("Location: index.html#paralogin");               
    }
}
// Função usada para liberar o cnoteúdo do buffer de saida e enviar os dados para o navegador imediatamente
ob_end_flush();

?>

