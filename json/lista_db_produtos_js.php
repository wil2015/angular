<?php
// lista todos os produtos a venda com exceção dos da mesma categoria da loja 
// deve vender os que estão visiveis


// echo "entrada = " . $var;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include('db_connection.php');

include('funcoes.php');


	
				if ($bdServidor = "localhost") {
					$url = "localhost/magento";
				}else {
					$url=$bdServidor;
				};

				$url = "ec2-54-209-29-39.compute-1.amazonaws.com/catalog/product/view/id";
		
				
			
				$parte1 = "<input type=button onclick=\"location.href='"; 
				$parte2 = "'\"value='Comprar'"; 
				$parte_visao = ".html?___store=";
				$parte_visao = "?___store=";
				$parte3 = ".html'\"value='Negociar'";

//				echo " loja é = " . $loja;
				$resultado2 = ler_loja($conexao, " " , 4, 4);
			  
          //      var_dump (json_encode($resultado2, JSON_PRETTY_PRINT));

           //     var_dump (json_encode($resultado2));

//echo (json_encode($productData, JSON_PRETTY_PRINT)); 


//echo '<br>';
//echo (json_encode($tt, JSON_PRETTY_PRINT)); 

#
			 
		//		 echo json_encode(array('data' => $resultado2), JSON_PRETTY_PRINT);
		//		 	 echo json_encode($resultado2);
                
                			
		

        //        $fp = fopen("angularjs.txt", "a");
        //         $escreve = fwrite($fp, "linha11111\n");
        //        $escreve = fwrite($fp, var_export($resultado2));
       //         return json_encode($resultado2);
	//	echo "<pre>";			
	//	var_dump($resultado2);
	//	echo "</pre>";

				$outp = "";
				$quantidade = count($resultado2["produto"]) - 1;
				for ($x = 0; $x <= $quantidade; $x++) {
					
							$resultado["id"]			= $resultado2["id"][$x] ; 
							$resultado["produto"] 		= $resultado2["produto"][$x] ;
							$resultado["html"]			= $resultado2["html"][$x] ;
							$resultado["descricao"] 	= $resultado2["descricao"][$x] ;
							$resultado["peso"] 			= $resultado2["peso"][$x] ;
							$resultado["valor"]			= $resultado2["valor"][$x] ;
							$resultado["quantidade"] 	= $resultado2["quantidade"][$x] ;
							$resultado["loja"] 			= $resultado2["loja"][$x] ;
							$resultado["nome_da_loja"]  = $resultado2["nome_da_loja"][$x] ;
							$resultado["estado"] 		= $resultado2["estado"][$x];
							$resultado["cidade"] 		= $resultado2["cidade"][$x];
							$resultado["visao"] 		= $resultado2["visao"][$x];	

							$lista = array(
  			  					
									"id"			=> $resultado2["id"][$x], 
									"produto" 		=> $resultado2["produto"][$x],
									"html"			=> $resultado2["html"][$x],
									"descricao" 	=> $resultado2["descricao"][$x],
									"peso" 			=> $resultado2["peso"][$x],
									"valor"			=> $resultado2["valor"][$x],
									"quantidade" 	=> $resultado2["quantidade"][$x],
									"loja" 			=> $resultado2["loja"][$x],
									"nome_da_loja"  => $resultado2["nome_da_loja"][$x],
									"estado" 		=> $resultado2["estado"][$x],
									"cidade" 		=> $resultado2["cidade"][$x],
									"visao" 		=> $resultado2["visao"][$x]	
    
								);
                     $tt[] = $lista;
							 if ($outp != "") {$outp .= ",";}
   					$outp .= '{"id":"'  . $resultado["id"] . '",';
   					$outp .= '"produto":"'   . $resultado["produto"]      . '",';
   					$outp .= '"descricao":"'. $resultado["descricao"]     . '"}'; 
									
				};
	



				//echo $return.="</tbody></table>";
          //  echo json_encode($resultado2);
		  $outp ='{"records":['.$outp.']}';
		  echo json_encode(array('produtos' => $tt));
	//	  echo json_encode($tt);
       //  	echo "<pre>";			
//		echo(json_encode($tt));
	//	echo($resultado2);
	//	 echo "</pre>";
				mysqli_close($conexao);

