<?php
    require_once('class.db.php');
    class Aluno
    {

      public $id_aluno;
      public $data_matricula;
      public $situacao_aluno;
      public $matricula;
      public $fk_pessoa;
      public $nome_aluno;

      public function setIdTurma($id_turma){
        $this->id_turma = $id_turma;
      }

      public function setNomeIntegrantes($nome_aluno){
        $this->nome_aluno = $nome_aluno;
      }

      public function getNomeIntegrantes(){
        return $this->nome_aluno;
      }
      //---------Provavelmente vamos utilizar esses atributos em outra classe-------
      //public $turma;
      //public $grupo_projeti;


      //---------------------------##########---------------------------------------

      public static function listarAlunoSemTurma()
      {
        try {
          $query = "SELECT aluno.id_aluno as id_aluno,pessoa.nome as nome_aluno from aluno
          join pessoa on pessoa.id_pessoa = aluno.fk_pessoa where aluno.id_aluno not in (select fk_aluno from ref_aluno_turma)";
        $stmt = DB::conexao()->prepare($query);
        $stmt->execute();
        $registros = $stmt->fetchAll();
          if($registros){
          foreach($registros as $objeto){
          $temporario = new Aluno();
          $temporario->setIdAluno($objeto['id_aluno']);
          $temporario->setNomeAluno($objeto['nome_aluno']);
           $itens[] = $temporario;
                        }
            return $itens;
          }
        } catch (Exception $e) {
            echo "ERROR".$e->getMessage();
        }
      }
      public function __construct($id_aluno=false){
          if($id_aluno){
            $sql = "SELECT aluno.id_aluno,
            pessoa.nome as nome_aluno,
            aluno.data_matricula as data_matricula from aluno
            join pessoa on pessoa.id_pessoa = aluno.fk_pessoa";
            $stmt = DB::conexao()->prepare($sql);
            $stmt->bindParam(":id_aluno",$id_aluno,PDO::PARAM_INT);
            $stmt->execute();
            foreach($stmt as $obj){
              $this->setIdAluno($obj['id_aluno']);
              $this->setNomeAluno($obj['nome_aluno']);
            }
          }
        }

        public function setIdGrupo($id_grupo){
          $this->id_grupo = $id_grupo;
        }

        public static function recuperaAluno($fk_pessoa)
        {
          return new Aluno($fk_pessoa);
        }


        public static function recuperaIdAluno($fk_pessoa)
        {
          print_r($fk_pessoa);
          $sql = "SELECT aluno.id_aluno as id_aluno,pessoa.nome as nome_aluno from aluno
          join pessoa on pessoa.id_pessoa = aluno.fk_pessoa where aluno.fk_pessoa = :fk_pessoa";
          $conexao = DB::conexao();
          $stmt = $conexao->prepare($sql);
          $stmt->bindParam(':fk_pessoa',$fk_pessoa);
          $stmt->execute();
          if($stmt){
            foreach($stmt as $obj){
              $temporario = new Aluno();
              $temporario->setIdAluno($obj['id_aluno']);
              $temporario->setNomeAluno($obj['nome_aluno']);
            }
            return $temporario;
            }
          }

          public static function recuperaIdAlunoLogado($fk_aluno){ //metodo pra recuperar o id do aluno que estiver logado (utilizar para realizar a criação de grupo)
            $sql = "SELECT * from aluno join pessoa on pessoa.id_pessoa = aluno.fk_pessoa"; //terminar select para puxar a fk_aluno
            $conexao = DB::conexao();
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            if($stmt){
              foreach($stmt as $objeto){
                $temporario = new Aluno();
                $temporario->setIdAlunoLogado($objeto['fk_aluno']);
                $temporario->setNomeAluno($objeto['nome_aluno']);
              }
            }
          }

          public function setNomeAluno($nome_aluno)
          {
            $this->nome_aluno = $nome_aluno;
          }

    public static function listar($busca = false)
      {
        try {
          $query = "SELECT aluno.id_aluno,
          pessoa.nome as nome,
          aluno.situacao_aluno as situacao_aluno,
          aluno.matricula as matricula
          from aluno join pessoa on aluno.fk_pessoa = pessoa.id_pessoa";
            if($busca){
              $query.= " and pessoa.nome like '%$busca%'";
            }
                      $stmt = DB::conexao()->prepare($query);
                      $stmt->execute();
                      $registros = $stmt->fetchAll();
                      if($registros){
                        foreach($registros as $objeto){
                          $temporario = new Aluno();
                          $temporario->setIdAluno($objeto['id_aluno']);
                          $temporario->setNomeAluno($objeto['nome']);
                          $temporario->setSituacaoAluno($objeto['situacao_aluno']);
                          $temporario->setMatricula($objeto['matricula']);
                          $itens[] = $temporario;
                        }
            return $itens;
          }
        } catch (Exception $e) {
            echo "ERROR".$e->getMessage();
        }
      }

      public static function listarAlunosTurma($fk_turma,$sem_projeti = null)
        {
          try {
            $query = "SELECT * FROM aluno
            join ref_aluno_turma on aluno.id_aluno = ref_aluno_turma.fk_aluno ";
            if($sem_projeti == true){
              $query .= "where NOT EXISTS (SELECT * FROM ref_aluno_projeti
              WHERE ref_aluno_projeti.fk_aluno = aluno.id_aluno)
              ";
            }
              //$query .= " where ref_aluno_turma.fk_turma = :fk_turma";
                        $stmt = DB::conexao()->prepare($query);
                        $stmt->bindParam(':fk_turma',$fk_turma);
                        $stmt->execute();
                        $registros = $stmt->fetchAll();
                        if($registros){
                          foreach($registros as $objeto){
                            $temporario = new Aluno();
                            $temporario->setIdAluno($objeto['id_aluno']);
                            $temporario->setFkPessoa($objeto['fk_pessoa']);
                            $itens[] = $temporario;
                          }
              return $itens;
            }
          } catch (Exception $e) {
              echo "ERROR".$e->getMessage();
          }
        }



      public static function contarAlunos()
        {
          try {
            $query = "select * from aluno";
                        $stmt = DB::conexao()->prepare($query);
                        $stmt->execute();
                        $registros = $stmt->fetchAll();
                        $totalAlunos = count($registros);
                        return $totalAlunos;
            }catch(Exception $e){
                echo "ERROR".$e->getMessage();
            }
          }

        public function exibeNome()
        {
          $sql = "SELECT * FROM aluno";
          $conexao = DB::conexao();
          $stmt = $conexao->prepare($sql);
        }


  //---------########### FINAL DA MELHORIA DO METODO DE LISTAR ############ -------------------

      public function adicionar(){
        try{
                  $sql = "INSERT INTO aluno(
                    fk_pessoa,
                    matricula,
                    data_matricula,situacao_aluno)
                    values(:fk_pessoa,:matricula,:data_matricula,:situacao_aluno)"; //criando uma variavel $stmt e atribuindo o valor da variavel $pdo e utilizand operador de acesso a objetos pra utilizar o metodo prepare pra preparar o insert no banco de dados
                  $conexao = DB::conexao();
                  $stmt = $conexao->prepare($sql);
                  $stmt->bindParam(':fk_pessoa',$this->fk_pessoa);
                  $stmt->bindParam(':matricula',$this->matricula);
                  $stmt->bindParam(':data_matricula',$this->data_matricula);
                  $stmt->bindParam(':situacao_aluno',$this->situacao_aluno);
                  $stmt->execute();
                  if($stmt){
                    echo '
                    <div id="snoAlertBox" class="alert alert-success" data-alert="alert">Adicionado com sucesso</div>
                    ';
                  }
                  $ultimoIdAluno = $conexao->lastInsertId(); //RECUPERANDO O ULTIMO ID INSERIDO
                  return $ultimoIdAluno;
        }catch(PDOException $e){
          echo 'ERRO:'.$e->getMessage();
        }
      }

              public function setIdAluno($id_aluno){
                $this->id_aluno = $id_aluno;
              }

              public function getIdAluno(){
                return $this->id_aluno;
              }

              public function setPessoaId($ultimoIdPessoa){
                $this->fk_pessoa = $ultimoIdPessoa;
              }

              public function getPessoaId($ultimoIdPessoa){
                return $this->fk_pessoa;
              }
            /*---------------------------------------------------------------------
              ENCAPSULAMENTO NOME
             ---------------------------------------------------------------------*/
            public function getNomeAluno(){
              return $this->nome_aluno;
            }


            public function setNome($nome){
              $this->nome = $nome;
            }

            /*---------------------------------------------------------------------
              ENCAPSULAMENTO email
             ---------------------------------------------------------------------*/
            public function getEmail(){
              return $this->email;
            }

            public function setEmail($email){
              $this->email = $email;
            }

          /*---------------------------------------------------------------------
            ENCAPSULAMENTO CPF
           ---------------------------------------------------------------------*/
            public function getCpf()
            {
              return $this->cpf;
            }

            public function setCpf($cpf)
            {
              $this->cpf = $cpf;
            }
          /*---------------------------------------------------------------------
            ENCAPSULAMENTO CPF
           ---------------------------------------------------------------------*/
            public function getTelefone(){
              return $this->telefone;
            }

            public function setTelefone($telefone){
              $this->telefone = $telefone;
            }

            /*---------------------------------------------------------------------
              ENCAPSULAMENTO data_matricula
             ---------------------------------------------------------------------*/
              public function getDataMatricula(){
                return $this->data_matricula;
              }

              public function setDataMatricula($data_matricula){
                $this->data_matricula = $data_matricula;
              }


              /*---------------------------------------------------------------------
                ENCAPSULAMENTO situacao_aluno
               ---------------------------------------------------------------------*/
                public function getSituacaoAluno(){
                  return $this->situacao_aluno;
                }

                public function setSituacaoAluno($situacao_aluno){
                  $this->situacao_aluno = $situacao_aluno;
                }

                /*---------------------------------------------------------------------
                  ENCAPSULAMENTO matricula
                ---------------------------------------------------------------------*/
                public function getMatricula(){
                  return $this->matricula;
                }

                public function setFkPessoa($fk_pessoa)
                {
                  $this->fk_pessoa = $fk_pessoa;
                }

                public function setMatricula($matricula){
                  $this->matricula = $matricula;
                }

                public function recuperaPessoa(){
                  return new Pessoa($this->fk_pessoa);
                }

      //VAMOS UTILIZAR ESSES METODOS EM OUTRA CLASS PROVAVELMENTE NÃO APAGAR
      // public function setTurma($turma){
      //     $this->turma = $turma;
      // }
      //
      // public function getTurma(){
      //     return $this->turma;
      // }
      //
      // public function getGrupoProjeti(){
      //   return $this->grupo_projeti;
      // }
      //
      // public function setGrupoProjeti($grupo_projeti){
      //   $this->grupo_projeto = $grupo_projeti;
      // }



      /*---------------------------------------------------------------------
        ENCAPSULAMENTO SENHA
       ---------------------------------------------------------------------*/
            private function getSenha()
            {
              return $this->senha;
            }

            private function setSenha($senha)
            {
              $this->senha = $senhaPadrao;
            }
          }

?>
