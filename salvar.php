<?php 
include '../../../web/seguranca.php';

$user_ids = $_POST['user_ids'];
$escola = $_GET['escola'];
$ano = $_GET['anoletivo'];

$user_ids_string = implode(",", $user_ids);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['valores_tr'])) {
    $user_ids = $_POST['user_ids'];
    $values = array();
    foreach ($_POST['valores_tr'] as $index => $valores_tr) {
      $dados = explode(',', $valores_tr);
      $id_aluno = $user_ids[$index];
      $nome_aluno = $dados[0];
      $valores_tds = array_slice($dados, 1);

      // Loop pelos meses
      $meses = array('FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ');
      foreach ($meses as $mes) {
        $set_values = array();
        // Loop pelas colunas de cada mês
        for ($i = 1; $i <= 4; $i++) {
          $coluna = $mes . "_" . $i . "E";
          if (isset($valores_tds[$i-1])) {
            $valor = $valores_tds[$i-1];
            $set_values[] = "$coluna='$valor'";
          } else {
            $set_values[] = "$coluna=''";
          }
        }
        $set_values_str = implode(",", $set_values);
        $sql = "UPDATE list_pres SET " . $set_values_str . " WHERE id_usuario='" . $id_aluno . "' AND ano='" . $ano . "'";
        echo "SQL: " . $sql . "<br>";
        // Execute a query aqui
      }
    }
  }
}

?>
