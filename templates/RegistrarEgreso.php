<?php
include '../funciones/conexion.php';
include '../header.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $id_revision = $_POST['id_revision'];
    $fecha_egreso = $_POST['fegreso'];


    $query = "UPDATE revision SET fegreso = '$fecha_egreso', estado = 'Finalizado' WHERE cod_revision = $id_revision";
    $resultado = mysqli_query(conectarDB(), $query);

    if($resultado){

        header( 'refresh:5; url=/templates/ListarRevision.php' ); //Redireccion en 5 segundos

        ?>

        <div class="mt-4 container w-75 alert alert-success" role="alert">
            <strong>Se registro el egreso correctamente. Serás redireccionado en 5 segundos</strong>
        </div>

        <?php

    }else{

        
        ?>

        <div class="mt-4 container w-75 alert alert-danger" role="alert">
            <strong>Verificar código SQL</strong>
        </div>

        <?php

    }


}


if($_SERVER['REQUEST_METHOD'] === 'GET'){

    $id_revision = $_GET['id'];

    $query = "SELECT * FROM revision r JOIN auto a ON r.cod_auto = a.cod_auto JOIN cliente c ON a.cod_cliente = c.cod_cliente WHERE cod_revision = $id_revision";
    $resultado = mysqli_query(conectarDB(), $query);
    $r = mysqli_fetch_assoc($resultado);

    
    if ($resultado){

    ?>
    <div class="mt-3 container w-50">

        <form action="/templates/RegistrarEgreso.php" method="POST">

            <div class="form-group">
              <label for="">ID Revisión</label>
              <input type="text" readonly class="form-control" name="id_revision" id="" value="<?php echo $r['cod_revision'] ?>">
            </div>

            <div class="form-group">
              <label for="">Fecha Ingreso</label>
              <input type="text" readonly class="form-control" name="" id="" value="<?php echo $r['fingreso'] ?>">
            </div>

            <div class="form-group">
              <label for="">Fecha Egreso</label>
              <input type="date" min="<?php echo$r['fingreso'] ?>" required class="form-control" name="fegreso" id="">
            </div>

            <button type="submit" class="btn btn-primary">Registrar Egreso</button>
            
            
        </form>
            
    </div>
    <?php

}


}





include '../footer.php';
?>
