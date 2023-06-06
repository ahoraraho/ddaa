<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house "></i></a>
    <a href="?m=panel&mod=categorias" title="Ir a Marcas">Empresas</a>
    <a href="#" title="Estas justo aqui" class="active">Empresa</a>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Aca se deben procesar los datos del formulario ejecutado
    $id = $_GET["id"];


    $Boton = "jfkdlj";

}
?>
<div class="formularios">
    <div class="entradas">
        <h3>EMPRESA</h3>
        <div class="main">
            <div class="formm">

                    <?php
                    //ACA estan los cambioooooos
                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                        // Aca se deben procesar los datos del formulario ejecutado
                        $id = $_GET["id"];
                    }
                    ?>

                <form action="?m=panel&mod=categoria&action=" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="">
                    <span> Id </span>
<<<<<<< HEAD
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="Nombre" value="<?php $id ?>">
=======
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="Nombre" value="<?= $id ?>">
>>>>>>> f82086df92b934ecdcd3893748a1712b13a22a48
                    <span> Nombre Empresa</span>
                    <input required type="text" name="Nombre" value="">
                    <span> RUC </span>
                    <input required type="number" min="0" name="ruc" value="" >
                    <span> Telefono </span>
                    <input required type="number" min="0" name="telefono" value="" >
                    <span> Email </span>
                    <input required type="text" min="0" name="email" value="" >
                    <span> Numero de Partida </span>
                    <input required type="text" min="0" name="num_partida" value="" >
                    <span> MIPE </span>
                    <input required type="number" min="0" name="mipe" value="" >
                    <br><br>
<<<<<<< HEAD
                    <button type="submit" name="action" id="ac" style="color:red;" class="form_login" value="Agregar">Agregar</button>
                    
=======
                    <button type=" submit" name="action" id="ac" style="color:red;" class="form_login" value="Agregar"><?= $Boton?></button>
>>>>>>> f82086df92b934ecdcd3893748a1712b13a22a48
                </form>
            </div>
        </div>
    </div>
</div>