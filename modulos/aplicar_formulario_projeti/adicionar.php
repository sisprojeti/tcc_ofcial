<?php

require_once("classes/class.aluno.php");
include('classes/class.turma.php');
include('classes/class.refFormularioAvaliacaoProjeti.php');
include('classes/class.criterio.php');
include('classes/class.professor.php');
include('classes/class.nota.php');


try {
    $formularios_avaliacao_projeti = RefFormularioAvaliacaoProjeti::listarProjeti($_GET['fk_projeti']);
    echo "<pre>";
    print_r($formularios_avaliacao_projeti);
    echo "</pre>";
    foreach ($formularios_avaliacao_projeti as $formulario_avaliacao_projeti){
      $id_ref_formulario_projeti = $formulario_avaliacao_projeti->getIdFormularioAvaliacaoProjeti();
      $nome_turma = $formulario_avaliacao_projeti->getNomeTurma();
      $nome_projeti = $formulario_avaliacao_projeti->getNomeProjeti();
      $data_avaliacao = $formulario_avaliacao_projeti->getDataAvaliacao();
    }
} catch (Exception $e) {
  echo "ERROR:".$e->getMessage();
}

try {
if(isset($_POST["button"]) && ($_POST["button"] === "Salvar")){
   mostrar($_REQUEST);
     $crits = Criterio::listar($_GET['fk_projeti']);
     foreach ($_POST['fk_pessoa'] as $pessoa){
       foreach ($crits as $crit){
       $ref = $pessoa."-".$crit->getIdCriterio();
       $nota_criterio = $_POST[$ref];
       $notas = new Nota();
       $nota->setValor($nota_criterio);
       $nota->setDataModificao('2020-09-21');
       $nota->setFkCriterio($crit->getIdCriterio());
       $nota->setFkAluno($pessoa->getIdPessoa());
       $nota->setFkProfessor($)
       }
   }
   // $notas->setValor($_POST['valor_maximo']);
   // $notas->setDataModificacao($_POST['data_modificacao']);
   // $ultimoIdPessoa = $notas->adicionar();
}
} catch (PDOException $e) {
  echo "ERROR".$e->getMessage();
}


try {
    $criterios = Criterio::listar($_GET['fk_projeti']);
    // echo "<pre>";
    // print_r($criterios);
    // echo "</pre>";
} catch (Exception $e) {
  echo "ERROR:".$e->getMessage();
}

try {
    $professores = Professor::listar();
// echo "<pre>";
//     print_r($professores);
// echo "</pre>";
} catch (Exception $e) {
  echo "ERROR:".$e->getMessage();
 }



?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <style>
       .error{
             color:red
       }
</style>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
 <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
 <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

       <script type="text/javascript">
  $(document).ready(function(){
    $("#cpf").mask("000.000.000-00");
    $("#celular").mask("(00) 00000-0000");
  });
</script>
</head>
<body>
<div class="content-header navbar-white">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6" style="">
            <h3 class="m-0 text-dark">Aplicação de Formulário Avaliativo</h3>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Aplicar Formulário Acadêmicos</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header --->

    <!-- Main content -->
<div class="container col-lg-12 navbar-white">
<div class="container col-lg-8 navbar-white">

<section class="content navbar-light navbar-white">
<div class="container-fluid navbar-white ">
<form role="form" id="form_avaliacao_projeti" action="#" method="POST" >
  <div class="form-group"> <br>
    <p name="nome_turma" style="font-size: 20px;" > <b> Turma - <?php echo $nome_turma;?> <b></p>
  </div>
  <div class="form-group">
    <label for="">Tema do Projete</label>
    <input class="form-control" disabled type="" name="nome_projeti" value="<?php echo $nome_projeti;?>">
  </div>
  <div class="form-group">
    <label for="">Data da Avaliação</label>
    <input class="form-control" disabled type="" name="" value="<?php echo date('d/m/Y', strtotime($data_avaliacao));?>">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Seleção de Avaliadores</label>
    <select name="id_professor_um" class="form-control" id="exampleFormControlSelect1">
    <?php foreach ($professores as $professor):?>
        <option value="<?php echo $professor->getIdProfessor();?>"><?php echo $professor->getNomeProfessor();?></option>
    <?php endforeach; ?>
    </select>
    <br>
    <select name="id_professor_dois" class="form-control" id="exampleFormControlSelect1">
    <?php foreach ($professores as $professor):?>
        <option value="<?php echo $professor->getIdProfessor();?>"><?php echo $professor->getNomeProfessor();?></option>
    <?php endforeach; ?>
    </select>
    <br>
    <select name="id_professor_tres" class="form-control" id="exampleFormControlSelect1">
    <?php foreach ($professores as $professor):?>
        <option value="<?php echo $professor->getIdProfessor();?>"><?php echo $professor->getNomeProfessor();?></option>
    <?php endforeach; ?>
    </select>
  </div> <br>
  <label>Grupo do Projete</label> 
  <?php foreach ($formularios_avaliacao_projeti as $formularios_avaliacao_projeti): ?>
