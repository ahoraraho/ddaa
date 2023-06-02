<div class="ruta">
    <a href="./" title="Home"><i class="bi bi-house "></i></a>
    <a href="?m=panel&mod=categorias" title="Ir a Marcas">Empresas</a>
    <a href="#" title="Estas justo aqui" class="active">Empresa</a>
</div>
<div class="formularios">
    <div class="entradas">
        <h3>EMPRESA</h3>
        <div class="main">
            <div class="formm">
                <form action="?m=panel&mod=categoria&action=" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="">
                    <i class="bi bi-qr-code-scan"></i><span> Id </span>
                    <input id="noEdid" title="No se puede modificar" disabled required type="text" name="Nombre" value="">
                    <i class="bi bi-grid-1x2"></i><span> Nombre </span>
                    <input required type="text" name="Nombre" value="">
                    <i class="bi bi-diagram-3"></i><span> Referencia </span>
                    <input required type="number" min="0" name="Hijo_de" value=" >
                    <br><br>
                    <button type=" submit" name="action" id="ac" style="color:red;" class="form_login"></button>
                </form>
            </div>
        </div>
    </div>
</div>