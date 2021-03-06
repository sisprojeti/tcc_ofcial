<?php

/**
 * Criando uma class com o nome "Tarefa" que será responsável por armazenar as tarefas referentes a cada oportunidade
 */
    class Tarefa
    {
      public $id_tarefa;
      public $fk_status_tarefa;
      public $fk_projeti;
      public $fk_aluno;
      public $titulo;
      public $descricao;
      public $data_inicio;
      public $data_entrega;
      public $responsavel_id;
      public $data_cadastro;
      public $nomeStatus;
      public $pessoa_nome;
      public $id_status_tarefa;
      public $fk_ref_aluno_projeti;
      public $status_tarefa;
      public $nomeAluno;
      public $nome_responsavel_tarefa;
      public $nome_status;

      public function __construct($id_tarefa=false){
          if($id_tarefa){
            $sql = "SELECT pessoa.nome as nome_responsavel_tarefa,
                        tarefa.id_tarefa as id_tarefa,
                        tarefa.titulo as titulo,
                        tarefa.data_inicio as data_inicio,
                        tarefa.data_entrega as data_entrega,
                        tarefa.descricao as descricao,
                        tarefa.data_cadastro as data_cadastro,
                        tarefa.fk_aluno as fk_aluno,
                        tarefa.fk_status_tarefa as fk_status_tarefa,
                        status_tarefa.nome as nome_status
                        from tarefa
                        join aluno on tarefa.fk_aluno = aluno.id_aluno
                        join pessoa on aluno.fk_pessoa = pessoa.id_pessoa
                        join status_tarefa on status_tarefa.id_status_tarefa = tarefa.fk_status_tarefa
                        where tarefa.id_tarefa = :id_tarefa";
            $stmt = DB::conexao()->prepare($sql);
            $stmt->bindParam(":id_tarefa",$id_tarefa,PDO::PARAM_INT);
            $stmt->execute();
            foreach($stmt as $obj){
              $this->setIdTarefa($obj['id_tarefa']);
              $this->setTitulo($obj['titulo']);
              $this->setDataInicio($obj['data_inicio']);
              $this->setDataEntrega($obj['data_entrega']);
              $this->setDescricao($obj['descricao']);
              $this->setDataCadastro($obj['descricao']);
              $this->setFkStatusTarefa($obj['fk_status_tarefa']);
              $this->setFkAlunoProjeti($obj['fk_aluno']);
              $this->setNomeResponsavelTarefa($obj['nome_responsavel_tarefa']);
              $this->setNomeStatusTarefa($obj['nome_status']);
            }
          }
        }

        public function Excluir($id_tarefa){
          $sql = "DELETE from tarefa where id_tarefa = :id_tarefa";
          $stmt = DB::conexao()->prepare($sql);
          $stmt->bindParam(":id_tarefa",$id_tarefa,PDO::PARAM_INT);
          $stmt->execute();
        }

      public function setFkAlunoProjeti($fk_aluno)
      {
        $this->fk_aluno = $fk_aluno;
      }

      public function setFkProjeti($fk_projeti)
      {
        $this->fk_projeti = $fk_projeti;
      }

      public function getFkStatusTarefa()
      {
        return $this->fk_status_tarefa;
      }

      public function getFkRefAlunoProjeti()
      {
        return $this->fk_ref_aluno_projeti;
      }

      public static function listarStatusTarefa(){
        try {
          $query = "select * from status_tarefa";
              $stmt = DB::conexao()->prepare($query);
              $stmt->execute();
              $registros = $stmt->fetchAll();
              if($registros){
                foreach($registros as $objeto){
                  $temporario = new Tarefa();
                  $temporario->setIdStatusTarefa($objeto['id_status_tarefa']);
                  $temporario->setNomeStatusTarefa($objeto['nome']);
                  $itens[] = $temporario;
                }
                return $itens;
              }
            }
            catch (Exception $e){
              echo "ERROR".$e->getMessage();
            }
      }

        //metodo pra atualizar tarefa
        //atualizar o atributo status para a tarefa mudar de aba
        //verificar se é possível alterar a chave estrangeira do status pra alterar a aba da tarefa
        public function AtualizarTarefa(){
        if($this->id_tarefa){
          $sql = "UPDATE tarefa
          SET
          titulo = :titulo,
          data_inicio = :data_inicio,
          data_entrega = :data_entrega,
          descricao = :descricao,
          fk_status_tarefa = :fk_status_tarefa,
          fk_aluno = :fk_aluno
          where id_tarefa = :id_tarefa";
          $stmt = DB::conexao()->prepare($sql);
          $stmt->bindParam(':id_tarefa',$this->id_tarefa,PDO::PARAM_INT);
          $stmt->bindParam(':titulo',$this->titulo,PDO::PARAM_STR);
          $stmt->bindParam(':data_inicio',$this->data_inicio,PDO::PARAM_STR);
          $stmt->bindParam(':data_entrega',$this->data_entrega,PDO::PARAM_STR);
          $stmt->bindParam(':descricao',$this->descricao,PDO::PARAM_STR);
          $stmt->bindParam(':fk_status_tarefa',$this->fk_status_tarefa,PDO::PARAM_INT);
          $stmt->bindParam(':fk_aluno',$this->fk_aluno,PDO::PARAM_INT);
          $stmt->execute();
        }
      }

      // public function arquivarTarefa(){
      //   if($this->id_tarefa)
      // }

        public function getIdTarefa()
        {
          return $this->id_tarefa;
        }

        public static function listarTarefas(){
          try { $query = "select * from tarefa";
                $stmt = DB::conexao()->prepare($query);
                $stmt->execute();
                $registros = $stmt->fetchAll();
                if($registros){
                  foreach($registros as $objeto)
                  {
                    $temporario = new Tarefa();
                    $temporario->setIdTarefa($objeto['id_tarefa']);
                    $temporario->setTitulo($objeto['titulo']);
                    $temporario->setDataInicio($objeto['data_inicio']);
                    $temporario->setDataEntrega($objeto['data_entrega']);
                    $temporario->setDescricao($objeto['descricao']);
                    $temporario->setDataCadastro($objeto['data_cadastro']);
                    $temporario->setStatusTarefa($objeto['fk_status_tarefa']);
                    //$temporario->setFkRefAlunoProjeti($objeto['fk_ref_aluno_projeti']);
                    $itens[] = $temporario;
                    }
                      return $itens;
                    }
            } catch (Exception $e) {
                echo "ERROR".$e->getMessage();
            }
          }

          //query pra listar o nome e a fk do Aluno
          //select pessoa.nome,ref_aluno_projeti.fk_aluno
          //from pessoa join aluno join ref_aluno_projeti on pessoa.id_pessoa = aluno.fk_pessoa;
          //realizar alteração no select de listar pra listar o fk do aluno
          public static function listar($status=null){
            try {
              $query = "SELECT pessoa.nome as nome_responsavel_tarefa,
                          tarefa.id_tarefa as id_tarefa,
                          tarefa.fk_aluno as fk_aluno,
                          tarefa.titulo as titulo,
                          tarefa.data_inicio as data_inicio,
                          tarefa.data_entrega as data_entrega,
                          tarefa.descricao as descricao,
                          tarefa.data_cadastro as data_cadastro,
                          tarefa.fk_status_tarefa as fk_status_tarefa,
                          status_tarefa.nome as nome_status
                          from tarefa
                          join aluno on tarefa.fk_aluno = aluno.id_aluno
                          join pessoa on aluno.fk_pessoa = pessoa.id_pessoa
                          join status_tarefa on status_tarefa.id_status_tarefa = tarefa.fk_status_tarefa";
                if($status){

                  $query.=" WHERE fk_status_tarefa = $status";
                }

                            $stmt = DB::conexao()->prepare($query);
                            $stmt->execute();
                            $registros = $stmt->fetchAll();
                            if($registros){
                              foreach($registros as $objeto){
                                $temporario = new Tarefa();
                                $temporario->setIdTarefa($objeto['id_tarefa']);
                                $temporario->setTitulo($objeto['titulo']);
                                $temporario->setDataInicio($objeto['data_inicio']);
                                $temporario->setDataEntrega($objeto['data_entrega']);
                                $temporario->setDataCadastro($objeto['data_cadastro']);
                                $temporario->setFkStatusTarefa($objeto['fk_status_tarefa']);
                                $temporario->setFkAluno($objeto['fk_aluno']);
                                $temporario->setNomeResponsavelTarefa($objeto['nome_responsavel_tarefa']);
                                $temporario->setNomeStatusTarefa($objeto['nome_status']);
                                $temporario->setDescricao($objeto['descricao']);
                                $itens[] = $temporario;
                              }
                  return $itens;
                }
              } catch (Exception $e) {
                  echo "ERROR".$e->getMessage();
              }
            }

          public function setFkAluno($fk_aluno)
          {
            $this->fk_aluno = $fk_aluno;
          }

          public function setFkStatusTarefa($fk_status_tarefa){
            $this->fk_status_tarefa = $fk_status_tarefa;
          }

          public function setIdTarefa($id_tarefa)
          {
            $this->id_tarefa = $id_tarefa;
          }

        // public static function listarAlunosTarefa()
        //   {
        //     try {
        //       $query = "SELECT pessoa.nome as pessoa_nome,tarefa.fk_ref_aluno_projeti as fk_ref_aluno_projeti from pessoa
        //       join aluno on pessoa.id_pessoa = aluno.fk_pessoa join
        //       ref_aluno_projeti on aluno.id_aluno = ref_aluno_projeti.fk_aluno
        //       join tarefa on tarefa.fk_ref_aluno_projeti = ref_aluno_projeti.fk_aluno";
        //       //falta fazer um join com a tabela de status
        //       //retornar todos os atributos da tarefa
        //                   $stmt = DB::conexao()->prepare($query);
        //                   $stmt->execute();
        //                   $registros = $stmt->fetchAll();
        //                   if($registros){
        //                     foreach($registros as $objeto){
        //                       $temporario = new Tarefa();
        //                       $temporario->setIdTarefa($objeto['id_tarefa']);
        //                       $temporario->setIdFkResponsavelTarefa($objeto['fk_ref_aluno_projeti']);
        //                       $temporario->setNomeResponsavelTarefa($objeto['pessoa_nome']);
        //                       //$temporario->setStatusTarefa($objeto['status_tarefa']);
        //                       $itens[] = $temporario;
        //                     }
        //         return $itens;
        //       }
        //     } catch (Exception $e) {
        //         echo "ERROR".$e->getMessage();
        //     }
        //   }

        public static function listarAlunosTarefa()
          {
            try {
              $query = "SELECT pessoa.nome as nome_aluno from tarefa
                        join ref_aluno_projeti on tarefa.fk_ref_aluno_projeti = ref_aluno_projeti.id_ref_aluno_projeti
                        join aluno on ref_aluno_projeti.fk_aluno = aluno.id_aluno
                        join pessoa on aluno.fk_pessoa = pessoa.id_pessoa;";
              //falta fazer um join com a tabela de status
              //retornar todos os atributos da tarefa
                          $stmt = DB::conexao()->prepare($query);
                          $stmt->execute();
                          $registros = $stmt->fetchAll();
                          if($registros){
                            foreach($registros as $objeto){
                              $temporario = new Tarefa();
                              $temporario->setIdTarefa($objeto['id_tarefa']);
                              $temporario->setIdFkResponsavelTarefa($objeto['fk_ref_aluno_projeti']);
                              $temporario->setNomeResponsavelTarefa($objeto['nome_aluno']);
                              //$temporario->setStatusTarefa($objeto['status_tarefa']);
                              $itens[] = $temporario;
                            }
                return $itens;
              }
            } catch (Exception $e) {
                echo "ERROR".$e->getMessage();
            }
          }

          public function getIdFKRefAlunoProjeti()
          {
            return $this->fk_ref_aluno_projeti;
          }

          public function setNomeResponsavelTarefa($nome_responsavel_tarefa){
            $this->nome_responsavel_tarefa = $nome_responsavel_tarefa;
          }

          public function getNomeResponsavelTarefa()
          {
            return $this->nome_responsavel_tarefa;
          }

          public function setStatusTarefa($status_tarefa){
            return $this->status_tarefa;
          }

          public static function setIdResponsavelTarefa($fk_ref_aluno_projeti){
            $this->fk_ref_aluno_projeti = $fk_ref_aluno_projeti;
          }


        public function adicionar(){
      		$query = 'INSERT into tarefa(
            titulo,
            data_inicio,
            data_entrega,
            descricao,
            data_cadastro,
            fk_status_tarefa,
            fk_projeti,
            fk_aluno)
          values
          ( :titulo,
            :data_inicio,
            :data_entrega,
            :descricao,
            :data_cadastro,
            :fk_status_tarefa,
            :fk_projeti,
            :fk_aluno)';
          $conexao = DB::conexao();
          $stmt = $conexao->prepare($query);
      		$stmt->bindValue(':titulo',$this->titulo);
      		$stmt->bindValue(':data_inicio',$this->data_inicio);
      		$stmt->bindValue(':data_entrega',$this->data_entrega);
      		$stmt->bindValue(':descricao',$this->descricao);
          $stmt->bindValue(':data_cadastro',$this->data_cadastro);
          $stmt->bindValue(':fk_status_tarefa',$this->fk_status_tarefa);
          $stmt->bindValue(':fk_projeti',$this->fk_projeti);
      		$stmt->bindValue(':fk_aluno',$this->fk_aluno);
          $stmt->execute();
      	}

        public static function contarTotalTarefas()
      	    {
      	      try {
      	        $query = "select * from tarefa";
      	                    $stmt = DB::conexao()->prepare($query);
      	                    $stmt->execute();
      	                    $registros = $stmt->fetchAll();
      	                    $totalTarefas = count($registros);
      	                    return $totalTarefas;
      	        }catch(Exception $e){
      	            echo "ERROR".$e->getMessage();
      	        }
      	      }

        public static function contarTarefasFazer()
      	    {
      	      try {
      	        $query = "select * from tarefa where fk_status_tarefa = 1";
      	                    $stmt = DB::conexao()->prepare($query);
      	                    $stmt->execute();
      	                    $registros = $stmt->fetchAll();
      	                    $totalTarefas = count($registros);
      	                    return $totalTarefas;
      	        }catch(Exception $e){
      	            echo "ERROR".$e->getMessage();
      	        }
      	      }

              public static function contarTarefasFazendo()
            	    {
            	      try {
            	        $query = "select * from tarefa where fk_status_tarefa = 2";
            	                    $stmt = DB::conexao()->prepare($query);
            	                    $stmt->execute();
            	                    $registros = $stmt->fetchAll();
            	                    $totalTarefas = count($registros);
            	                    return $totalTarefas;
            	        }catch(Exception $e){
            	            echo "ERROR".$e->getMessage();
            	        }
            	      }

                    public static function contarTarefasRevisao()
                  	    {
                  	      try {
                  	        $query = "select * from tarefa where fk_status_tarefa = 3";
                  	                    $stmt = DB::conexao()->prepare($query);
                  	                    $stmt->execute();
                  	                    $registros = $stmt->fetchAll();
                  	                    $totalTarefas = count($registros);
                  	                    return $totalTarefas;
                  	        }catch(Exception $e){
                  	            echo "ERROR".$e->getMessage();
                  	        }
                  	      }

                          public static function contarTarefasFeito()
                              {
                                try {
                                  $query = "select * from tarefa where fk_status_tarefa = 4";
                                              $stmt = DB::conexao()->prepare($query);
                                              $stmt->execute();
                                              $registros = $stmt->fetchAll();
                                              $totalTarefas = count($registros);
                                              return $totalTarefas;
                                  }catch(Exception $e){
                                      echo "ERROR".$e->getMessage();
                                  }
                                }

        public function setFkRefAlunoProjeti($fk_ref_aluno_projeti)
        {
          $this->fk_ref_aluno_projeti = $fk_ref_aluno_projeti;
        }


        public function setIdStatusTarefa($id_status_tarefa){
          $this->id_status_tarefa = $id_status_tarefa;
        }

        public function getIdStatusTarefa(){
          return $this->id_status_tarefa;
        }

        public function setNomeStatusTarefa($nome_status){
          $this->nome_status = $nome_status;
        }

        public function getNomeStatusTarefa(){
          return $this->nome_status;
        }

