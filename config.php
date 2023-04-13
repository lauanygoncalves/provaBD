<?php
//Dados do banco de dados do administrador 
$host = "localhost"; // nome do servidor MySQL
$user = "id20420997_lauanybarbosa"; // usuário do MySQL
$pass = "Aa111111--Bb"; // senha do MySQL
$dbname = "id20420997_bdjogolauany"; // nome do banco de dados

// Conexão com o banco de dados MySQL
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Verifica se houve erro na conexão e retorna a mensagem
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}
