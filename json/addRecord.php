<?php
session_start(); 
$loja = $_SESSION['sessao_loja_id'];
$fp = fopen("bloco1.txt", "a");
$escreve = fwrite($fp, "exemplo de escrita11111\n");
$escreve = fwrite($fp, $_POST['produto']);
$escreve = fwrite($fp, $_POST['descricao']);
$escreve = fwrite($fp, $_POST['valor']);


if(isset($_POST['produto'])) {}
else{
    echo "falta  produto";
    return;
};

if(isset($_POST['descricao'])){}
else{
    echo "falta descrição";
    return;
};

if(isset($_POST['valor'])){}
else{
    echo "falta  valor";
    return;
};


if(isset($_POST['quantidade'])){}
else{
    echo "falta quantidade";
    return;
};

if(isset($_POST['peso'])){}
else{
    echo "falta peso";
    return;
};

if(isset($_POST['categoria'])){}
else{
    echo "falta categoria";
    return;
};
	
	$escreve = fwrite($fp, "porrraddddddemplo de escrita\n");
		// get values 
	

include("token1.php");



//echo $token;

$form_nome = $_POST['produto'];;
$form_valor = $_POST['valor'];
$form_descricao = $_POST['descricao'];
$form_peso = $_POST['peso'];
$form_categoria = $_POST['categoria'];
$form_quantidate = $_POST['quantidade'];
$nome = str_replace(" " , "", $form_nome);


$productData = array(
    'sku'               => $nome  . uniqid(),
    'name'              => $form_nome,
 //   'visibility'        => 4, /*'catalog',*/ 
     'visibility'        => 1, /*not visible',*/
    'type_id'           => 'simple',
    'price'             => $form_valor,
    'status'            => 1,
    'attribute_set_id'  => 4,
    'weight'            => $form_peso,
    'extensionAttributes' =>  array('stock_item'=> array('isInStock'=> 1,'qty'  => $form_quantidate )),
    'custom_attributes' => array(
        array( 'attribute_code' => 'category_ids', 'value' => $form_categoria ),
        array( 'attribute_code' => 'description', 'value' => $form_descricao ),
        array( 'attribute_code' => 'short_description', 'value' => 'Simple  Short Description' ),
        )
);

$productData = json_encode(array('product' => $productData));

switch (json_last_error()) {
            default:
                break;
            case JSON_ERROR_DEPTH:
                echo 'Maximum stack depth exceeded';
            break;
            case JSON_ERROR_STATE_MISMATCH:
                echo 'Underflow or the modes mismatch';
            break;
            case JSON_ERROR_CTRL_CHAR:
                echo 'Unexpected control character found';
            break;
            case JSON_ERROR_SYNTAX:
                echo 'Syntax error, malformed JSON';
            break;
            case JSON_ERROR_UTF8:
                echo 'Malformed UTF-8 characters, possibly incorrectly encoded';
            break;
        };


$requestURL = "http://127.0.0.1/magento/index.php/rest/default/V1/products";
$requestURL = "http://ec2-54-209-29-39.compute-1.amazonaws.com/index.php/rest/V1/products";

$acao = "POST";

$ch = curl_init();      
curl_setopt($ch,CURLOPT_URL, $requestURL);

curl_setopt($ch,CURLOPT_POSTFIELDS, $productData);

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_HTTPHEADER, $setHaders);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
$escreve = fwrite($fp, $result);
$info = curl_getinfo($ch);

if ($info['http_code'] == 200) {
        echo "Produto adicionado \n";
    //   var_dump($result);
}
else    {
    $result=  json_decode($result, true);
    echo "Erro na inserção \n";
    exit(var_dump($result));
            
};

curl_close($ch);
fclose($fp);
/*
 status 	Product status. Can have the following values: 1- Enabled, 2 - Disabled. 	required
	int 	1
visibility 	Product visibility. Can have the following values: 1 - Not Visible Individually, 2 - Catalog, 3 - Search, 4 - Catalog, Search. 	required
	int 	4 

*/
?>