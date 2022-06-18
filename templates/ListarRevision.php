<?php
include '../funciones/conexion.php';
include '../header.php';

$query = "SELECT * FROM revision r JOIN auto a ON r.cod_auto = a.cod_auto JOIN cliente c ON a.cod_cliente = c.cod_cliente WHERE fegreso is NULL";
$resultado = mysqli_query(conectarDB(), $query);


if ($resultado){

    ?>
<div class="container mt-3">

    <table class="table">
        <thead>
            <tr>
                <th>ID revisión</th>
                <th>Cliente</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>KMS</th>
                <th>opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($r = mysqli_fetch_assoc($resultado)):?>
                <tr>
                    <td><?php echo $r['cod_revision'] ?></td>
                    <td><?php echo $r['nomyape'] ?></td>
                    <td><?php echo $r['marca'] ?></td>
                    <td><?php echo $r['modelo'] ?></td>
                    <td><?php echo $r['km'] ?></td>
                    <td><a name="" id="" class="btn btn-primary" href="/templates/RegistrarEgreso.php?id=<?php echo $r['cod_revision'] ?>" role="button">Registrar egreso</a></td>
                </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
<?php

}


include '../footer.php';
?>
