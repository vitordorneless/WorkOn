<?php
error_reporting(E_ALL);
include '../config/database_mysql.php';
function __autoload($file) {
    if (file_exists('../Model/' . $file . '.php'))
        require_once('../Model/' . $file . '.php');
    else
        exit('O arquivo ' . $file . ' não foi encontrado!');
}
$pdo = Database::connect();
$evento = new Demandas();
$tipo_demanda = new Demandas_Tipos();
$user = new Usuarios();
$querie = new Queries();
$array = $evento->Dados_Demandas(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
$array_user = $user->Dados_User($array['id_user_abertura']);
$array_executante = $user->Dados_User($array['executantes']);
$array_demanda = $tipo_demanda->Dados_Demandas($array['id_demanda']);
?>
<script src="../js/JQuery/jquery-1.11.1.min.js"></script>
<script>
    $(document).ready(function () {

        $("#fechar_modal").click(function () {
            $("#refresca_cassi_solicitante").load('demanda_execute_list.php');
        });

        $(document).on('keydown', function (e) {
            if (e.keyCode === 27) {
                $("#refresca_cassi_solicitante").load('demanda_execute_list.php');
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
            var id = $("#id").val();
            var id_executante = $("#id_executante").val();
            var copyemail = $("#copyemail").val();            
            var status = $("#status").val();

            if ($("#copyemail").val() === '')
            {
                copyemail = "Não Informado";
            }

            if ($("#status").val() === 'na')
            {
                $("#status_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Informe...</div>").hide(90005),
                        $("#status").focus();
                return false;
            } else {
                $("#status_error").empty();
            }

            $.ajax({
                type: "POST",
                dataType: "HTML",
                url: "../Controller/demanda_execute_include.php",
                data: "id_executante=" + id_executante + "&copyemail=" + copyemail + "&status=" + status + "&id=" + id,
                beforeSend: function () {
                    $("#conteudo_CASSI").html("<img src='../../images/loading/load.gif' class='img-rounded img-responsive' id='imgpos'>");
                },
                success: function (response) {
                    $("#conteudo_CASSI").html(response),
                            $("#form")[0].reset(),
                            $("#refresca_cassi_solicitante").load('demanda_execute_list.php');
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
    <h4 class="modal-title">Executar Demanda</h4>
</div>			
<div class="modal-body">
    <form id="form" method="POST">
        <div class="form-group">
            <label for="label_nome_medico">Responsável:</label>
            <input type="text" class="form-control" value="<?php echo $array_user['nome_extenso']; ?>" disabled="disabled">            
            <input type="hidden" id="id" name="id" value="<?php echo $array['id']; ?>">            
        </div>        
        <div class="form-group">
            <label for="label_nome_medico">Executante:</label>
            <input type="text" class="form-control" value="<?php echo $array_executante['nome_extenso']; ?>" disabled="disabled">
            <input type="hidden" id="id_executante" name="id_executante" value="<?php echo $array_executante['id']; ?>">            
        </div>
        <div class="form-group">
            <label for="label_nome_medico">Demanda:</label>
            <input type="text" class="form-control" value="<?php echo $array_demanda['tipo_demanda']; ?>" disabled="disabled">            
        </div>
        <div class="form-group">
            <label for="label_obs">Observações:</label>
            <textarea class="form-control" name="copyemail" id="copyemail" rows="10"></textarea>
            <div class="form-inline" id="copyemail_error"></div>
        </div>
        <div class="form-group">
            <label for="label_funcao_medico">Status:</label>
            <select class="form-control" id="status" name="status">
                <option value="na">
                    Selecione...
                </option>
                <?php
                foreach ($pdo->query($querie->status_list_all()) as $value) {                    
                    echo '<option value="' . $value['id'] . '">' . $value['status'] . '</option>';
                }
                ?>
            </select>
            <div class="form-inline" id="status_error"></div>
        </div>
<?php Database::disconnect(); ?>
        <button class="btn btn-primary" id="envia" type="submit">Executar Demanda <span class="glyphicon glyphicon-save" aria-hidden="true"></span></button>
    </form>
</div>
<div class="modal-footer">
    <div id="conteudo_CASSI"></div>
</div>