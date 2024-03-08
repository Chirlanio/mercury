<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Senha</h2>
            </div>
            <span class="d-none d-md-block p-2">
                <?php
                if ($this->Dados['botao']['list_usuario']) {
                    echo "<a href='" . URLADM . "usuarios/listar' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i></a> ";
                }
                if ($this->Dados['botao']['vis_usuario']) {
                    echo "<a href='" . URLADM . "ver-usuario/ver-usuario/{$this->Dados['form']}' class='btn btn-outline-primary btn-sm'><i class='fa-solid fa-eye'></i></a> ";
                }
                ?>
            </span>

        </div>
        <hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="">   
            <input name="id" type="hidden" value="<?php echo $this->Dados['form']; ?>">

            <div class="form-group">
                <label>Senha</label>
                <input name="senha" type="password" class="form-control" placeholder="Senha com mínimo 6 caracteres">
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditSenha" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
