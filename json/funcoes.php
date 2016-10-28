<?php

function ler_query($select, $consulta,  $link, $at){

         $stmt = mysqli_stmt_init($link);
         
         mysqli_stmt_prepare($stmt, $select);
       

        If ($at != 0){
  //              echo 'com = ' . $at . " at =  " . $consulta . "</br>" ;
                mysqli_stmt_bind_param($stmt, "ii", $at, $consulta);
                }
         else{
                 mysqli_stmt_bind_param($stmt, "i", $consulta);        
         };
         
         
         mysqli_stmt_execute($stmt);
      
         $linha = mysqli_stmt_get_result($stmt);
   //       printf("rows lidas %d\n", mysqli_stmt_affected_rows($stmt));
   
        $resultado = mysqli_fetch_assoc($linha);

    //    printf("Error: %s.\n", mysqli_stmt_sqlstate($stmt));
    //    var_dump($resultado);
        mysqli_stmt_close($stmt);
        return $resultado;

};

function  ler_loja ($link, $loja, $de, $ate){





// producao 
$at_nome = 73 ;
$at_html = 119 ;
$at_descricao = 75; 
$at_peso = 82 ; 
$at_valor = 77;
$at_vivibilidade = 99;


//desenvolvimento 
$at_nome = 70 ;
$at_html = 119 ;
$at_descricao = 72; 
$at_peso = 79 ; 
$at_valor = 74;
$at_vivibilidade = 96;


/*
  $fp = fopen("bloco221.txt", "a");
  $escreve = fwrite($fp, "linha11111\n");
  $escreve = fwrite($fp, $loja);
*/

if ($loja == " "){
        $query_status = "SELECT produto.entity_id as produto,   group_id  as loja , max(store_id)
                        FROM catalog_product_entity_int	produto, 
                                visao_categoria, store_group
                        where produto.entity_id = chave_produto and produto.attribute_id = ? and produto.value in (?, ?) and  
                        root_category_id = categoria_pai
                        group by  produto, loja ";
}else{
        $query_status = "SELECT produto.entity_id as produto,   group_id  as loja , max(store_id)
                        FROM catalog_product_entity_int	produto, 
                                visao_categoria, store_group
                        where produto.entity_id = chave_produto and produto.attribute_id = ? and produto.value in (?, ?) and  
                        root_category_id = categoria_pai and group_id = ?
                        group by  produto, loja ";

};


          

            $query_loja = "select * from visao_loja where id_loja = ?"; 

            $query_produto = "SELECT nome_produto.value	as produto,  max(store_id) as loja" . 
                            " FROM catalog_product_entity_varchar	nome_produto " .

                                   "  where  nome_produto.attribute_id 	= ? and nome_produto.entity_id = ? group by produto " ;


            $query_html = "SELECT html.value as html, max(store_id) as loja " . 
                            "FROM catalog_product_entity_varchar html " .
                                
                               " WHERE  html.attribute_id = ? and  html.entity_id  = ? group by html" ;

            $query_descricao = "SELECT entity_id , texto.value	as descricao, store_id as loja" .
                            " FROM catalog_product_entity_text 	texto " .
                            
                                 " WHERE   attribute_id = ? and entity_id = ? order by store_id desc limit 1" ;

            $query_peso = "SELECT peso.value as peso, max(store_id) as loja " . 
                            "FROM catalog_product_entity_decimal peso " .
                                
                            " WHERE peso.attribute_id = ? and peso.entity_id =  ?  group by peso " ;
            

            $query_valor = "SELECT valor.value as valor, max(store_id) as loja " . 
                            "FROM catalog_product_entity_decimal valor ".
                       
                                
                             " WHERE  valor.attribute_id = ? and valor.entity_id = ? group by valor " ; 


            $query_quantidade = "SELECT qty " . 
                            "FROM cataloginventory_stock_item " .
                                
                            " WHERE product_id = ?"  ;


            $query_estado = " select estado, cidade, tipo_de_loja  from detalhe_loja  where loja_id =  ? ";

                      

            $stmt = mysqli_stmt_init($link);
     
            mysqli_stmt_prepare($stmt, $query_status);
          
             
            if ($loja == " "){
                 mysqli_stmt_bind_param($stmt, "iii", $at_vivibilidade, $de, $ate );
            }
            else {
                 mysqli_stmt_bind_param($stmt, "iiii", $at_vivibilidade, $de, $ate, $loja );
            };

            mysqli_stmt_execute($stmt);
            
            $queryx = mysqli_stmt_get_result($stmt);
     //        printf("rows lidas %d\n", mysqli_stmt_affected_rows($stmt));
     //      echo 'passou';

              
            $i = 0;
            while($status = mysqli_fetch_assoc($queryx)){

      
                    $produto = $status["produto"];
                    $loja = $status["loja"];
                     
                                 

                    $resultado["id"][$i] =              $status["produto"];
                    $resultado["produto"][$i] =         ler_query($query_produto, $produto,  $link, $at_nome)["produto"];
                    $resultado["html"][$i] =            ler_query($query_html, $produto, $link, $at_html)["html"];
                    $resultado["descricao"][$i] =       ler_query($query_descricao,  $produto, $link, $at_descricao)["descricao"];
                    $resultado["peso"][$i] =            ler_query($query_peso, $produto, $link, $at_peso)["peso"];
                    $resultado["valor"][$i] =           ler_query($query_valor, $produto,  $link, $at_valor)["valor"];
                    $resultado["quantidade"][$i] =      ler_query($query_quantidade, $produto, $link, 0)["qty"];
                    $resultado["loja"][$i] =            ler_query($query_loja, $loja,  $link, 0)["id_loja"];
                    $resultado["nome_da_loja"][$i] =    ler_query($query_loja, $loja,  $link, 0)["nome_da_loja"];
                    $resultado["visao"][$i] =           ler_query($query_loja, $loja, $link, 0)["visao"];
                    $resultado["estado"][$i] =          ler_query($query_estado, $loja,  $link, 0)["estado"];
                    $resultado["cidade"][$i] =          ler_query($query_estado, $loja,  $link, 0)["cidade"];
                    $resultado["tipo_de_loja"][$i] =    ler_query($query_estado, $loja,  $link, 0)["tipo_de_loja"];


                    $i++; 
           
                    
            };
  //           $escreve = fwrite($fp, var_export($resultado));
            if ($i == 0){ return;};    
            return $resultado;
};

