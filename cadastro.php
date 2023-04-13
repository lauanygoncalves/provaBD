<?php
header('Access-Control-Allow-Origin: *');

//conexão com o Banco de Dados do adiministrador da página.
$connect = new PDO("mysql:host=localhost;dbname=id20420997_bdjogolauany", "id20420997_lauanybarbosa", "Aa111111--Bb");
$received_data = json_decode(file_get_contents("php://input"));
$data = array();

// Verifica se a variável "$received_data->action é igual a 'fetchall', se for verdadeira o que está dentro de {} será executado
if ($received_data->action == 'fetchall') {
    $query = "
 SELECT * FROM fatec_alunos 
 ORDER BY id DESC
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    //É usado para retornar uma resposta em formato JSON a partir de um script PHP. A função converte o valor da variavel "$data" em uma string JSON válida, que é enviada através do comando "echo"
    echo json_encode($data);
}
// Verifica a variavel é "insert" e insere os dados recebidos
if ($received_data->action == 'insert') {
    $data = array(
        ':first_name' => $received_data->firstName,
        ':last_name' => $received_data->lastName
    );

    $query = "
 INSERT INTO fatec_alunos 
 (first_name, last_name) 
 VALUES (:first_name, :last_name)
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Aluno Adicionado'
    );

    echo json_encode($output);
}

// Verifica a variavel é 'fetchSingle' e seleciona um dado específico
if ($received_data->action == 'fetchSingle') {
    $query = "
 SELECT * FROM fatec_alunos 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    //Utilizado para percorrer um conjunto de dados usando um loop. A variavel "result" é fonte dos dados a serem iterados e a variável "row" é usada como um ponteiro para o elemento atual.
    foreach ($result as $row) {
        $data['id'] = $row['id'];
        $data['first_name'] = $row['first_name'];
        $data['last_name'] = $row['last_name'];
    }

    echo json_encode($data);
}
//Verifica a variavel é 'update' e atualiza os dados
if ($received_data->action == 'update') {
    $data = array(
        ':first_name' => $received_data->firstName,
        ':last_name' => $received_data->lastName,
        ':id' => $received_data->hiddenId
    );
//Faz uma instrução para executar essa consulta no banco de dados
    $query = "
 UPDATE fatec_alunos 
 SET first_name = :first_name, 
 last_name = :last_name 
 WHERE id = :id
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Aluno Atualizado'
    );

    echo json_encode($output);
}
// Verifica a variavel é 'delete' e deleta os dados
if ($received_data->action == 'delete') {
    $query = "
 DELETE FROM fatec_alunos 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $output = array(
        'message' => 'Aluno Deletado'
    );

    echo json_encode($output);
}

?>