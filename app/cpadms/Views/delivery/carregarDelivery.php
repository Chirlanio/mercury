<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
?>
<span class="endereco" data-endereco="<?php echo URLADM; ?>"></span>
<span class="enderecoList" data-enderecoList="<?php echo URLADM; ?>"></span>
<span class="conteudo" data-conteudo="listar_usuario"></span>

<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Pesquisar Entregas</h2>
            </div>
            <?php
            if ($this->Dados['botao']['cad_delivery']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'cadastrar-delivery/cad-delivery'; ?>">
                        <button class="btn btn-outline-success btn-sm">
                            Cadastrar
                        </button>
                    </a>
                </div>
                <?php
            }
            if ($this->Dados['botao']['cad_delivery_modal']) {
                ?>
                <div class="p-2">
                    <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#addDeliveryModal">
                        Cadastrar Modal
                    </button>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="form-inline" method="POST" action="">
            <div class="col-12 p-0">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="pesqDelivery"><i class="fa-solid fa-magnifying-glass"></i></label>
                    </div>
                    <input name="pesqDelivery" type="text" id="pesqUser" class="form-control" aria-describedby="pesqDelivery" placeholder="Nome, loja ou ID da entrega" />
                </div>
            </div>
        </form><hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <span id="conteudo"></span>
    </div>
</div>

<div class="modal fade" id="visulDeliveryModal" tabindex="-1" aria-labelledby="visulDeliveryModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="visulDeliveryModal">Detalhes da Entrega</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="visul_entrega"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-info" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade addModal" id="addSucessoModal" tabindex="-1" aria-labelledby="addSucessoModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Usuario cadatrado com sucesso!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