<<<<<<< HEAD
    <div class="form-group">
      <label>Nome Integrante projeti</label>
      <input type="hidden" name="fk_pessoa[]" value="<?php echo $formularios_avaliacao_projeti->getIdPessoa();?>">
      <input type="text" class="form-control" disabled value="<?php echo $formularios_avaliacao_projeti->getNomePessoa()?>" placeholder="" name="nome" minlength="15" required>
      <?php if($criterios):?>
=======
      
    <div class="form-group" > 
      <input style="margin-bottom: 1%;" type="text" class="form-control" disabled value="<?php echo $formularios_avaliacao_projeti->getNomePessoa()?>" placeholder="Insira o Nome Completo" name="nome" minlength="15" required>
      <!--<?php if($criterios):?>
>>>>>>> 3466bcb7c0cc4e159f48fde65de871fe53ad1104
          <?php foreach ($criterios as $criterio):?>
      <div class="form-group">
        Nome do Criterio:<label><?php echo $criterio->getNomeCriterio();?></label>
        Valor Maximo:<label for=""><?php echo $criterio->getValorMaximo();?></label>
      </div>
      <input class="form-control" type="text" name="<?php echo $formularios_avaliacao_projeti->getIdPessoa();?>-<?php echo $criterio->getIdCriterio();?>" value="">
    <?php endforeach;?>
    <hr>
    <?php endif ;?>
    </div>-->
  <?php endforeach; ?> 
<!--
<div class="form-group">
    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
    <input type="checkbox" name="situacao_aluno" class="custom-control-input" id="customSwitch3" value="true">
    <label class="custom-control-label" for="customSwitch3"> Ativo  </label>
</div>-->


 </div>
 <!-- /.card-body -->
<div class="form-group navbar-white" style="text-align: center;">
    <input type="submit" name="button" value="Salvar" class="btn btn-success" style="width: 20%;" >
</div>
</form>
    <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
</div>

      <script>
            $("#form_academicos").validate({
       rules : {
              nome:{
                    required:true,
                    minlength:6,
                    accept: "[a-zA-Z]+",
             },
             email:{

                    required:true,
                    email: true
             },
             cpf:{
                    required:true,
                    cpf: true, //tenho que dar uma olhada nesse campo cpf
             },
             telefone: {
                    required: true,
             },
             data_matricula: {
                    required: true,

             },
             matricula: {
                    required: true,
             },
       },
       messages:{
            nome:{
                    required:"Por favor, informe o nome",
                    minlength:"Insira o nome completo",
                    accept: "Cuidado! preencha o nome sem caracteres especiais"
             },
             email:{
                    required:"Por favor, informe o Email",
                    email:"Insira um Email válido."
             },
            cpf:{
                    required:"Por favor, informe um CPF válido",
             },
              telefone:{
                    required:"Por favor, insira o  nº de telefone"
             },
             data_matricula:{
                    required:"Por favor, insira a data de matricula",
             },
             matricula:{
                    required:"Por favor, insira o nº da matricula"
             },
       }

});

        //NOME
            jQuery.validator.addMethod("accept", function(value, element, param) {
              return value.match(new RegExp("." + param + "$"));
            });

        //SENHA
            $.validator.addMethod("passwordcheck", function(value) {
               return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) //
                   && /[a-z]/.test(value) // letra minúscula
                   && /\d/.test(value) // número
            });

        //EMAIL
           $.validator.addMethod( //Metodo, Filtro de Email Válido. por exemplo: "usuario@admin.state.in.us" ou "nome@site.a"
                  'email',
                  function(value, element){
                      return this.optional(element) || /(^[-!#$%&'*+/=?^_`{}|~0-9A-Z]+(\.[-!#$%&'*+/=?^_`{}|~0-9A-Z]+)*|^"([\001-\010\013\014\016-\037!#-\[\]-\177]|\\[\001-\011\013\014\016-\177])*")@((?:[A-Z0-9](?:[A-Z0-9-]{0,61}[A-Z0-9])?\.)+(?:[A-Z]{2,6}\.?|[A-Z0-9-]{2,}\.?)$)|\[(25[0-5]|2[0-4]\d|[0-1]?\d?\d)(\.(25[0-5]|2[0-4]\d|[0-1]?\d?\d)){3}\]$/i.test(value);
                  },
                  'Insira um Email Válido.'
              );

           //CPF

                 jQuery.validator.addMethod("cpf", function(value, element) {
             value = jQuery.trim(value);

            value = value.replace('.','');
            value = value.replace('.','');
            cpf = value.replace('-','');
            while(cpf.length < 11) cpf = "0"+ cpf;
            var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
            var a = [];
            var b = new Number;
            var c = 11;
            for (i=0; i<11; i++){
              a[i] = cpf.charAt(i);
              if (i < 9) b += (a[i] * --c);
            }
            if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
            b = 0;
            c = 11;
            for (y=0; y<10; y++) b += (a[y] * c--);
            if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

            var retorno = true;
            if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

            return this.optional(element) || retorno;

          }, "Informe um CPF válido");


       </script>

</body>
</html>