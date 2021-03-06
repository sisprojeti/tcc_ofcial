<?php include('classes/class.curso.php') ?>
<?php

  try {
      $cursos = Curso::listar();
  } catch (Exception $e) {
    echo "ERROR:".$e->getMessage();
   }
?>
<!------------------------------------- MENU ----------------------------------->
<div class="area_menu">
  <p></p>
   <p class="texto-area">Lista de Cursos </p>
    <div><a href="index.php?modulo=curso&acao=adicionar" class="btn btn-success">Adicionar</a> </div>
</div>

<!------------------------------------- TABELA ----------------------------------->
<div class="container col-lg-12 navbar-white">
<section class="content navbar-light navbar-white">
<div class="container-fluid navbar-white ">
<div class="row">
<table class="table table-striped"style="margin-top:10px;">
<thead>
<tr>
<th scope="col">#</th>
<th scope="col">NOME</th>
<th scope="col">SIGLA</th>
<th scope="col">SITUAÇÃO</th>
<th scope="col">AÇÃO</th>
</tr>
</thead>
<tbody>
<?php if(isset($cursos)){
  foreach($cursos as $curso){?>
    <tr>
    <th scope="row"><?php echo $curso->getIdCurso();?></th>
    <td><?php echo $curso->getNomeCurso();?></td>
    <td><?php echo $curso->getSigla();?></td>
    <td>
    <?php if(!$curso->getStatusCurso()){
      echo "Inativo";
    }else{
      echo "Ativo";
    };?></td>
    <td width=250>
      <a class="btn btn-info" href=""><i class="fas fa-eye"></i></a>
      <a class="btn btn-warning" href="?modulo=curso&acao=editar&id=<?php echo $curso->getIdcurso();?>"><i class="fas fa-edit"></i></a>
    <a class="btn btn-danger" href="?modulo=curso&acao=excluir&id=<?php echo $curso->getIdcurso();?>"><i class="fas fa-trash-alt"></i></a>
  </td>

    </tr>
<?php }}?>
</tbody>
</table>

</div>
 </div><!-- /.container-fluid -->
    </section>
  </div>
