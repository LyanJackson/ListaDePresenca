<?php include '../../web/seguranca.php';

$title = "AdminPFC - Lista de Presença";




include '../head.php';

if(isset($_GET['p']))
	$p = $_GET['p'];

if(empty($_GET['cidade']) AND empty($_GET['escola']) AND empty($_GET['serie'])):
	
	
	?>



<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
  <meta http-equiv='X-UA-Compatible' content='ie=edge'>
  <title>FREQUÊNCIA</title>
  <link rel='stylesheet' href='/sistema/lista_pres/css/style.css'>
  <style id='table-column'></style>
</head>


<body id="corpo" class="hold-transition skin-black sidebar-mini fixed">

    <div class="wrapper">

    <?php include '../menu.php'; ?>
	
        <div class="content-wrapper">
            <section class="content-header">
                <?php if(!isset($p)): ?>
                    <a href="<?php echo $root_html ?>sistema/" class="btn btn-default"><i class="fa fa-arrow-left"></i>&ensp;Voltar</a>                
                <?php elseif(isset($p)): ?>
                    <a href="<?php echo $root_html ?>sistema/alunos/buscar/" class="btn btn-default"><i class="fa fa-arrow-left"></i>&ensp;Voltar</a>                

                <?php endif; ?>
              <ol class="breadcrumb">
                <li><a href="<?php echo $root_html ?>sistema/"><i class="fa fa-dashboard"></i> Home</a></li>
                <li>Alunos</li>
                <?php if(!isset($p)): ?>
                <li class="active">Lista de Presença</li>
                <?php endif; ?>           
              </ol> 
            </section>

        	<div class="container-fluid">

				
				<form id="buscaAluno" method="GET" class="forms-buscar row">
					<h1 class="text-center">Lista de Presença<br><small>Selecione o que desejar preencher</small></h1>
					<br>
					<hr>

					<div class="col-md-12 text-center">
						<div class="radio">
							<label for="todos">
								<input checked type="radio" name="status" id="todos" value="todos"> Todos
							</label>&ensp;
							<label for="ativo">
								<input type="radio" name="status" id="ativo" value="ativo"> Somente ativos
							</label>&ensp;
							<label for="inativo">
								<input type="radio" name="status" id="inativo" value="inativo"> Somente inativos
							</label>&ensp;
						</div>
					</div>
					<br>
					<hr>
					<br>

					<div class="col-md-6 form-group">
						<label for="cidade">Cidade</label>
						<select name="cidade" id="cidade" class="form-control">
							<?php 
								$sql = "SELECT DISTINCT e.cidade FROM escola AS e WHERE ativo = 1 ORDER BY cidade";
								$res = mysqli_query($_SG['link'], $sql);
								while($row = mysqli_fetch_array($res)): ?>
									<option value="<?php echo $row['cidade'] ?>"><?php echo $row['cidade'] ?></option>
								<?php endwhile; ?>
						</select>
					</div>

					<div class="col-md-6 form-group">
						<label for="escola">Escola</label>
						<select name="escola" id="escola" class="form-control">
						<option value="" selected>Selecione uma cidade antes</option>
										
					</select>
					</div>
					



					<div class="col-md-6">
						<label for="serie">Série</label>
						<select name="serie" id="serie" class="form-control">
						            <?php
                                        $query = mysqli_query($_SG['link'], "SELECT DISTINCT serie FROM alunos WHERE serie <> 'XX' AND serie <> 0 ORDER BY serie DESC");
                                        while ($row = mysqli_fetch_assoc($query)) :

                                            switch ($row['serie']) {
                                                case '5EF':
                                                    $serie = "5º Ensino Fundamental";
                                                    break;
                                                case '6EF':
                                                    $serie = "6º Ensino Fundamental";
                                                    break;
                                                case '7EF':
                                                    $serie = "7º Ensino Fundamental";
                                                    break;
                                                case '8EF':
                                                    $serie = "8º Ensino Fundamental";
                                                    break;
                                                case '9EF':
                                                    $serie = "9º Ensino Fundamental";
                                                    break;
                                                case '1EM':
                                                    $serie = "1º Ensino Médio";
                                                    break;
                                                case '2EM':
                                                    $serie = "2º Ensino Médio";
                                                    break;
                                                case '3EM':
                                                    $serie = "3º Ensino Médio";
                                                    break;

                                                default:
                                                    $serie = "ERRO";
                                                    break;
                                            }

                                        ?>

                                            <option value="<?php echo $row['serie'] ?>"><?php echo $serie ?></option>

                                        <?php endwhile; ?>

						</select>
					</div>

					<div class="col-md-6">
						<label for="anoletivo">Ano Letivo</label>
						<select name="anoletivo" class="form-control" id="anoletivo" maxlength="4" name="data_ingresso">
							<option value="2023a">2023</option>
							<!--<option value="2024a">2024</option>-->
						</select>
					</div>

					<div class="text-center col-md-12">
								<br><br>
						<button method="GET" name="gerarlista" id="gerarlista" class="btn btn-light btn-lg" title="Clique aqui para gerar a lista de presença digital" data-toggle="tooltip">
			   	          GERAR LISTA
				 		</button>
					</div>
					
					<br>
					<br><br>
					<br>
					<br>
					<hr>
					<br>
					<br>
					<div class="text-center col-md-12">
								<br><br>
						<hr>
						<button method="GET" name="gerarpdf" id="gerarpdf" class="btn btn-danger btn-lg" title="Clique aqui para gerar o PDF da lista de presença" data-toggle="tooltip">	
						<i class="fa fa-file-pdf-o"></i> PDF
						</button>
					</div>

				</div>
			
		 </form>
	</div>
		

