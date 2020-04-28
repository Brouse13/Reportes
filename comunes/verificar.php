<?php
    function generarCodigo($longitud) {//Genera un código aleatorio depeniendo de la lungitud dada como parámetro
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
        return $key;
       }


    $sql = 'SELECT * FROM users WHERE Username="'.$_SESSION['User'].'"';
    if($result = $con->query($sql)){
        while($row = $result->fetch_array()){
            if($row['Uuid']==NULL){//El user no está registrado
                if($row['Verification_Code']==NULL){//Primera vez que entra el user
                    $Code = generarCodigo(5);
                    if($stm = $con->query('UPDATE users SET Verification_Code="'.$Code.'" WHERE Username="'.$_SESSION['User'].'"')){
                        echo '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>
                        Por favor, usa el código '.$code.' en minecraft para verificar la cuenta</div>';
                    }
                }
                echo '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>
                Por favor, usa el código '.$row['Verification_Code'].' en minecraft para verificar la cuenta</div>';
            }
        }
    }
?>