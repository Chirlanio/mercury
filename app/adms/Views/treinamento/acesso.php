
    <form class="form-signin" method="POST" action="">
        <div class="text-center">
        <img class="mb-4" src="<?php echo URLADM . 'assets/imagens/logo/sandalia_asa_preta.png'; ?>" alt="Portal Mercury" width="110" height="110">
        <img class="mb-4" src="<?php echo URLADM . 'assets/imagens/logo/logo_preta.png'; ?>" alt="Portal Mercury" width="309" height="108">
        <h1 class="h3 mb-3 font-weight-normal">Mercury - Escola Digital</h1>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        if (isset($this->Dados['form'])) {
            $valorForm = $this->Dados['form'];
        }
        ?>
        </div>
        <div class="form-label-group">
            <input name="cpf" type="text" id="cpf" class="form-control" placeholder="Digite o CPF" value="<?php
            if (isset($valorForm['cpf'])) {
                echo $valorForm['cpf'];
            }
            ?>" required autofocus>
            <label for="cpf">CPF</label>
        </div>
        <div class="form-label-group">
            <input name="senha" type="password" class="form-control" placeholder="Digite sua senha">
            <label for="senha">Senha</label>
        </div>
        <input name="SendLogin" type="submit" class="btn btn-lg btn-primary btn-block" value="Acessar">
        <p class="text-center"><a href="<?php echo URLADM . 'esqueceu-senha/esqueceu-senha' ?>">Esqueceu a senha?</a></p>
    </form>