</body>	 
 
					
					

<?php include '../../footer.php'; ?>

<script>
	
	
	$('#cidade').change(function(event) {
			
		var data = {
			cidade: $(this).val()
		}

		$.ajax({
			url: '<?php echo $root_html ?>sistema/alunos/buscar/busca_escola.php',
			type: 'POST',
			data: data,
		})

		.done(function(data) {
			$('#escola').html(data);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});

	
	});



</script>


		
<!--PARA TODOS SCRIPT-->
<?php  else:


if (isset($_GET['gerarlista'])){

?>
	
<body id="corpo" class="hold-transition skin-black sidebar-mini fixed">

<div class="wrapper">

<?php include '../menu.php'; ?>

	<div class="content-wrapper">	
            <section class="content-header">
                <?php if(!isset($p)): ?>
                    <a href="<?php echo $root_html ?>sistema/" class="btn btn-default"><i class="fa fa-arrow-left"></i>&ensp;Voltar</a>                
                <?php elseif(isset($p)): ?>
                    <a href="<?php echo $root_html ?>sistema/alunos/buscar/" class="btn btn-default"><i class="fa fa-arrow-left"></i>&ensp;Voltar</a>                

                <?php endif; ?>
              <ol class="breadcrumb">
                <li><a href="<?php echo $root_html ?>sistema/"><i class="fa fa-dashboard"></i> Home</a></li>
                <li>Lista de Presença</li>
                <?php if(!isset($p)): ?>
                <li class="active">Lista de Presença Digital</li>
                <?php endif; ?>           
              </ol> 
            </section>

<form action="salvar.php" onsubmit="atualizarInputs()" method="POST" class="forms-buscar row">

  <div class="container-fluid">

	<div style="text-align:center;" class="app">
	<br><br>
	<h1 class="fw-light m-0">Lista de Presença Digital</h1>
		<h2>LEGENDA</h2>
		<b>F: Faltou</b>
		
		<b>J: Justificou</b>
	
		<b>P: Presente</b>
		<hr>
	
		
    <div class="text-center p-12">
    <button type="submit" class="btn btn-primary" title="Clique aqui para salvar a lista de presença" data-toggle="tooltip">SALVAR</button>
     </div>  
	 
<?php
?>

<br>	 
<script>
    
	
function freq() {
	
const frequencyTable = document.querySelector('table')
const tableColumStyle = document.querySelector('#table-column')
const params = new URLSearchParams(location.search)
//Pegar resultado query dos nomes TEM SENTIDO AQUI CONTINUA
const nomes = "<?php echo  $row['nome']; ?>"
//$partes_nome = explode(" ", $row['nome']);

const inputName = document.querySelector('input')
const userId = params.get('id')
const eList = document.querySelector('.list')
const tdOptions = [{
  option: 'P', class: 'P',
}, {
  option: 'F', class: 'F',
}, {
  option: 'J', class: 'J',
}, {
  option: '', class: '',
}]

//
const calcTotalFrom = [         // presence total
  {child: 2, class: 'Presente'}, // aboned total
  {child: 3, class: 'Justificada'}, // ausent total
  {child: 4, class: 'Falta'}]


// THEAD
const headTexts = ['NOME','1E','2E','3E','4E','1E','2E','3E','4E','1E','2E','3E','4E','1E','2E','3E','4E','1E','2E','3E','4E','1E','2E','3E','4E','1E','2E','3E','4E','1E','2E','3E','4E','1E','2E','3E','4E','1E','2E','3E','4E', 'Total F', 'Total J', 'Total P']
// create a tr
const row = document.createElement('tr')
row.classList.add('encontro');

for (const index of headTexts) {
  // create a th
  const th = document.createElement('th')
  th.classList.add('encontro');
  th.innerText = index
  row.append(th)
}

//FAZENDO LER QUANTIDADE DE TRS EM QUANTIDADE DE NUMERO(precisa pular 2, >2)
var table = document.getElementById('listapres')
var nome = table.getElementsByClassName('nomes')

frequencyTable.querySelector('thead').append(row)


// TBODY
// MUDAR PARA nomes e mudar o cdigo
const fillTbody = (data = []) => {

	
	// PRECISA LER QUANTIDADE DE NOMES NO LUGAR DO 22
  for (let m = 0; m < nome.length; m++) {
    
	//Precisa que ele insira as trs apos duas trs (de meses  encontros para n inserir na frente)
	// create a tr
    const row = document.querySelector(".nomes") 


    for (const index in headTexts) {

      
      // insert first cell with month name
      if (index == 0) {
		
        cell.innerHTML = nomes.toUpperCase()

      } else if (nomes) {
        const setIndex = tdOptions[setIndex].option 
      
        if (setIndex > -1) {
          cell.dataset.option = setIndex
          cell.className = tdOptions[setIndex].class
          cell.innerText = tdOptions[setIndex].option
          
        }
      } else {
        cell.innerHTML = ''
      }

    }

    // insert complete tr into tbody
    frequencyTable.querySelector('tbody').append(row)
    calcTotals([row])
  }

// highlight
  for (const col of calcTotalFrom) {
    for (const cell of frequencyTable.querySelectorAll(`td:nth-last-child(${col.child})`)) {
      const tr = cell.parentNode
      cell.addEventListener('mouseover', () => {
        for (const check of tr.getElementsByClassName(col.class)) {
          check.classList.add('border')
        }
      })
      cell.addEventListener('mouseout', () => {
        for (const check of tr.getElementsByClassName(col.class)) {
          check.classList.remove('border')
        }
      })
    }
  }
}

// highlight columns
frequencyTable.addEventListener('mouseover', e => {
  const element = e.target
  if (element.matches('td, th')) {
    const index = ++element.cellIndex
    if (index > 1) {
      tableColumStyle.innerHTML = `
      table thead tr th:nth-child(${index}),
      table tbody tr td:nth-child(${index}){
        background-color: #fffce7;
      }
    `
    }
  }
})

// unhighlight columns
frequencyTable.addEventListener('mouseout', e => {
  tableColumStyle.innerHTML = ''
})

// when clicking on a cell
frequencyTable.addEventListener('click', e => {
  const element = e.target
  if (element.matches('td')) {
    const elementIndex = ++element.cellIndex
    if (elementIndex > 1 && elementIndex < 42) {
      const optionIndex = element.dataset.option || 0

      let setIndex = 0

      if (optionIndex && optionIndex < tdOptions.length - 1) {
        setIndex = +optionIndex + 1
      }

      element.dataset.option = setIndex
      element.className = tdOptions[setIndex].class
      element.innerText = tdOptions[setIndex].option

      calcTotals([element.parentNode])
    }

  }
})

const calcTotals = (trs) => {
  // calc totals
  trs = trs || frequencyTable.querySelectorAll('tr > td[class]:first-of-type')
  for (const tr of trs) {
    for (const object of calcTotalFrom) {
      tr.querySelector(`td:nth-last-child(${object.child})`).innerHTML = tr.getElementsByClassName(object.class).length
    }
  }
}

document.querySelector('button').addEventListener('click', async () => {
  const name = inputName.value
  if (!name) {
    inputName.className = 'is-invalid'
    return false
  }

  inputName.className = ''

  const frequencySchema = []
  const trs = frequencyTable.querySelectorAll('tbody tr')
  for (const tr of trs) {
    const cells = tr.querySelectorAll('td:nth-child(n+2):nth-child(-n+32)')
    const month = {month: tr.rowIndex, days: []}
    for (const c of cells) {
      month.days[c.cellIndex] = c.dataset.option || 3
    }
    frequencySchema.push(month)
  }

  const fData = new FormData()

  fData.append('name', name)
  fData.append('frequency', JSON.stringify(frequencySchema))

  const response = await saveStudent(fData)

  // se response estiver ok
  if (response.statusCode === 200) {
    window.location = './'
  } else {
    eList.classList.add('text-danger')
    eList.innerHTML = response.body
  }
})

/**
 * Funçõo para submeter requests a um servidor, esperendo json como resposta
 * @param url
 * @param data
 * @param method
 * @returns {Promise<any>}
 */
const fetchJson = async (url, data, method = 'POST') => {

  const headers = {
    method: method,
  }

  if (method === 'POST') {
    headers.body = data
  }

  // faz o request
  const request = await fetch(url, headers)

  try {

    // converte o resultado da request em json
    const body = await request.json()
    // retorna a resposta
    return {statusCode: request.status, body}
  } catch (e) {
    return {statusCode: 404, body: e}
  }
}

/**
 * Função pra buscar students
 * @param id
 * @returns {Promise<*>}
 */
const getStudents = async (id) => {
  const response = await fetchJson(`/sistema/lista_pres/index.php ${id ? `?id=${id}` : ''}`, '', 'GET')

  // se response estiver ok
  if (response.statusCode === 200 && response.body.data) {
    return response.body.data
  }
}

const fillList = (data) => {
  for (const s of data) {
    const a = document.createElement('a')
    a.href = `?id=${s.id}`
    a.className = 'p-12'
    a.innerText = s.student

    eList.append(a)
  }
}

/**
 * Função para salvar students
 * 
 * @param id
 * @returns {Promise<void>}
 */
const saveStudent = async (data, id) => {

  id = id || userId
  const response = await fetchJson(`api/save/${id ? `?id=${id}` : ''}`, data)

  return response
}

// assim q o html for carregado
document.addEventListener('DOMContentLoaded', async (e) => {
  // carrega a página inicial
  const students = await getStudents()
  if (students) {
    fillList(students)
  }

  if (userId && students) {
    inputName.parentNode.className = 'd-none'
    const [register] = students.filter(student => student.id == userId)

    if (register) {
      inputName.value = register.student
      fillTbody(JSON.parse(register.frequency))
    }
  } else {
    fillTbody()
  }
})


}

</script>

     <table id="listapres" name="listapres" class="listapres table table-hover table-bordered">

    <thead>
    <th class="">ESTUDANTE</th>
    <th class="mes" value="fev" colspan="4">FEV</th>
    <th class="mes" value="mar" colspan="4">MAR</th>
    <th class="mes" value="abr" colspan="4">ABR</th>
    <th class="mes" value="mai" colspan="4">MAI</th>
    <th class="mes" value="jun" colspan="4">JUN</th>
    <th class="mes" value="ago" colspan="4">AGO</th>
    <th class="mes" value="set" colspan="4">SET</th>
    <th class="mes" value="out" colspan="4">OUT</th>
    <th class="mes" value="nov" colspan="4">NOV</th>
    <th class="mes" value="dez" colspan="4">DEZ</th>
     <th colspan="4">FREQUÊNCIA</th>
    </thead>

    <tbody>
  
    <script> freq()</script>
	<link rel='stylesheet' href='/sistema/lista_pres/css/style.css'>

<?php

$cidade = htmlentities($_GET['cidade']);
$escola = $_GET['escola'];
$serie = $_GET['serie'];
$anoletivo = $_GET['anoletivo'];


if($cidade === 'todas')
	$cidade = '';

if($escola === 'todas')
	$escola = '';

if($serie === 'todas')
	$serie = '';

switch ($_GET['status']) {
	case 'ativo':
		$status = 1;
		$txt_status = "ativos";
	break;
	
	case 'inativo':
		$status = 0;
		$txt_status = "inativos";
	break;

	case 'todos':
		$status = 2;
		$txt_status = "";
	break;
	
	default:
		$status = 2;
		$text_status = "";
	break;
}


if($status == 1)
	$ativo = "h = 1 OR h = 4";				
elseif($status == 0)
	$ativo = "h = 0";		
elseif($status == 2)
	$ativo = "h = 0 OR h = 1 OR h = 4";

	//query que busca nome dos alunos
	$query = "SELECT usuario.id_usuario, usuario.nome, alunos.serie, escola.nome_escola, escola.cidade
	FROM alunos JOIN escola ON escola.id_escola = alunos.id_escola 
	JOIN usuario ON usuario.id_usuario = alunos.id_usuario 
	JOIN list_pres ON list_pres.id_usuario = usuario.id_usuario 
	WHERE alunos.serie <> '' ";
	if(!empty($escola))
		$query .= "AND escola.id_escola = '$escola' ";

	$query .= "AND escola.cidade LIKE '%$cidade%' 
	AND alunos.serie LIKE '%$serie%' 
	AND alunos.serie <> 'XX' 
	AND alunos.serie <> '0' 
	AND ($ativo) 
	AND alunos.id_escola IN (SELECT DISTINCT id_escola FROM escola) 
	GROUP BY usuario.nome 
	ORDER BY escola.cidade, escola.nome_escola, alunos.serie, usuario.nome";


$resultado = mysqli_query($_SG['link'], $query);

echo mysqli_error();


while($row = mysqli_fetch_assoc($resultado)):	
$partes_nome = explode(" ", $row['nome']);

?>
    <input type="hidden" name="user_ids[]" value="<?php echo $row['id_usuario']; ?>">
   
	<script>
  function atualizarInputs() {
    var trs = document.querySelectorAll('tr.nomes');
    for (var i = 0; i < trs.length; i++) {
      var nome = trs[i].querySelector('td:first-child').textContent.trim();
      var tds = trs[i].querySelectorAll('td[data-index]');
      var valores = [];
      for (var j = 0; j < tds.length; j++) {
        valores.push(tds[j].textContent.trim());
      }
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'valores_tr[]';
      input.value = nome + ',' + valores.join(',');
      trs[i].appendChild(input);
    }
  }
</script>




  <?php 

echo '<tr class="nomes">';

echo '<td class="text-uppercase">
'.$row['nome'].'
</td>';

echo '<td name="fev1e-td" data-index="1">
'.$row['FEV_1E'].'
</td>';

echo '<td name="fev2e-td" data-index="2">
'.$row['FEV_2E'].'
</td>';

echo '<td name="fev3e-td" data-index="3">
'.$row['FEV_3E'].'
</td>';

echo '<td name="fev4e-td" data-index="4">
'.$row['FEV_4E'].'
</td>';



echo '<td id="MAR1E" data-index="5">
'.$row['MAR_1E'].'
 </td>';

echo '<td id="MAR2E" data-index="6">
'.$row['MAR_2E'].'
</td>';

echo '<td id="MAR3E" data-index="7">
'.$row['MAR_3E'].'
</td>';

echo '<td id="MAR4E" data-index="8">
'.$row['MAR_4E'].'
</td>';



echo '<td id="ABR1E" data-index="9">
'.$row['ABR_1E'].'
</td>';

echo '<td id="ABR2E" data-index="10">
'.$row['ABR_2E'].'
</td>';

echo '<td id="ABR3E" data-index="11">
'.$row['ABR_3E'].'
</td>';

echo '<td id="ABR4E" data-index="12">
'.$row['ABR_4E'].'
</td>';



echo '<td id="MAI1E" data-index="13">
'.$row['MAI_1E'].'
</td>';

echo '<td id="MAI2E" data-index="14">
'.$row['MAI_2E'].'
</td>';

echo '<td id="MAI3E" data-index="15">
'.$row['MAI_3E'].'
</td>';

echo '<td id="MAI4E" data-index="16">
'.$row['MAI_4E'].'
</td>';



echo '<td id="JUN1E" data-index="17">
'.$row['JUN_1E'].'
</td>';

echo '<td id="JUN2E" data-index="18">
'.$row['JUN_2E'].'
</td>';

echo '<td id="JUN3E" data-index="19">
'.$row['JUN_3E'].'
</td>';

echo '<td id="JUN4E" data-index="20">
'.$row['JUN_4E'].'
</td>';



echo '<td id="AGO1E" data-index="21">
'.$row['AGO_1E'].'
</td>';

echo '<td id="AGO2E" data-index="22">
'.$row['AGO_2E'].'
</td>';

echo '<td id="AGO3E" data-index="23">
'.$row['AGO_3E'].'
</td>';

echo '<td id="AGO4E" data-index="24">
'.$row['AGO_4E'].'
</td>';



echo '<td id="SET1E" data-index="25">
'.$row['SET_1E'].'
</td>';

echo '<td id="SET2E" data-index="26">
'.$row['SET_2E'].'
</td>';

echo '<td id="SET3E" data-index="27">
'.$row['SET_3E'].'
</td>';

echo '<td id="SET4E" data-index="28">
'.$row['SET_4E'].'
</td>';



echo '<td id="OUT1E" data-index="29">
'.$row['OUT_1E'].'
</td>';

echo '<td id="OUT2E" data-index="30">
'.$row['OUT_2E'].'
</td>';

echo '<td id="OUT3E" data-index="31">
'.$row['OUT_3E'].'
</td>';

echo '<td id="OUT4E" data-index="32">
'.$row['OUT_4E'].'
</td>';



echo '<td id="NOV1E" data-index="33">
'.$row['NOV_1E'].'
</td>';

echo '<td id="NOV2E" data-index="34">
'.$row['NOV_2E'].'
</td>';

echo '<td id="NOV3E" data-index="35">
'.$row['NOV_3E'].'
</td>';

echo '<td id="NOV4E" data-index="36">
'.$row['NOV_4E'].'
</td>';



echo '<td id="DEZ1E" data-index="37">
'.$row['DEZ_1E'].'
</td>';

echo '<td id="DEZ2E" data-index="38">
'.$row['DEZ_2E'].'
</td>';

echo '<td id="DEZ3E" data-index="39">
'.$row['DEZ_3E'].'
</td>';

echo '<td id="DEZ4E" data-index="40">
'.$row['DEZ_4E'].'
</td>';



echo '<td id="F">';
echo '</td>';

echo '<td id="J">';
echo '</td>';

echo '<td id="P">';
echo '</td>';


echo '<td id="%">';
echo '</td>';


echo '</tr>';  




'</tbody>'; 
'</table>';


?>
</div>
	</div>	 






<?php endwhile; ?>
 

</form>

</body>




<?php
} 


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////PDF//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_GET['gerarpdf'])):

