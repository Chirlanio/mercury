
<body>
    <form class="form-signin" method="POST" action="">
        <div class="text-center">
        <img class="mb-4" src="<?php echo URLADM . 'assets/imagens/logo/sandalia_asa_preta.png'; ?>" alt="Portal Mercury" width="110" height="110">
        <img class="mb-4" src="<?php echo URLADM . 'assets/imagens/logo/logo_preta.png'; ?>" alt="Portal Mercury" width="309" height="108">
        <h1 class="h3 mb-3 font-weight-normal">Portal Mercury</h1>
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
            <input name="usuario" type="text" class="form-control" placeholder="Digite o usuário" value="<?php
            if (isset($valorForm['usuario'])) {
                echo $valorForm['usuario'];
            }
            ?>" required autofocus>
            <label for="usuario">Usuário</label>
        </div>
        <div class="form-label-group">
            <input name="senha" type="password" class="form-control" placeholder="Digite sua senha">
            <label for="usuario">Senha</label>
        </div>
        <input name="SendLogin" type="submit" class="btn btn-lg btn-primary btn-block" value="Acessar">
        <p class="text-center"><a href="<?php echo URLADM . 'esqueceu-senha/esqueceu-senha' ?>">Esqueceu a senha?</a> | <a href="<?php echo URLADM . 'login-treinamento/acesso' ?>">Escola Digital</a></p>
    </form>
</body>

