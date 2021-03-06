<?php
  require_once('class.db.php');
    /**
     *  Criando uma class com o nome Usuarios
     */
    class Usuario
    {
      public $id_usuario;
      public $fk_pessoa;
      public $senha;
      public $login;

      public function __construct($id_usuario=false){
          if($id_usuario){
            $sql = "SELECT * FROM usuario where id_usuario = :id_usuario";
            $stmt = DB::conexao()->prepare($sql);
            $stmt->bindParam(":id_usuario",$id_usuario,PDO::PARAM_INT);
            $stmt->execute();
            foreach($stmt as $obj){
              $this->setIdUsuario($obj['id_usuario']);
              $this->setFkPessoa($obj['fk_pessoa']);
            }
          }
        }

        public function recuperaPessoa()
        {
          return new Pessoa($this->fk_pessoa);
        }


      public function adicionar()
      {
        $sql = "INSERT INTO usuario (senha,fk_pessoa) values (:senha,:fk_pessoa)";
        $conexao = DB::conexao();
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':senha',$this->senha);
        $stmt->bindParam(':fk_pessoa',$this->fk_pessoa);
        $stmt->execute();
        $ultimoIdUsuario = $conexao->lastInsertId();
        return $ultimoIdUsuario;
      }

      //+=============QUERY PRA VERIFICAR SE O ACADÊMICO
      // $query = "SELECT pessoa.nome as nome_aluno,ref_aluno_projeti.fk_aluno as fk_aluno from aluno join ref_aluno_projeti
      // on aluno.id_aluno = ref_aluno_projeti.fk_aluno
      //  join pessoa on pessoa.id_pessoa = aluno.fk_pessoa";

      //fazer atualização na função de logar pra verificar se o usuário logado já esta em algum grupo de projeti
      //veficiar como fazer lógica de verificar se o usuário está em algum grupo antes de realizar o login dele


      public static function logar($cpf = false, $senha = false){
        if($cpf && $senha){
          //$senha = md5($senha);
          $sql = "SELECT
          grupo.id_grupo as id_grupo,
          grupo.nome as nome_grupo,
          pessoa.nome as nome_pessoa,
          usuario.id_usuario as id_usuario,
          pessoa.id_pessoa as id_pessoa,
          pessoa.cpf as cpf,
          usuario.senha as senha
          FROM pessoa
          inner join usuario on pessoa.id_pessoa = usuario.fk_pessoa
          inner join ref_usuario_grupo on usuario.id_usuario = ref_usuario_grupo.fk_usuario
          inner join grupo on ref_usuario_grupo.fk_grupo = grupo.id_grupo
          where pessoa.cpf = :cpf and usuario.senha = :senha";

          // $sql = "SELECT ref_usuario_grupo.fk_grupo as fk_grupo,
          // grupo.nome as nome_grupo,
          // pessoa.nome as nome_pessoa,
          // ref_usuario_grupo.fk_usuario as fk_usuario,
          // usuario.fk_pessoa as fk_pessoa,
          // pessoa.cpf as cpf,
          // usuario.senha as senha FROM usuario
          // join pessoa on pessoa.id_pessoa = usuario.fk_pessoa
          // join grupo on grupo.id_grupo = ref_usuario_grupo.fk_pessoa
          // join ref_usuario_grupo on ref_usuario_grupo.fk_grupo = usuario.id_usuario
          // where pessoa.cpf = :cpf and usuario.senha = :senha";

          //----#------TEM QUE FAZER O SELECT CERTO PRA FAZER O LOGIN POIS ESTA COM BOG ----#------//
          // $sql = "SELECT ref_usuario_grupo.fk_grupo as fk_grupo,
          // ref_usuario_grupo.fk_usuario as ref_usuario_grupo,
          // grupo.nome as nome_grupo,
          // grupo.id_grupo as id_grupo,
          // pessoa.nome as nome_pessoa,
          // ref_usuario_grupo.fk_usuario as fk_usuario,
          // usuario.fk_pessoa as fk_pessoa,
          // usuario.id_usuario,
          // pessoa.cpf as cpf,
          // usuario.senha as senha FROM usuario
          // join grupo on grupo.id_grupo = usuario.fk_usuario
          // join pessoa on pessoa.id_pessoa = usuario.fk_pessoa
          // join ref_usuario_grupo on ref_usuario_grupo.fk_grupo = grupo.id_grupo
          // join ref_usuario_grupo as ref_teste on ref_teste.fk_usuario = usuario.id_usuario
          // where pessoa.cpf = :cpf and usuario.senha = :senha";


          $conexao = DB::conexao();
          $stmt = $conexao->prepare($sql);
          $stmt->bindParam(':senha',$senha);
          $stmt->bindParam(':cpf',$cpf);
          //$stmt->bindParam(':login',$this->login);
          $stmt->execute();
          $registros = $stmt->fetchAll();
          if($registros){
            foreach($registros as $objeto){
              //print_r($objeto);
              $_SESSION['fk_grupo'] = $objeto['id_grupo'];
              $_SESSION['nome_grupo'] = $objeto['nome_grupo'];
              $_SESSION['nome_pessoa'] = $objeto['nome_pessoa'];
              $_SESSION['fk_usuario'] = $objeto['id_usuario'];
              $_SESSION['fk_pessoa'] = $objeto['id_pessoa'];
              $_SESSION['cpf']  = $objeto['cpf'];
              $_SESSION['senha'] = $objeto['senha'];
              header('Location:index.php');
            }
          }else{
            header('Location:login.php?login_invalido=erro');
          }
        }
      }

      public function setFkPessoa($fk_pessoa){
        $this->fk_pessoa = $fk_pessoa;
      }

      public function getFkPessoa()
      {
        return $this->fk_pessoa;
      }

      public function setIdUsuario($id_usuario){
        $this->id_usuario = $id_usuario;
      }

      public function getNome()
      {
        return $this->nome;
      }

      public function setNome($nome_pessoa)
      {
        $this->nome = $nome;
      }
      public function getNomePessoa()
      {
        return $this->nome_pessoa;
      }

      public function setNomePessoa($nome_pessoa)
      {
        $this->nome_pessoa = $nome_pessoa;
      }

      public function getEmail()
      {
        return $this->email;
      }

      public function setEmail($email)
      {
        $this->email = $email;
      }

      public function getSenha()
      {
        return $this->senha;
      }

      public function setSenha($senha)
      {
        $this->senha = $senha;
      }

      public function setPessoaUsuarioId($ultimoIdPessoa)
      {
        $this->fk_pessoa = $ultimoIdPessoa;
      }

    }


?>
