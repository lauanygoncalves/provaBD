<?php

header('Access-Control-Allow-Origin: *');

//conexão com o Banco de Dados do administrador da página.
$connect = new PDO("mysql:host=localhost;dbname=id20420997_bdjogolauany", "id20420997_lauanybarbosa", "Aa111111--Bb");

$received_data = json_decode(file_get_contents("php://input"));
//Cria uma variavel e define como vazia para armazenar valores durante a execução do programa.
$data = array();

//solicita informações ou consulta o banco de dados
if($received_data->query != '')
{
	$query = "
	SELECT * FROM fatec_alunos 
	WHERE first_name LIKE '%".$received_data->query."%' 
	OR last_name LIKE '%".$received_data->query."%' 
	ORDER BY id DESC
	";
}
else
{
	$query = "
	SELECT * FROM fatec_alunos 
	ORDER BY id DESC
	";
}
// Prepara uma consulta SQL que será executada em um banco de dados usando uma conexão estabelecida anteriormente, armazenando o resultado na variavel "$statement" para posterior manipulação dos resuoltados
$statement = $connect->prepare($query);

//Executa uma consulta SQL que foi previamente preparada em um objeto "$statement". Ele envia a consulta para Banco de Dados e armazena o resultado na variavel, que pode ser acessada posteriormente.
$statement->execute();

while($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$data[] = $row;
}

echo json_encode($data);

?>