echo 

	$cidade = htmlentities($_GET['cidade']);
	$escola = $_GET['escola'];
	$serie = $_GET['serie'];
	$anoletivo = $_GET['anoletivo'];


	if($cidade === 'todas')
		$cidade = '';

	if($escola === 'todas')
		$escola = '';

	if($serie === 'todas')
		$serie = '';

	switch ($_GET['status']) {
		case 'ativo':
			$status = 1;
			$txt_status = "ativos";
		break;
		
		case 'inativo':
			$status = 0;
			$txt_status = "inativos";
		break;

		case 'todos':
			$status = 2;
			$txt_status = "";
		break;
		
		default:
			$status = 2;
			$text_status = "";
		break;
	}


	if($status == 1)
		$ativo = "h = 1 OR h = 4";				
	elseif($status == 0)
		$ativo = "h = 0";		
	elseif($status == 2)
		$ativo = "h = 0 OR h = 1 OR h = 4";

		//query que busca nome dos alunos
		$sql = "SELECT usuario.nome, alunos.serie, escola.nome_escola, escola.cidade
		FROM alunos JOIN escola ON escola.id_escola = alunos.id_escola 
		JOIN usuario ON usuario.id_usuario = alunos.id_usuario 
		WHERE alunos.serie <> '' ";
		if(!empty($escola))
			$sql .= "AND escola.id_escola = '$escola' ";

		$sql .= "AND escola.cidade LIKE '%$cidade%' 
		AND alunos.serie LIKE '%$serie%' 
		AND alunos.serie <> 'XX' 
		AND alunos.serie <> '0' 
		AND ($ativo) 
		AND alunos.id_escola IN (SELECT DISTINCT id_escola FROM escola) 
		GROUP BY usuario.nome 
		ORDER BY escola.cidade, escola.nome_escola, alunos.serie, usuario.nome";


	$result = mysqli_query($_SG['link'], $sql);

	echo mysqli_error();

	// echo $sql;

	//PDF AQUI ABAIXO

	echo '<div class="row"><div class="col-md-12" align="center"><br><br><button id="btn-print" onclick="imprimir()" class="btn btn-default"><i class="fa fa-print"></i> IMPRIMIR</button></div></div>';

	echo '<h1 class="text-center">Lista de Presença '.$txt_status.' do Programa Futuro Cientista <br><br></h1>';

	if($cidade !== '' AND $escola !== ''){
		$escola_sql = mysqli_query($_SG['link'], "SELECT nome_escola FROM escola WHERE id_escola = '$escola' LIMIT 1");
		$nome_escola = mysqli_fetch_array($escola_sql);

		echo '<h3 class="text-center">'.$cidade.'<br><small>'.$nome_escola['nome_escola'].'</small></h3>';
	}
	elseif($cidade !== '' AND $escola === ''){

		echo '<h3 class="text-center">'.$cidade.'<br><small>';
		
		$escola_sql = mysqli_query($_SG['link'], "SELECT DISTINCT nome_escola FROM escola WHERE cidade LIKE '%$cidade%' AND escola.id_escola IN (SELECT DISTINCT id_escola FROM usuario WHERE h > 0) ORDER BY cidade, nome_escola");
		$qtd_escola = mysqli_num_rows($escola_sql);

		$i = 0;
		while($nome_escola = mysqli_fetch_array($escola_sql)): 

			echo $nome_escola['nome_escola'];

			if($i != $qtd_escola-1)
				echo '&ensp;-&ensp;';

			$i++;
		endwhile;
		echo '</small></h3><br>';
	}

	switch ($serie) {
		case '5EF':
			$serie = "5º Ano Ensino Fundamental";
		break;

		case '6EF':
			$serie = "6º Ano Ensino Fundamental";
		break;

		case '7EF':
			$serie = "7º Ano Ensino Fundamental";
		break;

		case '8EF':
			$serie = "8º Ano Ensino Fundamental";
		break;

		case '9EF':
			$serie = "9º Ano Ensino Fundamental";
		break;

		case '1EM':
			$serie = "1º Ano Ensino Médio";
		break;
		
		case '2EM':
			$serie = "2º Ano Ensino Médio";
		break;
		
		case '3EM':
			$serie = "3º Ano Ensino Médio";
		break;
		
		default:
		$serie = "";
		break;
	}

	echo '<p class="text-center">'.$serie.'</p>';

	switch ($anoletivo) {
		case '2023a':
			$anoletivo = "2023";
		break;

		default:
		$anoletivo = "";
		break;
	}

	echo '<h2 class="text-center">'.$anoletivo.'</h2><br><small>';

	echo '<table class="table table-hover table-bordered">

		<thead>
			<th style="text-align:center" class="">ESTUDANTE</th>
			<th style="text-align:center" colspan="4">FEV</th>
			<th style="text-align:center" colspan="4">MAR</th>
			<th style="text-align:center" colspan="4">ABR</th>
			<th style="text-align:center" colspan="4">MAI</th>
			<th style="text-align:center" colspan="4">JUN</th>
			<th style="text-align:center" colspan="4">AGO</th>
			<th style="text-align:center" colspan="4">SET</th>
			<th style="text-align:center" colspan="4">OUT</th>
			<th style="text-align:center" colspan="4">NOV</th>
			<th style="text-align:center" colspan="4">DEZ</th>
			<th style="text-align:center">FREQUÊNCIA</th>
		</thead>

		<tbody>';

		echo '<th class="">NOME</th>';
		echo '<th>1E</th>';
		echo '<th>2E</th>';
		echo '<th>3E</th>';
		echo '<th>4E</th>';

		echo '<th>1E</th>';
		echo '<th>2E</th>';
		echo '<th>3E</th>';
		echo '<th>4E</th>';

		echo '<th>1E</th>';
		echo '<th>2E</th>';
		echo '<th>3E</th>';
		echo '<th>4E</th>';

		echo '<th>1E</th>';
		echo '<th>2E</th>';
		echo '<th>3E</th>';
		echo '<th>4E</th>';

		echo '<th>1E</th>';
		echo '<th>2E</th>';
		echo '<th>3E</th>';
		echo '<th>4E</th>';

		echo '<th>1E</th>';
		echo '<th>2E</th>';
		echo '<th>3E</th>';
		echo '<th>4E</th>';

		echo '<th>1E</th>';
		echo '<th>2E</th>';
		echo '<th>3E</th>';
		echo '<th>4E</th>';

		echo '<th>1E</th>';
		echo '<th>2E</th>';
		echo '<th>3E</th>';
		echo '<th>4E</th>';

		echo '<th>1E</th>';
		echo '<th>2E</th>';
		echo '<th>3E</th>';
		echo '<th>4E</th>';

		echo '<th>1E</th>';
		echo '<th>2E</th>';
		echo '<th>3E</th>';
		echo '<th>4E</th>';

		echo '<th style="text-align:center">%</th>';

	while($row = mysqli_fetch_assoc($result)):

		$partes_nome = explode(" ", $row['nome']);


	echo '<tr>';
	echo '<td class="text-uppercase">
		'.$row['nome'].'
	</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '</tr>';



	endwhile;
		echo 
		
		'</tbody>

	</table>'; 
	
	?>


<?php endif; endif; ?>

<script>
    

	function imprimir(){
		$('#btn-print').hide();
		window.print();
		setTimeout(function(){
			$('#btn-print').show();
		}, 1000);
	}
</script>

