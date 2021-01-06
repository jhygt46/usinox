<input type="hidden" id="id_user" value="1">
<div class="header clearfix">
    <div class="titles">Administrador</div>
    <div class="user-guide">
        <div class="image"></div>
        <div class="name"><?php echo $res['data']['nombre']; ?></div>
        <div class="user-info">
            <ul class="clearfix">
                <li>Foto Aca</li>
                <li>
                    <div><?php echo $res['data']['correo']; ?></div>
                    <div>Administrador</div>
                    <div></div>
                    <div><a href="index.php?accion=logout">Salir</a></div>
                </li>
            </ul>
        </div>
    </div>
</div>