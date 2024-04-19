<?php
if (!defined('URLADM')) {
    header("Location: /");
    exit();
}
//var_dump($this->Dados['gg']);
if (!empty($this->Dados['gg'][0])) {
    extract($this->Dados['gg'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4">Pessoas & Cultura</h2>
                </div>
                <div class="img-fluid">
                    <img src="<?php echo URLADM . 'assets/imagens/logo/logo_preta.png'; ?>" alt="Grupo Meia Sola" width="200" height="90">
                </div>
            </div>
            <?php
            if (empty($this->Dados['gg'])) {
                ?>
                <div class="alert alert-danger" role="alert">
                    Nenhum registro encontrado!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            }
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <hr>
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th colspan="12" class="text-center display-4 bg-dark text-white border-bottom">DIRETRIZES PESSOAS & CULTURA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr> <td colspan="12"></td></tr>
                    <tr> <td colspan="12" class="bg-primary text-white text-center border">E-MAILS DA EQUIPE</td></tr>
                    <tr>
                        <th scope="row" class="text-center border">Gerência</th>
                        <td colspan="10" class="text-center border">Enviar e-mail para <?php echo $email_gerente; ?></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center border">Treinamento</th>
                        <td colspan="10" class="text-center border">Enviar e-mail para <?php echo $email_treinamento; ?></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center border">Currículos</th>
                        <td colspan="10" class="text-center border">Enviar e-mail para <?php echo $email_curriculo; ?></td>
                    <tr>
                        <th scope="row" class="text-center border">Fardamentos e Seleção</th>
                        <td colspan="10" class="text-center border">Enviar e-mail para <?php echo $email_farda_selecao; ?></td>
                    </tr>
                    <tr>
                        <td colspan="12" scope="row" class="text-center bg-warning border"><?php echo $aviso; ?></td>
                    </tr>
                    <tr>
                        <th scope="row" colspan="3" class="table-active text-center border">PROCESSO</th>
                        <th scope="row" colspan="3" class="table-active text-center border">O QUE FAZER?</th>
                        <th scope="row" colspan="3" class="table-active text-center border">OBSERVAÇÕES</th>
                        <th scope="row" colspan="3" class="table-active text-center border">LINK</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-center border align-middle">Recrutamento e Seleção</th>
                        <td colspan="3" class="text-center border align-middle"><?php echo $descricao_recrutamento; ?></td>
                        <td colspan="3" class="text-center border align-middle"><?php echo $obs_recrutamento; ?></td>
                        <td colspan="3" class="text-center border align-middle"><a href="<?php echo $link_recrutamento; ?>" class="btn btn-outline-danger" target="_blank">Fortes RH</a></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-center border align-middle">Solicitação de fardamento</th>
                        <td colspan="3" class="text-center border align-middle"><?php echo $descricao_fardamento; ?></td>
                        <td colspan="3" class="text-center border align-middle"><?php echo $obs_fardamento; ?></td>
                        <td colspan="3" class="text-center border align-middle"><a href="<?php echo $link_fardamento; ?>" class="btn btn-outline-dark" target="_blank">Movidesk</a></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-center border align-middle">Matriz disciplinar</th>
                        <td colspan="3" class="text-center border align-middle"><?php echo $descricao_matriz; ?></td>
                        <td colspan="3" class="text-center border align-middle"><?php echo $obs_matriz; ?></td>
                        <td colspan="3" class="text-center border align-middle">
                            <div class="dropdown">
                                <button class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Contato
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <a id="phone_with_ddd" class="dropdown-item text-info" href="#"><i class="fas fa-mobile-alt"></i> <?php echo $contato_matriz; ?></a>
                                    <a class="dropdown-item text-success" href="<?php echo $link_matriz; ?>" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-center border align-middle">Desligamentos</th>
                        <td colspan="3" class="text-center border align-middle"><?php echo $descricao_desligamento; ?></td>
                        <td colspan="3" class="text-center border align-middle"><?php echo $obs_desligamento; ?></td>
                        <td colspan="3" class="text-center border align-middle"><a href="<?php echo URLADM . 'assets/download/gente-gestao/' . $arquivo; ?>" class="btn btn-outline-info" download>Planilha</a></td>
                    </tr>
                    <tr>
                        <th colspan="12" scope="row" class="table-active text-center border">UM PASSO A FRENTE FAZENDO SEMPRE MAIS</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}
?>