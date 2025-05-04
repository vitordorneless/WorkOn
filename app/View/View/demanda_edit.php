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
$user = new Usuarios();
$querie = new Queries();
$array = $evento->Dados_Demandas(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
$array_user = $user->Dados_User($array['id_user_abertura']);
?>
<script src="../js/JQuery/jquery-1.11.1.min.js"></script>
<script>
    $(document).ready(function () {

        $("#fechar_modal").click(function () {
            $("#refresca_cassi_solicitante").load('demanda_list.php');
        });

        $(document).on('keydown', function (e) {
            if (e.keyCode === 27) {
                $("#refresca_cassi_solicitante").load('demanda_list.php');
            }
        });

        var id_demand = '<?php echo $array['id_demanda']; ?>';
        $('#prazo').load('../Controller/combo_demanda_selected.php?id_demanda=' + id_demand);
        
        $('#demanda').change(function () {
            $('#prazo').load('../Controller/combo_demanda.php?demanda=' + $('#demanda').val());
        });

        $("#form").submit(function () {
            return false;
        });
        $("#envia").click(function () {
            envia_form();
        });
        function envia_form() {
            $("#conteudo_CASSI").empty();
            var criador_demanda = $("#criador_demanda").val();
            var id = $("#id").val();
            var setor = $("#setor").val();
            var setor_destino = $("#setor_destino").val();
            var demanda_responsavel = $("#demanda_responsavel").val();
            var executante = $("#executante").val();
            var demanda = $("#demanda").val();
            var copyemail = $("#copyemail").val();
            var prazo = $("#prazo").val();
            var status = $("#status").val();
            var dt = $("#dt").val();

            if ($("#setor").val() === 'na')
            {
                $("#setor_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Informe...</div>").hide(90005),
                        $("#setor").focus();
                return false;
            } else {
                $("#setor_error").empty();
            }

            if ($("#setor_destino").val() === 'na')
            {
                $("#setor_destino_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Informe...</div>").hide(90005),
                        $("#setor_destino").focus();
                return false;
            } else {
                $("#setor_destino_error").empty();
            }

            if ($("#demanda_responsavel").val() === 'na')
            {
                $("#demanda_responsavel_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Informe...</div>").hide(90005),
                        $("#demanda_responsavel").focus();
                return false;
            } else {
                $("#demanda_responsavel_error").empty();
            }

            if ($("#executante").val() === 'na')
            {
                $("#executante_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Informe...</div>").hide(90005),
                        $("#executante").focus();
                return false;
            } else {
                $("#executante_error").empty();
            }

            if ($("#demanda").val() === 'na')
            {
                $("#demanda_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Informe...</div>").hide(90005),
                        $("#demanda").focus();
                return false;
            } else {
                $("#demanda_error").empty();
            }

            if ($("#copyemail").val() === '')
            {
                copyemail = "Não Informado";
            }

            if ($("#prazo").val() === 'na')
            {
                $("#prazo_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Informe...</div>").hide(90005),
                        $("#prazo").focus();
                return false;
            } else {
                $("#prazo_error").empty();
            }

            $.ajax({
                type: "POST",
                dataType: "HTML",
                url: "../Controller/demanda_edit.php",
                data: "criador_demanda=" + criador_demanda + "&setor=" + setor + "&setor_destino=" + setor_destino +
                        "&demanda_responsavel=" + demanda_responsavel + "&executante=" + executante +
                        "&demanda=" + demanda + "&copyemail=" + copyemail + "&prazo=" + prazo + "&id_status=" + status + "&id=" + id + "&dt=" + dt,
                beforeSend: function () {
                    $("#conteudo_CASSI").html("<img src='../../images/loading/load.gif' class='img-rounded img-responsive' id='imgpos'>");
                },
                success: function (response) {
                    $("#conteudo_CASSI").html(response),
                            $("#form")[0].reset(),
                            $("#refresca_cassi_solicitante").load('demanda_list.php');
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
    <h4 class="modal-title">Editar Demanda</h4>
</div>			
<div class="modal-body">
    <form id="form" method="POST">
        <div class="form-group">
            <label for="label_nome_medico">Nome:</label>
            <input type="text" class="form-control" value="<?php echo $array_user['nome_extenso']; ?>" disabled="disabled">
            <input type="hidden" id="criador_demanda" name="criador_demanda" value="<?php echo $array_user['id']; ?>">
            <input type="hidden" id="id" name="id" value="<?php echo $array['id']; ?>">
            <input type="hidden" id="dt" name="dt" value="<?php echo $array['data_ultima_alteracao']; ?>">
            <input type="hidden" id="id_responsavel" name="id_responsavel" value="<?php echo $array['id_responsavel']; ?>">
        </div>                    
        <div class="form-group">
            <label for="label_funcao_medico">Setor:</label>
            <select class="form-control" id="setor" name="setor" required>
                <?php
                foreach ($pdo->query($querie->usuarios_setor()) as $value) {
                    $option = $value['id'] == $array['id_user_abertura_setor'] ? 'value="' . $value['id'] . '" selected' : 'value="' . $value['id'] . '"';
                    echo '<option ' . $option . '>' . $value['setor'] . '</option>';
                }
                ?>
                <option value="na">
                    Informe...
                </option>
            </select>
            <div class="form-inline" id="setor_error"></div>
        </div>
        <div class="form-group">
            <label for="label_funcao_medico">Setor de Destino:</label>
            <select class="form-control" id="setor_destino" name="setor_destino" required>                
                <?php
                foreach ($pdo->query($querie->usuarios_setor()) as $value) {
                    $option = $value['id'] == $array['destino_setor'] ? 'value="' . $value['id'] . '" selected' : 'value="' . $value['id'] . '"';
                    echo '<option ' . $option . '>' . $value['setor'] . '</option>';
                }
                ?>
                <option value="na">
                    Informe...
                </option>
            </select>
            <div class="form-inline" id="setor_destino_error"></div>
        </div>        
        <div class="form-group">
            <label for="label_funcao_medico">Executante da Demanda:</label>
            <select class="form-control" id="executante" name="executante" required>
                <option value="na">
                    Selecione...
                </option>
                <?php
                foreach ($pdo->query($querie->Executantes_demanda()) as $value) {
                    $option = $value['id'] == $array['executantes'] ? 'value="' . $value['id'] . '" selected' : 'value="' . $value['id'] . '"';
                    echo '<option ' . $option . '>' . utf8_encode($value['nome_extenso']) . '</option>';
                }
                ?>
            </select>
            <div class="form-inline" id="executante_error"></div>
        </div>                    
        <div class="form-group">
            <label for="label_funcao_medico">Demanda:</label>
            <select class="form-control" id="demanda" name="demanda">
                <option value="na">
                    Selecione...
                </option>
                <?php
                foreach ($pdo->query($querie->demanda_admin_listar_tiposs($array_user['setor'])) as $value) {
                    $option = $value['id'] == $array['id_demanda'] ? 'value="' . $value['id'] . '" selected' : 'value="' . $value['id'] . '"';
                    echo '<option ' . $option . '>' . $value['tipo_demanda'] . '</option>';                    
                }
                ?>
            </select>
            <div class="form-inline" id="demanda_error"></div>
        </div>
        <div class="form-group">
            <label for="label_cidade">Prazo:</label>
            <select class="form-control" id="prazo" name="prazo" required>
                <option selected value="na">
                    Aguardando...
                </option>
            </select>
            <div class="form-inline" id="prazo_error"></div>
        </div>
        <div class="form-group">
            <label for="label_obs">Cópia do Email:</label>                        
            <textarea class="form-control" name="copyemail" id="copyemail" rows="15"><?php echo $array['copy_email']; ?></textarea>
            <div class="form-inline" id="obs_error"></div>
        </div>
        <div class="form-group">
            <label for="label_funcao_medico">Status:</label>
            <select class="form-control" id="status" name="status">
                <option value="na">
                    Selecione...
                </option>
                <?php
                foreach ($pdo->query($querie->status_list_all()) as $value) {
                    $option = $value['id'] == $array['id_status'] ? 'value="' . $value['id'] . '" selected' : 'value="' . $value['id'] . '"';
                    echo '<option ' . $option . '>' . $value['status'] . '</option>';                    
                }
                ?>
            </select>
            <div class="form-inline" id="demanda_error"></div>
        </div>
<?php Database::disconnect(); ?>
        <button class="btn btn-primary" id="envia" type="submit">Editar Demanda <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
    </form>
</div>
<div class="modal-footer">
    <div id="conteudo_CASSI"></div>
</div>