function  ler_item ($link, $produto){

            $query_status = "SELECT produto.entity_id as produto,  max(store_id) as loja
                FROM catalog_product_entity_int	produto, 
                        visao_categoria
                where produto.entity_id = chave_produto and produto.attribute_id 	= 94 and chave_produto  = " . $produto . " LIMIT 1"; 

            $query_produto = "SELECT nome_produto.value	as produto,  max(store_id) as loja" . 
                            " FROM catalog_product_entity_varchar	nome_produto " .
                            
                            "  where  nome_produto.attribute_id 	= 70 and nome_produto.entity_id = " ;

            $query_html = "SELECT html.value as html, max(store_id) as loja " . 
                            "FROM catalog_product_entity_varchar html " .
                                
                            " WHERE  html.attribute_id = 115 and  html.entity_id  = " ;

            $query_descricao = "SELECT texto.value	as descricao, max(store_id) as loja" .
                            " FROM catalog_product_entity_text 	texto " .
                            
                            " WHERE   attribute_id = 72 and entity_id = " ;

            $query_peso = "SELECT peso.value as peso, max(store_id) as loja " . 
                            "FROM catalog_product_entity_decimal peso " .
                                
                            " WHERE peso.attribute_id = 79 and peso.entity_id =  " ;


            $query_valor = "SELECT valor.value as valor, max(store_id) as loja " . 
                            "FROM catalog_product_entity_decimal valor ".
                        
                            " WHERE  valor.attribute_id = 79 and valor.entity_id = " ;

            $query_quantidade = "SELECT qty " . 
                            "FROM cataloginventory_stock_item " .
                                
                            " WHERE product_id = "  ;

            $query_group = " group by  chave_produto;";
            // $query = $query_produto . $query_html . $query_descrico;



          

            $queryx = mysqli_query($link, $query_status);
            if (!$queryx) {
                echo 'Não foi possível executar a consulta do status: ' . mysqli_error($link);
                exit;
            };

            $i = 0;
            while($status = mysqli_fetch_assoc($queryx)){

                    $produto = $status["produto"];
                    $select1 = $query_produto . $produto ;
                    $select2 = $query_html . $produto ;
                    $select3 = $query_descricao . $produto ." group by entity_id " ;
                    $select4 = $query_peso . $produto ;
                    $select5 = $query_valor . $produto ;
                    $select5 = $query_valor . $produto;
                    $select6 = $query_quantidade . $produto;
                
                

                    $resultado["id"][$i] = $status["produto"];
                    $resultado["produto"][$i] = ler_query($query_produto, $produto,  $link)["produto"];
                    $resultado["html"][$i] = ler_query($query_html, $produto, $link)["html"];
                    $resultado["descricao"][$i] = ler_query($query_descricao, $produto, $link)["descricao"];
                    $resultado["peso"][$i] = ler_query($query_peso, $produto,  $link)["peso"];
                    $resultado["valor"][$i] = ler_query($query_valor, $produto,  $link)["valor"];
                    $resultado["quantidade"][$i] = ler_query($query_quantidade, $produto,  $link)["qty"];
                    $resultado["loja"][$i] =  ler_query($select5, $link)["loja"];


                    $i++; 
                    /*
                    echo '<pre>';
                    var_export($resultado);
                    echo '</pre>';
            */
                    
            };
            return $resultado;
};


?>
