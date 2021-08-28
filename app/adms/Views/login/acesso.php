
<body class="text-center">
    <form class="form-signin" method="POST" action="">
        <img class="mb-4" src="<?php echo URLADM . 'assets/imagens/logo/sandalia_asa_preta.png'; ?>" alt="Mercury" width="110" height="110">
        <img class="mb-4" src="<?php echo URLADM . 'assets/imagens/logo/logo_preta.png'; ?>" alt="Portal Lojas" width="309" height="108">
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
        <div class="form-group">
            <label>Usuário</label>
            <input name="usuario" type="text" class="form-control" placeholder="Digite o usuário" value="<?php if (isset($valorForm['usuario'])) {
            echo $valorForm['usuario'];
        } ?>"> 
        </div>
        <div class="form-group">
            <label>Senha</label>
            <input name="senha" type="password" class="form-control" placeholder="Digite a senha">
        </div>
        <input name="SendLogin" type="submit" class="btn btn-lg btn-primary btn-block" value="Acessar">
        <p class="text-center"><a href="<?php echo URLADM . 'esqueceu-senha/esqueceu-senha' ?>">Esqueceu a senha?</a></p>
    </form>
</body>

