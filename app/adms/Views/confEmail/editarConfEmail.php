<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['select']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex align-items-center bg-light pr-2 pl-2 border rounded shadow-sm">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Configuração de E-mail</h2>
            </div>

        </div><hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" class="was-validated" enctype="multipart/form-data"> 
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="nome" type="text" class="form-control is-invalid" placeholder="Nome do remetente" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>" autofocus required>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> E-mail</label>
                    <input name="email" type="email" class="form-control is-invalid" placeholder="E-mail do remetente" value="<?php
                    if (isset($valorForm['email'])) {
                        echo $valorForm['email'];
                    }
                    ?>" required>
                </div>
            </div>
            
            
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Host</label>
                    <input name="host" type="text" class="form-control is-invalid" placeholder="Servidor de envio de e-mail" value="<?php
                    if (isset($valorForm['host'])) {
                        echo $valorForm['host'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Usuário do E-mail</label>
                    <input name="usuario" type="text" class="form-control is-invalid" placeholder="Usuário do e-mail de remetente" value="<?php
                    if (isset($valorForm['usuario'])) {
                        echo $valorForm['usuario'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Senha do E-mail</label>
                    <input name="senha" type="password" class="form-control is-invalid" placeholder="Senha do e-mail de remetente" value="<?php
                    if (isset($valorForm['senha'])) {
                        echo $valorForm['senha'];
                    }
                    ?>" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Encriptação</label>
                    <input name="smtpsecure" type="text" class="form-control is-invalid" placeholder="Tipo de encriptação SSL/TLS" value="<?php
                    if (isset($valorForm['smtpsecure'])) {
                        echo $valorForm['smtpsecure'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Porta</label>
                    <input name="porta" type="text" class="form-control is-invalid" placeholder="Porta de envio de E-mail" value="<?php
                    if (isset($valorForm['porta'])) {
                        echo $valorForm['porta'];
                    }
                    ?>" required>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditConfEmail" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
