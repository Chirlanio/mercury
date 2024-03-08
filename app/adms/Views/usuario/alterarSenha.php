<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Alterar Senha</h2>
            </div>
            <div class="p-2">
                <a href="<?php echo URLADM . 'ver-perfil/perfil'; ?>" class="btn btn-outline-primary btn-sm"><i class='fa-solid fa-eye'></i></a>
            </div>
        </div><hr>
        <?php
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" class="was-validated">            
            <div class="form-group">
                <label>Senha</label>
                <input name="senha" type="password" class="form-control is-invalid" placeholder="Senha com mínimo 6 caracteres" autofocus required>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="AltSenha" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
