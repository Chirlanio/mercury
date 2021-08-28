<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4">Gente & Gestão</h2>
            </div>
            <div class="img-fluid">
                <img src="<?php echo URLADM . 'assets/imagens/logo/logo_preta.png'; ?>" alt="Grupo Meia Sola" width="200" height="90">
            </div>
        </div><hr>
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th colspan="12" class="text-center display-4 bg-dark text-white border-bottom">DIRETRIZES GENTE & GESTÃO</th>
                </tr>
            </thead>
            <tbody>
                <tr> <td colspan="12"></td></tr>
                <tr> <td colspan="12" class="bg-primary text-white text-center border">E-MAILS DA EQUIPE</td></tr>
                <tr>
                    <th scope="row" class="text-center border">Gerência</th>
                    <td colspan="10" class="text-center border">Enviar e-mail para izabel.aragao@meiasola.com.br</td>
                </tr>
                <tr>
                    <th scope="row" class="text-center border">Treinamento</th>
                    <td colspan="10" class="text-center border">Enviar e-mail para treinamento@meiasola.com.br</td>
                </tr>
                <tr>
                    <th scope="row" class="text-center border">Currículos</th>
                    <td colspan="10" class="text-center border">Enviar e-mail para recrutamento@meiasola.com.br
                <tr>
                    <th scope="row" class="text-center border">Fardamentos e Seleção</th>
                    <td colspan="10" class="text-center border">Enviar e-mail para bp@meiasola.com.br</td>
                </tr>
                <tr>
                    <td colspan="12" scope="row" class="text-center bg-warning border"><span style="font-weight: bold; color: red;">ATENÇÃO:</span> NÃO ENVIAR E-MAIL PARA <span style="font-weight: bold;">RH@MEIASOLA.COM.BR</span> ESSE EMAIL FOI DESATIVADO</td>
                </tr>
                <tr>
                    <th scope="row" colspan="3" class="table-active text-center border">PROCESSO</th>
                    <th scope="row" colspan="3" class="table-active text-center border">O QUE FAZER?</th>
                    <th scope="row" colspan="3" class="table-active text-center border">OBSERVAÇÕES</th>
                    <th scope="row" colspan="3" class="table-active text-center border">LINK</th>
                </tr>
                <tr>
                    <th colspan="3" class="text-center border align-middle">Recrutamento e Seleção</th>
                    <td colspan="3" class="text-center border align-middle">Abrir vaga no site Fortes RH.</td>
                    <td colspan="3" class="text-center border align-middle">A vaga só será trabalhada a partir do dia em que for aberta no Fortes RH.</td>
                    <td colspan="3" class="text-center border align-middle"><a href="http://192.168.0.251:58080/fortesrh/login.action" class="btn btn-outline-danger" target="_blank">Fortes RH</a></td>
                </tr>
                <tr>
                    <th colspan="3" class="text-center border align-middle">Solicitação de fardamento</th>
                    <td colspan="3" class="text-center border align-middle">Abrir chamado no movidesk com tamanho, para quem é e motivo da solicitação.</td>
                    <td colspan="3" class="text-center border align-middle">Atentar que está abrindo chamado para a área de Gente & Gestão no Movidesk, e não para outra área.</td>
                    <td colspan="3" class="text-center border align-middle"><a href="https://meiasola.movidesk.com/" class="btn btn-outline-dark" target="_blank">Movidesk</a></td>
                </tr>
                <tr>
                    <th colspan="3" class="text-center border align-middle">Matriz disciplinar</th>
                    <td colspan="3" class="text-center border align-middle">Avisar imediatamente a Izabel nos casos em que caiba aplicar medida disciplinar.</td>
                    <td colspan="3" class="text-center border align-middle">É a área de G&G que faz os formulários e envia para as gerentes aplicarem.</td>
                    <td colspan="3" class="text-center border align-middle">
                        <div class="dropdown">
                            <button class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Contato
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item text-info" href="#"><i class="fas fa-mobile-alt"></i> (85) 99631-4334</a>
                                <a class="dropdown-item text-success" href="https://api.whatsapp.com/send?1=pt_BR&amp;phone=5585996314334" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th colspan="3" class="text-center border align-middle">Desligamentos</th>
                    <td colspan="3" class="text-center border align-middle">Enviar formulário de MP de desligamento constando motivo e saldo de horas por E-mail.</td>
                    <td colspan="3" class="text-center border align-middle">E-mails a serem copiados: dp@meiasola.com.br; estagiodp@meiasola.com.br; izabel.aragao@meiasola.com.br; bp@meiasola.com.br; danielle.ribeiro@meiasola.com.br</td>
                    <td colspan="3" class="text-center border align-middle"><a href="<?php echo URLADM . 'assets/download/MP_Desligamento_Grupo Meia Sola v.Final.xlsx'; ?>" class="btn btn-outline-info" download>Planilha</a></td>
                </tr>
                <tr>
                    <th colspan="12" scope="row" class="table-active text-center border">UM PASSO A FRENTE FAZENDO SEMPRE MAIS</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>