/*---------------------------------------------------------------------
  DESCRIÇÃO
 ---------------------------------------------------------------------*/
      public function getDescricao(){
        return $this->descricao;
      }

      public function setDescricao($descricao){
        $this->descricao = $descricao;
      }

/*---------------------------------------------------------------------
  DATA INICIO
 ---------------------------------------------------------------------*/
      public function getDataInicio(){
        return $this->data_inicio;
      }

      public function setDataInicio($data_inicio){
        $this->data_inicio = $data_inicio;
      }

/*---------------------------------------------------------------------
  DATA ENTREGA
 ---------------------------------------------------------------------*/

      public function getDataEntrega(){
        return $this->data_entrega;
      }

      public function setDataEntrega($data_entrega){
        $this->data_entrega = $data_entrega;
      }

/*---------------------------------------------------------------------
  FK DO ALUNO
 ---------------------------------------------------------------------*/

      public function getFkAluno()
      {
        return $this->fk_aluno;
      }


/*---------------------------------------------------------------------
  RESPONSAVEL
 ---------------------------------------------------------------------*/

      public function getResponsavel(){
        return $this->responsavel;
      }

      public function setResponsavel($responsavel){
        $this->responsavel = $responsavel;
      }

/*---------------------------------------------------------------------
  TITULO
---------------------------------------------------------------------*/

      public function getTituloTarefa(){
        return $this->titulo;
      }

      public function setTitulo($titulo){
        $this->titulo = $titulo;
      }

/*---------------------------------------------------------------------
  DATA CADASTRO
 ---------------------------------------------------------------------*/

      public function getDataCadastro(){
        return $this->data_cadastro;
      }

      public function setDataCadastro($data_cadastro){
        $this->data_cadastro = $data_cadastro;
      }


    }

    // $novaTarefa = new Tarefa("CRUD de usuários","Fazer a lógica do CRUD de usuários","28-09-2019","29-09-2019","Diego Barbosa");
    //
    // var_dump($novaTarefa);

?>
