<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Senha</h2>
            </div>
            <?php
            if ($this->Dados['botao']['vis_usuario']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ver-usuario-treinamento/ver-usuario/' . $this->Dados['form']; ?>" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-eye"></i></a>
                </div>
                <?php
            }
            ?>
        </div><hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" class="was-validated">   
            <input name="id" type="hidden" value="<?php echo $this->Dados['form']; ?>">

            <div class="form-group">
                <label>Senha</label>
                <input name="senha" type="password" class="form-control is-invalid" placeholder="Senha com mínimo 6 caracteres" autofocus required>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditSenha" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
