<?php
require '../db.php';

$buscar = $_GET['term'];

$sql = "SELECT * FROM users WHERE Username LIKE '".$buscar."%' ORDER BY Username ASC";

$query = $con->query($sql);

$retorno = array();

if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){
       $datos['id'] = $row['Id']; 
       $datos['value'] = $row['Username'];
       array_push($retorno,$datos);
    }

}


echo json_encode($retorno);



?>