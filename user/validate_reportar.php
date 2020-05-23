<?php
require '../db.php';
require '../session.php';
        if(isset($_GET['reportante'])){
            if($_SESSION['verificado']==true){
                $reportado = $_POST['reportado'];
                $reportante = $_GET['reportante'];
                $motivo = $_POST['chat']. $_POST['juego'];
                $pruebas = $_POST['pruebas'];

                $sql = 'SELECT * FROM users WHERE Username="'.$_POST['reportado'].'"';
                $query = $con->query($sql);

                if($query->num_rows == 1){//El reportado existe
                    $insert_reportes = $con->query('INSERT INTO reportes (Reportado,Reportante,Motivo,Pruebas) VALUES ("'.$reportado.'","'.$reportante.'","'.$motivo.'","'.$pruebas.'")');
                    $insert_reportes = $con->query('INSERT INTO log (User,Action) VALUES ("'.$reportante.'","Creó un reporte hacia '.$reportado.'")');
                    $_SESSION['success'] = 'reportado_corecto';
                    header ('location: reportar.php');
                }else{//No existe el reportado, lanzamos error a reportes.php
                    $_SESSION['error'] = 'user_null';
                    header ('location: reportar.php');
                }
            }else{//Usuario no verificado, lanzar error a reportes.php
                $_SESSION['error'] = 'not_verified';
                header ('location: reportar.php');
            }
            
        }
?>