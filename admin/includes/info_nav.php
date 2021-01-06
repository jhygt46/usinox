<?php
    	
		$array[0]["nombre"] = "Categorias";
        $array[0]["link"] = "pages/_usinox_categorias.php?id_pag=1";
    
    	if(isset($array)){
        
        	$aux["ico"] = 4;
        	$aux["categoria"] = "Catalogo Usinox";
        	$aux["subcategoria"] = $array;
        	$menu[] = $aux;
        	unset($aux);
        	unset($array);
        
		}
		$array[0]["nombre"] = "Categorias";
        $array[0]["link"] = "pages/_usinox_categorias.php?id_pag=2";
    
    	if(isset($array)){
        
        	$aux["ico"] = 4;
        	$aux["categoria"] = "Catalogo Neptuno";
        	$aux["subcategoria"] = $array;
        	$menu[] = $aux;
        	unset($aux);
        	unset($array);
        
    	}
		
		/*
    	$array[0]["nombre"] = "Ingresar Usuarios";
    	$array[0]["link"] = "pages/crear_usuario.php";
        $array[1]["nombre"] = "Prestamos";
        $array[1]["link"] = "pages/_jardinva_prestamos.php";
		$array[2]["nombre"] = "Codigos QR";
        $array[2]["link"] = "pages/_jardinva_codigoqr.php";
    
    	if(isset($array)){
    
        	$aux["ico"] = 2;
        	$aux["categoria"] = "Biblioteca";
        	$aux["subcategoria"] = $array;
        	$menu[] = $aux;
        	unset($aux);
        	unset($array);
    	}

		$array[0]["nombre"] = "Ingresar Campa&ntilde;a";
    	$array[0]["link"] = "pages/_jardinva_crear_campana.php";
    
    	if(isset($array)){
    
        	$aux["ico"] = 3;
        	$aux["categoria"] = "Emailing";
        	$aux["subcategoria"] = $array;
        	$menu[] = $aux;
        	unset($aux);
        	unset($array);
        
		}
		
		*/

?>