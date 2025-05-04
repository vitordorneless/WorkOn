<script src="../js/JQuery/jquery-1.11.1.min.js"></script><!--sempre chamar, com jquery ui o $ajax não funciona-->
<script>
    $(document).ready(function () {                

        $("#form").submit(function () {
            return false;
        });
        $("#envia").click(function () {
            envia_form();
        });
        function envia_form() {
            $("#conteudo_periodico").empty();
            var id = $("#id").val();            

            if ($("#id").val() === '0') {
                $("#id_error").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Informe...</div>").hide(2405),
                        $("#id").focus();
                return false;
            } else {
                $("#id_error").empty();
            }            

            $.ajax({
                type: "POST",
                dataType: "HTML",
                url: "../Controller/editar_permissao.php",
                data: "id=" + id,
                beforeSend: function () {
                    $("#conteudo_periodico").html("<img src='../../images/loading/load.gif' class='img-rounded img-responsive' id='imgpos'>");
                },
                success: function (response) {
                    $("#conteudo_periodico").html(response),
                            $('#button').css("display", "block").show(1090),
                            $('#datadoperiodico').css("display", "block").show(1090);
                },
                error: function () {
                    alert("Ocorreu um erro durante a requisição");
                }
            });
        }
    });
</script>
<style type="text/css">
    #imgpos {
        position:absolute;
        left:667px;
    }
</style>
<div class="widget">
    <div class="widget-header transparent">
        <h2><strong>Editar Permissões</strong> <acronym title="Informe os campos para otimizar o resultado!!!">Grupo AMA</acronym></h2>
        <div class="additional-btn">            
            <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>            
        </div>
    </div>
    <div class="widget-content padding">
        <div class="form-inline">
            <form id="form" method="POST">
                <div class="form-group">
                    <label for="empresa_label">Usuário:</label>
                    <select class="form-control" id="id" name="id" required autofocus>
                        <option selected value="0">
                            Selecione...
                        </option>
                        <?php
                        include '../config/database_mysql.php';
                        $pdo = Database::connect();
                        $sql = "select permit.id_usuario as id, users.nome_extenso as nome_extenso from usuarios_permissoes permit inner join usuarios users on users.id = permit.id_usuario order by nome asc";
                        foreach ($pdo->query($sql) as $value) {
                            echo '<option value="' . $value['id'] . '">' . $value['nome_extenso'] . '</option>';
                        }
                        Database::disconnect();
                        ?>
                    </select>
                    <div class="form-inline" id="id_error"></div>
                </div>                
                <button class="btn btn-primary" id="envia" type="submit">Mostrar Permissões</button>                
            </form>
        </div>
    </div>    
    <div class="widget-content padding" id="conteudo_periodico"></div>
</div>