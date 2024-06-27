<?php
require_once('../connect.php');

session_start();
if(isset($_SESSION['email'])) {
    if (isset($_POST['titulo'])){
        try {
            // Preparando variáveis para inserção no BD
            $titulo = $_POST['titulo'];
            $recado = $_POST['recado'];
            $validade = $_POST['validade'];
            $username = ucfirst($_POST['username']);
            $date = date('Y-m-d H:i:s');
            
            if ($validade === ''){
                $validade = null;
            }
            
            // Conectando ao BD e inserindo novos dados
            $sql = connect();
            $query = $sql->prepare("INSERT INTO recado (titulo, recado, data, validade, sepae_username) VALUES (?, ?, ?, ?, ?)");
            $query->bind_param("sssss", $titulo, $recado, $date, $validade, $username);
            $query->execute();
            header('Location: ../index.php');
        }catch (Exception $e) {
            error_log($e->getMessage());
            exit("<br>Alguma coisa estranha aconteceu");
        }
    }
} else{
	echo json_encode(0);
    header('Location: ../index.php');
}
?>