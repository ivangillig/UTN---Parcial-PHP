<?php
include '../funciones/conexion.php';
include '../header.php';


$query = "SELECT * FROM auto";
$resultado = mysqli_query(conectarDB(), $query);

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $cod_auto = $_POST['auto'];
    $fingreso = $_POST['fingreso'];
    $kilometraje = $_POST['kilometraje'];
    $estado = $_POST['estado'];
    $cambio_filtro = $_POST['cambio_filtro'];
    $cambio_aceite = $_POST['cambio_aceite'];
    $cambio_freno = $_POST['cambio_freno'];
    $descripcion = $_POST['descripcion'];

    if($kilometraje > 100000){
        ?>
        <div class="mt-3 alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>Atención!</strong> Los vehiculos con más de 100mil kms tienen costo adicional.
        </div>
        <?php
    }

    $query = "SELECT * FROM revision r JOIN auto a ON r.cod_auto = a.cod_auto JOIN cliente c ON a.cod_cliente = c.cod_cliente WHERE r.cod_auto = $cod_auto";
    $resultado = mysqli_query(conectarDB(), $query);
    $r = mysqli_fetch_assoc($resultado);
    
    if ($resultado -> num_rows){

        if (($kilometraje - $r['km']) < 10000){
            header( 'refresh:4; url=/templates/RegistrarRevision.php' ); //Redireccion en 5 segundos
            ?>
          

            <div class="mt-3 alert alert-warning" role="alert">
                <strong>El vehiculo todavía no cumplió los 10mil kms desde la última revisión. Volviendo en 3 segundos...</strong>
            </div>

            <?php
        }else{
            //A la fecha de ingreso nueva, le resto un mes
            $fecha_ingreso = $fingreso;
            $pasounmes = date('Y-m-d',strtotime($fecha_ingreso.'- 1 month'));

            //Consulto a la base de datos si hay alguna revisión con fecha superior a la ingresada - 1 mes, para saber si pasaron 30 días desde la última o no
            $query3 = "SELECT * FROM revision r JOIN auto a ON r.cod_auto = a.cod_auto JOIN cliente c ON a.cod_cliente = c.cod_cliente WHERE r.cod_auto = $cod_auto AND  r.fingreso >= '$pasounmes'";
            $resultado3 = mysqli_query(conectarDB(), $query3);

            //Si la consulta es false, quiere decir que pasó más de un mes y procedo con la inserción.
            if(!$resultado3 -> num_rows){
              $query = "INSERT INTO revision (fingreso, estado, cambio_filtro, cambio_aceite, cambio_freno, descripcion, cod_auto) VALUES ('$fingreso', '$estado', '$cambio_filtro', '$cambio_aceite', '$cambio_freno', '$descripcion', $cod_auto)";
              $resultado = mysqli_query(conectarDB(), $query);

              //Actualizo el kilometraje del auto para saber después si cumple con el requisito de los 10mil kms
              $query2 = "UPDATE auto SET km = $kilometraje WHERE cod_auto = $cod_auto";
              $resultado2 = mysqli_query(conectarDB(), $query2);
      
              if ($resultado){
                  header( 'refresh:4; url=/templates/RegistrarRevision.php' ); //Redireccion en 5 segundos
                  ?>

                  <div class="mt-3 alert alert-success" role="alert">
                      <strong>Revisión agregada correctamente. Volviendo en 5 segundos...</strong>
                  </div>
      
                  <?php
                }else{
                  ?>
          

                  <div class="mt-3 alert alert-danger" role="alert">
                      <strong>Revisar SQL...</strong>
                  </div>
      
                  <?php
                }
            }else{
                header( 'refresh:4; url=/templates/RegistrarRevision.php' ); //Redireccion en 5 segundos
                ?>
                <div class="mt-3 alert alert-warning" role="alert">
                    <strong>Todavía no pasaron 30 días desde el último ingreso al taller. Volviendo en 3 segundos...</strong>
                </div>
    
                <?php
            }
          }
    }else{
        
        $query = "INSERT INTO revision (fingreso, estado, cambio_filtro, cambio_aceite, cambio_freno, descripcion, cod_auto) VALUES ('$fingreso', '$estado', '$cambio_filtro', '$cambio_aceite', '$cambio_freno', '$descripcion', $cod_auto)";
        $resultado = mysqli_query(conectarDB(), $query);

        //Actualizo el kilometraje del auto para saber después si cumple con el requisito de los 10mil kms
        $query2 = "UPDATE auto SET km = $kilometraje WHERE cod_auto = $cod_auto";
        $resultado2 = mysqli_query(conectarDB(), $query2);

        if ($resultado){
            header( 'refresh:4; url=/templates/RegistrarRevision.php' ); //Redireccion en 5 segundos
            ?>
          

            <div class="mt-3 alert alert-success" role="alert">
                <strong>Revisión agregada correctamente. Volviendo en 5 segundos...</strong>
            </div>

            <?php

        }else{
            ?>
            <div class="mt-3 alert alert-danger" role="alert">
                <strong>Revisar SQL...</strong>
            </div>

            <?php

        }
    }



}


if ($resultado){

    ?>
    <div class="container w-75 mt-3">

        <form action="/templates/RegistrarRevision.php" method="post">
            
            <div class="form-group">
              <label for="">Vehiculo</label>
              <select class="form-control" name="auto" id="">
                <?php while ($r =mysqli_fetch_assoc($resultado)): ?>
                <option value="<?php echo $r['cod_auto'] ?>"><?php echo $r['cod_auto'] . ' - ' . $r['marca'] . ' '. $r['modelo']?></option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="form-group">
            <label for="">Fecha de ingreso</label>
            <input type="date" class="form-control" name="fingreso" id="" >
            </div>

            <div class="form-group">
            <label for="">Kilometraje Actual</label>
            <input type="number" min="10000" required class="form-control" name="kilometraje" id="" >
            </div>

            <div class="form-group">
              <label for="">Estado</label>
              <select class="form-control" name="estado" id="">
                <option value="En espera">En espera</option>
                <option value="En revisión">En revisión</option>
              </select>
            </div>

            <div class="form-group">
              <label for="">Cambio de filtro</label>
              <select class="form-control" name="cambio_filtro" id="">
                <option value="No">No</option>
                <option value="Si">Si</option>
              </select>
            </div>

            <div class="form-group">
              <label for="">Cambio de aceite</label>
              <select class="form-control" name="cambio_aceite" id="">
                <option value="No">No</option>
                <option value="Si">Si</option>
              </select>
            </div>

            <div class="form-group">
              <label for="">Cambio de freno</label>
              <select class="form-control" name="cambio_freno" id="">
                <option value="No">No</option>
                <option value="Si">Si</option>
              </select>
            </div>

            <div class="form-group">
            <label for="">Descripción</label>
            <input type="text" class="form-control" required name="descripcion" id="" >
            </div>


            <button type="submit" class="btn btn-primary">Registrar Revisión</button>
            <a name="" id="" class="btn btn-primary" href="/templates/ListarRevision.php" role="button">Cancelar</a>
            
            
        </form>
    </div>
            
<?php
}

include '../footer.php';
?>
