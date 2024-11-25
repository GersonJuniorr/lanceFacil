<?php
class UsuarioManager
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function verificarMotorista($cpf)
    {
        try {
            // Inicializa a variável $existe
            $existe = false;    
    
            // Prepara e executa a consulta
            $stmt = $this->pdo->prepare("SELECT 1 FROM ACCOUNTS WHERE STATUS = 'ATIVO' AND cpf = :cpf");
            $stmt->execute([':cpf' => $cpf]);
    
            // Verifica se há resultados
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                $existe = true;
            }
    
            return $existe;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function obterNomePeloCPF($cpf)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT nome FROM ACCOUNTS WHERE cpf = :cpf');
            $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
            $stmt->execute();

            // Verifica se há algum resultado
            if ($stmt->rowCount() > 0) {
                // CPF (login) já existe, recuperando o nome completo
                $resultado = $stmt->fetchColumn();
            } else {
                // CPF (login) não existe
                $resultado = "Nome não encontrado";
            }
        } catch (Exception $e) {
            // Tratamento de exceção
            $resultado = "Nome não encontrado";
        }

        return $resultado;
    }


}

