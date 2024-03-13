<?php

    include __DIR__ . '/../conexion.php';

    $contador = 0;

    foreach ($_POST as $clave => $valor) {
        if($contador >= 2){
            //echo "Se actualizará el valor del campo ".$clave." con el valor ".$valor."<br>";

            $peticion = "
            UPDATE ".$_POST['tabla']."
            SET ".$clave." = '".$valor."'
            WHERE
            Identificador = ".$_POST['id']."

            ";
            mysqli_query($link, $peticion);

        }
        $contador++;
    }
    echo '<meta http-equiv="refresh" content="1; url=index.php?tabla='.$_POST['tabla'].'">';

?>