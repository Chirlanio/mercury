<body class="text-center">
    <form class="form-signin" method="POST" action="">
        <img class="mb-4" src="<?php echo URLADM . 'assets/imagens/logo/logo_preta.png'; ?>" alt="Portal Lojas" width="309" height="108">
        <h1 class="h3 mb-3 font-weight-normal">Recuperar a senha</h1>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        if (isset($this->Dados['form'])) {
            $valorForm = $this->Dados['form'];
        }
        ?>
        <div class="form-group">
            <label>E-mail</label>
            <input name="email" type="email" class="form-control" placeholder="Digite o e-mail cadastrado" value="<?php if (isset($valorForm['email'])) {
            echo $valorForm['email'];
        } ?>"> 
        </div>
        <input name="RecupUserLogin" type="submit" class="btn btn-lg btn-primary btn-block" value="Recuperar">
        <p class="text-center">Lembrou? <a href="<?php echo URLADM . 'login/acesso' ?>">Clique aqui</a> para logar</p>
    </form>
</body>
