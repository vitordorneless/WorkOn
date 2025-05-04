<?php
include '../config/database_mysql.php';
$pdo = Database::connect();
function __autoload($file) {
    if (file_exists('../Model/' . $file . '.php'))
        require_once('../Model/' . $file . '.php');
    else
        exit('O arquivo ' . $file . ' não foi encontrado!');
}
$querie = new Queries();
$evento = new Demandas();
$users = new Usuarios();
$array = $evento->Dados_Demandas(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
$executante = $users->Dados_User($array['executantes']);
?>
<script src="../js/JQuery/jquery-1.11.1.min.js"></script>
<script>
    $(document).ready(function () {

        $("#fechar_modal").click(function () {
            $("#refresca_cassi_solicitante").load('demanda_transfer.php');
        });

        $(document).on('keydown', function (e) {
            if (e.keyCode === 27) {
                $("#refresca_cassi_solicitante").load('demanda_transfer.php');
            }
        });

        $("#form").submit(function () {
            return false;
        });
        $("#envia").click(function () {
            envia_form();
        });
        function envia_form() {
            $("#conteudo_CASSI").empty();
            var executante = $("#executante").val();
            var id = $("#id").val();
            var ant = $("#ant").val();

            if ($("#executante").val() === 'na')
            {
                $("#executante_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Informe...</div>").hide(9000),
                        $("#executante").focus();
                return false;
            } else {
                $("#executante_error").empty();
            }

            $.ajax({
                type: "POST",
                dataType: "HTML",
                url: "../Controller/demanda_transfer.php",
                data: "executante=" + executante + "&id=" + id + "&ant=" + ant,
                beforeSend: function () {
                    $("#conteudo_CASSI").html("<img src='../../images/loading/load.gif' class='img-rounded img-responsive'>");
                },
                success: function (response) {
                    $("#conteudo_CASSI").html(response), $("#form")[0].reset(), $("#refresca_cassi_solicitante").load('demanda_transfer.php');
                },
                error: function () {
                    alert("Ocorreu um erro durante a requisição");
                }
            });
        }
    });
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="fechar_modal">&times;</button>
    <h4 class="modal-title">Transferir Demanda</h4>
</div>			
<div class="modal-body">
    <form id="form" method="POST">        
        <div class="form-group">
            <label for="label_nome">Executante Atual da Demanda:</label>
            <input type="hidden" id="id" name="id" value="<?php echo $array['id']; ?>">
            <input type="hidden" id="ant" name="ant" value="<?php echo $executante['id']; ?>">
            <input class="form-control" type="text" id="nn" name="nn" value="<?php echo $executante['nome_extenso']; ?>" disabled="disabled">            
        </div>
        <div class="form-group">
            <label for="label_funcao_medico">Novo Executante da Demanda:</label>
            <select class="form-control" id="executante" name="executante">
                <option selected value="na">
                    Selecione...
                </option>
                <?php
                foreach ($pdo->query($querie->listar_executantes_setor($executante['setor'])) as $value) {
                    echo '<option value="' . $value['id'] . '">' . $value['nome_extenso'] . '</option>';
                }
                Database::disconnect();
                ?>                            
            </select>
            <div class="form-inline" id="executante_error"></div>
        </div>                    
        <button class="btn btn-primary btn-dropbox pull-right" id="envia" type="submit">Transferir <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span></button>
    </form>
</div>
<div class="modal-footer">
    <div id="conteudo_CASSI"></div>
</div>