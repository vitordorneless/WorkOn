<?php
session_start();
error_reporting(E_ALL);
include_once '../config/database_mysql.php';
function __autoload($file) {
    if (file_exists('../Model/' . $file . '.php'))
        require_once('../Model/' . $file . '.php');
    else
        exit('O arquivo ' . $file . ' no foi encontrado!');
}
$pdo = Database::connect();
$user = new Usuarios();
$querie = new Queries();
$dados_user = $user->Dados_User($_SESSION['user_id']);
?>
<script src="../js/JQuery/jquery-1.11.1.min.js"></script><!--sempre chamar, com jquery ui o $ajax não funciona-->
<script>
    $(document).ready(function () {
        
        $('#setor_destino').change(function () {
            $('#demanda').load('../Controller/combo_demanda_include_setor.php?setor=' + $('#setor_destino').val());
        });
        
        $('#demanda').change(function () {
            $('#prazo').load('../Controller/combo_demanda.php?demanda=' + $('#demanda').val());
        });
        
        $('#demanda').change(function () {
            $('#executante').load('../Controller/combo_executante_demanda.php?demanda=' + $('#demanda').val());
        });

        $("#form").submit(function () {
            return false;
        });
        $("#envia").click(function () {
            envia_form();
        });
        function envia_form() {
            $("#conteudo_medico").empty();
            var criador_demanda = $("#criador_demanda").val();
            var setor = $("#setor").val();
            var setor_destino = $("#setor_destino").val();
            var demanda_responsavel = $("#demanda_responsavel").val();            
            var executante = $("#executante").val();
            var demanda = $("#demanda").val();
            var copyemail = $("#copyemail").val();
            var prazo = $("#prazo").val();
            var status = 1;
            
            if ($("#setor").val() === 'na')
            {
                $("#setor_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>Ã—</button>Informe...</div>").hide(90005),
                        $("#setor").focus();
                return false;
            } else {
                $("#setor_error").empty();
            }
            
            if ($("#setor_destino").val() === 'na')
            {
                $("#setor_destino_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>Ã—</button>Informe...</div>").hide(90005),
                        $("#setor_destino").focus();
                return false;
            } else {
                $("#setor_destino_error").empty();
            }

            if ($("#demanda_responsavel").val() === 'na')
            {
                $("#demanda_responsavel_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>Ã—</button>Informe...</div>").hide(90005),
                        $("#demanda_responsavel").focus();
                return false;
            } else {
                $("#demanda_responsavel_error").empty();
            }

            if ($("#executante").val() === 'na')
            {
                $("#executante_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>Ã—</button>Informe...</div>").hide(90005),
                        $("#executante").focus();
                return false;
            } else {
                $("#executante_error").empty();
            }

            if ($("#demanda").val() === 'na')
            {
                $("#demanda_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>Ã—</button>Informe...</div>").hide(90005),
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
                $("#prazo_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>Ã—</button>Informe...</div>").hide(90005),
                        $("#prazo").focus();
                return false;
            } else {
                $("#prazo_error").empty();
            }

            $.ajax({
                type: "POST",
                dataType: "HTML",
                url: "../Controller/demanda_include.php",
                data: "criador_demanda=" + criador_demanda + "&setor=" + setor + "&setor_destino=" + setor_destino + 
                        "&demanda_responsavel=" + demanda_responsavel + "&executante=" + executante +
                        "&demanda=" + demanda + "&copyemail=" + copyemail + "&prazo=" + prazo + "&id_status=" + status,
                beforeSend: function () {
                    $("#conteudo_medico").html("<img src='../../images/loading/load.gif' class='img-rounded img-responsive' id='imgpos'>");
                },
                success: function (response) {
                    $("#conteudo_medico").html(response),
                            $("#form")[0].reset();
                },
                error: function () {
                    alert("Ocorreu um erro durante a requisiÃ§ão");
                }
            });
        }
    });
</script>
<div class="row">
    <div class="widget">
        <div class="widget-header transparent">
            <h2><strong>Criar</strong> Demanda</h2>
            <div class="additional-btn">                
                <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>                
            </div>
        </div>
        <div class="widget-content padding">
            <div id="basic-form">
                <form id="form" method="POST">
                    <div class="form-group">
                        <label for="label_nome_medico">Nome:</label>
                        <input type="text" class="form-control" value="<?php echo $dados_user['nome_extenso']; ?>" disabled="disabled">
                        <input type="hidden" id="criador_demanda" name="criador_demanda" value="<?php echo $dados_user['id']; ?>">
                        <input type="hidden" class="hidden" id="demanda_responsavel" name="demanda_responsavel" value="0">
                        <div class="form-inline" id="nome_medico_error"></div>
                    </div>                    
                    <div class="form-group">
                        <label for="label_funcao_medico">Setor:</label>
                        <select class="form-control" id="setor" name="setor" required>
                            <?php
                            foreach ($pdo->query($querie->usuarios_setor()) as $value) {
                                $option = $value['id'] == $dados_user['setor'] ? 'value="' . $value['id'] . '" selected' : 'value="' . $value['setor'] . '"';
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
                            <option selected value="na">
                                Informe...
                            </option>
                            <?php
                            foreach ($pdo->query($querie->usuarios_setor()) as $value) {                                
                                echo '<option value="' . $value['id'] . '">' . $value['setor'] . '</option>';
                            }
                            ?>                            
                        </select>
                        <div class="form-inline" id="setor_destino_error"></div>
                    </div>                    
                    <div class="form-group">
                        <label for="label_funcao_medico">Demanda:</label>
                        <select class="form-control" id="demanda" name="demanda">
                            <option selected value="na">
                                Aguardando...
                            </option>
                        </select>
                        <div class="form-inline" id="demanda_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="label_funcao_medico">Executante da Demanda:</label>
                        <select class="form-control" id="executante" name="executante" required>
                            <option selected value="na">
                                Aguardando...
                            </option>
                        </select>
                        <div class="form-inline" id="executante_error"></div>
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
                        <label for="label_obs">Cópia do Email / Observações:</label>                        
                        <textarea class="form-control" name="copyemail" id="copyemail" rows="15"></textarea>
                        <div class="form-inline" id="obs_error"></div>
                    </div>                    
                    <?php Database::disconnect(); ?>
                    <button class="btn btn-primary" id="envia" type="submit">Gerar Demanda <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span></button>
                </form>
            </div>
        </div>
    </div>
    <div class="widget">
        <div class="widget-content padding">
            <div id="conteudo_medico"></div>
        </div>        
    </div>
</div>