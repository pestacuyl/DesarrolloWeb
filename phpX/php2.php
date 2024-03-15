<?php

//echo [p_factura_venta_Id];
//echo [NO_FAC];
//INSERT INTO dbo.Fel_response
//    (UUID, No_Serie, No_Doc, factura_venta_Id, Fel_Serie, Fel_Documento, Fel_Response, Fel_Message, CreatedAt, Empresa_Id, Fel_Fecha, Tipo_doc)
//VALUES
//    ('EjemploUUID', 'EjemploNoSerie', 'EjemploNoDoc', 1, 'EjemploFelSerie', 'EjemploFelDocumento', 'EjemploFelResponse', 'EjemploFelMessage', GETDATE(), 1, 'EjemploFelFecha', 'EjemploTipoDoc');

// Esto debería ir en el evento `onScriptInit` o `onLoad` de la aplicación de destino
//$p_factura_venta_Id = sc_apl_conf('form_dbo_Persona_Factura_Venta_Cita', [p_factura_venta_Id]);
//$p_factura_venta_Id = [p_factura_venta_Id];
// Puedes imprimir o utilizar el valor según tus necesidades
//echo "Valor de p_factura_venta_Id: " . $p_factura_venta_Id ." o ".{factura_venta_id}." o ";

// Verificar si $p_factura_venta_Id está vacío y asignar un valor por defecto si es necesario
//if (empty($p_factura_venta_Id)) {
    //$p_factura_venta_Id = {factura_venta_id}; // Reemplaza 'ValorPorDefecto' con el valor que desees
//}

// Imprimir el valor
//echo "<br><hr><br> factura numero: " . [p_factura_venta_Id] . "<br><hr>";
// Definir la consulta SQL para obtener los detalles de la factura
$sqlDetalle = "SELECT 
            factura_venta_detalle_id, 
            factura_venta_id, 
            plan_id, 
            plan_dsc, 
            producto_id, 
            producto_dsc, 
            cantidad, 
            precio, 
            descuento, 
            costo, 
            total, 
            convenio_detalle_id, 
            Convenio, 
            observaciones, 
            producto_dsc_fel, 
            tipo_producto_fel 
    FROM dbo.Vw_Factura_Venta_Detalle  
    WHERE factura_venta_id = '[p_factura_venta_Id]'";

// Ejecutar la consulta SQL y obtener los resultados
sc_lookup(detalles_factura, $sqlDetalle);

// Verificar si la consulta se ejecutó correctamente
if ({detalles_factura} !== false && !empty({detalles_factura})) {
    // Inicializar las variables para almacenar los elementos XML de Items y Totales
    $items_xml = '';
    $total_impuestos_xml = '';
    $linea=0;
    $TotalMontoImpuesto=0;
    $GranTotal=0;
    
    // Recorrer los detalles de la factura y construir los elementos XML correspondientes
        foreach ({detalles_factura} as $detalle) {
        $sumaPrecios=0;
        $montoGrabable=0;
        $montoImpuesto=0;
        $linea = $linea + 1;
        $items_xml .= '<dte:Item NumeroLinea="' . ($linea) . '" BienOServicio="' . ($detalle[15]) . '">';
        $items_xml .= '<dte:Cantidad>' . ($detalle[6]) . '</dte:Cantidad>';
        $items_xml .= '<dte:UnidadMedida>UNO</dte:UnidadMedida>'; 
        $items_xml .= '<dte:Descripcion>' . $detalle[14] . '</dte:Descripcion>';
        $items_xml .= '<dte:PrecioUnitario>' . $detalle[7] . '</dte:PrecioUnitario>';
        $sumaPrecios=($detalle[6]*$detalle[7]);
        $items_xml .= '<dte:Precio>' . ($sumaPrecios) . '</dte:Precio>';
        $items_xml .= '<dte:Descuento>' . ($detalle[8]) . '</dte:Descuento>';
        $items_xml .= '<dte:Impuestos>';
        $items_xml .= '<dte:Impuesto>';
        $items_xml .= '<dte:NombreCorto>IVA</dte:NombreCorto>';
        $items_xml .= '<dte:CodigoUnidadGravable>1</dte:CodigoUnidadGravable>';
        $montoGrabable=($sumaPrecios / 1.12);
        $items_xml .= '<dte:MontoGravable>' . number_format($montoGrabable, 2, '.', '') . '</dte:MontoGravable>';
        $montoImpuesto=($montoGrabable * 0.12);
        $items_xml .= '<dte:MontoImpuesto>' . number_format($montoImpuesto, 2, '.', '') . '</dte:MontoImpuesto>';
        $items_xml .= '</dte:Impuesto>';
        $items_xml .= '</dte:Impuestos>';
        $items_xml .= '<dte:Total>' . number_format(($montoGrabable + $montoImpuesto), 2, '.', '') . '</dte:Total>';
        $items_xml .= '</dte:Item>';
        $TotalMontoImpuesto=$TotalMontoImpuesto+$montoImpuesto;
        $GranTotal=$GranTotal+$sumaPrecios;
    }

    // Aquí se construiría el XML para la sección de Impuestos, basándose en la lógica de tu aplicación

    // Construir la sección Totales (solo es un ejemplo, ajusta según tus necesidades)
    $total_impuestos_xml .= '<dte:Totales>';
    $total_impuestos_xml .= '<dte:TotalImpuestos>';
    $total_impuestos_xml .= '<dte:TotalImpuesto NombreCorto="IVA" TotalMontoImpuesto="'.number_format($TotalMontoImpuesto, 2, '.', '').'"/>';
    $total_impuestos_xml .= '</dte:TotalImpuestos>';
    $total_impuestos_xml .= '<dte:GranTotal>' . number_format($GranTotal, 2, '.', '') . '</dte:GranTotal>';
    $total_impuestos_xml .= '</dte:Totales>';
}

// Definir la consulta SQL
$sql = "SELECT 
            factura_venta_id,
            fecha,
            persona_id,
            persona_nombre,
            persona_identificacion_no,
            persona_tipo_identificacion_id,
            observaciones,
            termino_id,
            termino,
            serie_interna,
            numero_interno,
            total,
            abonos,
            saldo,
            estado_id,
            estado,
            sucursal_id,
            sucursal,
            correlativo_transaccion_id,
            Tipo_Identificacion,
            fecha_cobro,
            correlativo_transaccion_rec_id,
            serie_interna_rec,
            numero_interno_rec,
            no_rec,
            no_fac,
            fecha_creacion,
            login_creacion,
            fecha_ultima_mod,
            login_ultima_mod,
            codigo_sucursal,
            correo_emisor,
            codigo_establecimiento_emisor,
            nit_emisor,
            nombre_comercial_emisor,
            afiliacion_iva_emisor,
            nombre_emisor,
            direccion_emisor,
            codigo_postal_emisor,
            municipio_emisor,
            departamento_emisor,
            pais_emisor,
            direccion_receptor,
            codigo_postal_receptor,
            departamento_receptor,
            municipio_receptor,
            pais_receptor,
            Fel_Documento,
            Fel_Serie,
            Fel_UUID,
			Fel_Monto_Grabable,
		    Fel_Monto_Impuesto,
		    Fel_Tipo,
		    Fel_CodigoMoneda,
		    Fel_TipoFrase,
		    Fel_CodigoEscenario
        FROM
            dbo.Vw_Factura_Venta 
        WHERE 
            factura_venta_id = '[p_factura_venta_Id]'";
//echo $sql;
// Ejecutar la consulta
sc_lookup(dataset, $sql);


// Verificar si la consulta se ejecutó correctamente
if (isset({dataset}) && !empty({dataset})) {
    // Guardar el resultado de la consulta en una variable
    $resultadoConsulta = {dataset};

    // Imprimir el resultado para verificar
    //echo "<pre>";
    //print_r($resultadoConsulta);
    //echo "</pre>";
	
	// Encabezado emisor
	$nitEmisor = strtoupper($resultadoConsulta[0][33]);  // NITEmisor*
	$nombreEmisor = strtoupper($resultadoConsulta[0][36]);  // NombreEmisor*
	$codigoEstablecimientoEmisor = strtoupper($resultadoConsulta[0][32]);  // CodigoEstablecimiento*
	$nombreComercialEmisor = strtoupper($resultadoConsulta[0][34]);  // NombreComercial*
	$afiliacionIvaEmisor = strtoupper($resultadoConsulta[0][35]);  // AfiliacionIVA*
	$direccionEmisor = strtoupper(strip_tags($resultadoConsulta[0][37]));  // Direccion*
	$codigoPostalEmisor = strtoupper(strip_tags($resultadoConsulta[0][38]));  // CodigoPostal*
	$municipioEmisor = strtoupper(strip_tags($resultadoConsulta[0][39]));  // Municipio*
	$departamentoEmisor = strtoupper(strip_tags($resultadoConsulta[0][40]));  // Departamento*
	$paisEmisor = strtoupper(strip_tags($resultadoConsulta[0][41]));  // Pais
	
	
	$FelCodigoMoneda = strtoupper(strip_tags($resultadoConsulta[0][52]));  // Municipio*
	$FelTipoFrase = strtoupper(strip_tags($resultadoConsulta[0][53]));  // Departamento*
	$FelCodigoEscenario = strtoupper(strip_tags($resultadoConsulta[0][54]));  // Pais
	
	
	$InsertSerie_interna = (string)$resultadoConsulta[0][9];
    $InsertNumero_interno = (string)$resultadoConsulta[0][10];
	
	// Obtener el valor de 'no_fac' de la primera fila del resultado
    $noFac = (string)$resultadoConsulta[0][25]; // Asumiendo que 'no_fac' es la columna número 26 (basada en 0-indexing)
    $NombreReceptor = (string)$resultadoConsulta[0][3]; // 
    $nitReceptor = (string)$resultadoConsulta[0][4]; // 
	//echo $nitReceptor .'<br><hr>';
    // Fecha y hora en el formato deseado
    $fecha_hora = $resultadoConsulta[0][26]; // 
    // Imprimir el valor de 'noFac'
    //echo "El valor de 'noFac' es: " . $noFac;
	$IDReceptor = !empty($nitReceptor) ? $nitReceptor : 'CF'; // Puedes proporcionar un valor por defecto si $nitReceptor está vacío
	
	// Eliminar guiones y verificar si es "cf" o "CF"
	if (strtoupper($IDReceptor) === 'CF') {
		$IDReceptor = strtoupper($IDReceptor);
	} elseif (ctype_digit($IDReceptor)) {
		// Si es numérico, no se hace ningún cambio
	} else {
		// Eliminar caracteres no numéricos a excepción de "CF"
		$IDReceptor = preg_replace('/[^a-zA-Z0-9]/', '', $IDReceptor);
	}
	
	//echo "idre ".$IDReceptor;
	//echo "nitre ".$nitReceptor;
} else {
    echo "No se encontraron registros.";
}





// Evitar la salida de los avisos y notificaciones de PHP
error_reporting(E_ERROR | E_PARSE);

// Imprimir la fecha y hora en el formato especificado
$FechaHoraEmision = date('Y-m-d\TH:i:s', strtotime($fecha_hora));

$url_ws = 'https://pruebasfel.g4sdocumenta.com/webservicefront/factwsfront.asmx?wsdl';
$Requestor = '8A454E3F-CEA1-41D8-A13A-A748A4891BBF';
$Entity = '800000001026';
$UserName = 'ADMINISTRADOR';
$Data1 = 'POST_DOCUMENT_SAT';
$Data3 = $noFac;

$dataxml = '<?xml version="1.0" encoding="utf-8"?>
<dte:GTDocumento 
    xmlns:ds="http://www.w3.org/2000/09/xmldsig#"
    xmlns:cfc="http://www.sat.gob.gt/dte/fel/CompCambiaria/0.1.0"
    xmlns:cno="http://www.sat.gob.gt/face2/ComplementoReferenciaNota/0.1.0"
    xmlns:cex="http://www.sat.gob.gt/face2/ComplementoExportaciones/0.1.0"
    xmlns:cfe="http://www.sat.gob.gt/face2/ComplementoFacturaEspecial/0.1.0"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" Version="0.1"
    xmlns:dte="http://www.sat.gob.gt/dte/fel/0.2.0">
    <dte:SAT ClaseDocumento="dte">
        <dte:DTE ID="DatosCertificados">
            <dte:DatosEmision ID="DatosEmision">
                <dte:DatosGenerales Tipo="FACT" FechaHoraEmision="'.$FechaHoraEmision.'" CodigoMoneda="'.$FelCodigoMoneda.'"/>
                <dte:Emisor NITEmisor="'.$nitEmisor.'" NombreEmisor="'.$nombreEmisor .'"
                    CodigoEstablecimiento="'.$codigoEstablecimientoEmisor.'" NombreComercial="'.$nombreComercialEmisor.'" AfiliacionIVA="'.$afiliacionIvaEmisor.'">
                    <dte:DireccionEmisor>
                        <dte:Direccion>'.$direccionEmisor.'</dte:Direccion>
                        <dte:CodigoPostal>'.$codigoPostalEmisor.'</dte:CodigoPostal>
                        <dte:Municipio>'.$municipioEmisor.'</dte:Municipio>
                        <dte:Departamento>'.$departamentoEmisor.'</dte:Departamento>
                        <dte:Pais>'.$paisEmisor.'</dte:Pais>
                    </dte:DireccionEmisor>
                </dte:Emisor>
                <dte:Receptor IDReceptor="' . $IDReceptor . '" NombreReceptor="' . $NombreReceptor . '"/>
                <dte:Frases>
                    <dte:Frase TipoFrase="'.$FelTipoFrase.'" CodigoEscenario="'.$FelCodigoEscenario.'"/>
                </dte:Frases>
                <dte:Items>' . $items_xml . '</dte:Items>
                    ' . $total_impuestos_xml . '                   
            </dte:DatosEmision>            
        </dte:DTE>
    </dte:SAT>    
</dte:GTDocumento>';
$xml = base64_encode($dataxml);
//print_r (htmlentities($dataxml));

$client = new SoapClient($url_ws);

try {
    $parameters = array(
        'Requestor'     => $Requestor,
        'Transaction'   => 'SYSTEM_REQUEST',
        'Country'       => 'GT',
        'Entity'        => $Entity,
        'User'          => $Requestor,
        'UserName'      => $UserName,
        'Data1'         => $Data1,
        'Data2'         => $xml,
        'Data3'         => $Data3
    );

    $response = $client->__soapCall('RequestTransaction', array($parameters));
    // print_r($response);echo "<br><br><br>";
    // Verificar si la respuesta es un objeto
    if (is_object($response)) {
        $responseArray = json_decode(json_encode($response), true);
        //echo "<br><br><br>";
        //print_r($responseArray);
        //echo "<br><br><br>";
        // Verificar si la respuesta contiene la propiedad RequestTransactionResult
        if (isset($responseArray['RequestTransactionResult'])) {
            $result = $responseArray['RequestTransactionResult'];
			//print_r($result);
            if (isset($result['Response'])) {
                $response = $result['Response'];
				//print_r($response);
				
				
                // Verificar si hay un error en la respuesta
                if (isset($response->Result) && $response->Result == 'false') {
					
                    echo 'Error: ' . $response->Description . '<br>';
                    //INICIAR CON INSERT FALLA CERTIFICACION.
                    if (isset($response->Data)) {
                        echo 'Data: ' . $response->Data . '<br>';
                
                        // Extraer los valores necesarios
                        $DocumentGUID = $responseArray['RequestTransactionResult']['Response']['Identifier']['DocumentGUID'];
                        $Batch = $responseArray['RequestTransactionResult']['Response']['Identifier']['Batch'];
                        $Serial = $responseArray['RequestTransactionResult']['Response']['Identifier']['Serial'];
                        $InternalID = $responseArray['RequestTransactionResult']['Response']['Identifier']['InternalID'];
                        $ResponseData1 = $responseArray['RequestTransactionResult']['ResponseData']['ResponseData1'];
                        $Description = $responseArray['RequestTransactionResult']['Response']['Description'];
                
                        // Decode y procesamiento XML
                        $xml = simplexml_load_string(base64_decode($ResponseData1));
                        $xml->registerXPathNamespace('dte', 'http://www.sat.gob.gt/dte/fel/0.2.0');
                
                        $fechaHoraCertificacion = $xml->xpath('//dte:FechaHoraCertificacion');
                
                        if (!empty($fechaHoraCertificacion)) {
                            echo 'Fecha y Hora de Certificación: ' . $fechaHoraCertificacion[0] . '</br>';
                        } else {
                            echo 'No se encontró la Fecha y Hora de Certificación.' . '</br>';
                        }
                
                        $serie = $xml->xpath('//dte:NumeroAutorizacion/@Serie');
                        $numero = $xml->xpath('//dte:NumeroAutorizacion/@Numero');
                
                        if (!empty($serie) && !empty($numero)) {
                            $Fel_Serie = $serie[0];
                            $Fel_Documento = $numero[0];
                        } else {
                            echo 'No se encontró la Serie y el Numero.' .  '</br>';
                        }
                
                        // Preparar datos para la consulta de inserción
                        $insert_fields = array(
                            'UUID' => "'$DocumentGUID'",
                            'No_Serie' => "'$Batch'",
                            'No_Doc' => "'$Serial'",
                            'factura_venta_Id' => '[p_factura_venta_Id]',
                            'Fel_Serie' => "'$Fel_Serie'",
                            'Fel_Documento' => "'$Fel_Documento'",
                            'Fel_Response' => "'$ResponseData1'",
                            'Fel_Message' => "'$Description'",
                            'CreatedAt' => 'GetDate()',
                            'Empresa_Id' => "'$codigoEstablecimientoEmisor'",
                            'Fel_Fecha' => "'$fechaHoraCertificacion[0]'",
                            'Fel_Link' => "'$InternalID'",
                            'Tipo_Doc' => "'FACT_ERROR_CERTIFICACION'",
                        );
                
                        // Ejecutar la consulta de inserción
                        $insert_sql = 'INSERT INTO Fel_Response (' . implode(', ', array_keys($insert_fields)) . ') VALUES (' . implode(', ', array_values($insert_fields)) . ')';
                        sc_exec_sql($insert_sql);
                
                        echo $DocumentGUID;
                        sc_redir(grid_dbo_Vw_Factura_Venta);
                    }
                    //FIN FALLA CERTIFICACION INSERTAR.
                } else {

                        // Extraer los valores necesarios
					$DocumentGUID = $responseArray['RequestTransactionResult']['Response']['Identifier']['DocumentGUID'];
					$Batch = $responseArray['RequestTransactionResult']['Response']['Identifier']['Batch'];
					$Serial = $responseArray['RequestTransactionResult']['Response']['Identifier']['Serial'];
					$InternalID = $responseArray['RequestTransactionResult']['Response']['Identifier']['InternalID'];
					$ResponseData1 = $responseArray['RequestTransactionResult']['ResponseData']['ResponseData1'];
					$Description = $responseArray['RequestTransactionResult']['Response']['Description'];
					$Type1 = $responseArray['RequestTransactionResult']['Response']['Identifier']['Type1'];


					$ResponseData2 = $responseArray['RequestTransactionResult']['ResponseData']['ResponseData2'];
					$ResponseData3 = $responseArray['RequestTransactionResult']['ResponseData']['ResponseData3'];

					$InternalId = $responseArray['RequestTransactionResult']['Response']['Identifier']['InternalID'];
					$Entity = $responseArray['RequestTransactionResult']['Response']['Identifier']['Entity'];
					$FiscalName = $responseArray['RequestTransactionResult']['Response']['Identifier']['FiscalName'];
					$IssuedTimeStamp = $responseArray['RequestTransactionResult']['Response']['Identifier']['IssuedTimeStamp'];
					$BatchTimeStamp = $responseArray['RequestTransactionResult']['Response']['Identifier']['BatchTimeStamp'];
					$BatchRequestorEntity = $responseArray['RequestTransactionResult']['Response']['Identifier']['BatchRequestorEntity'];
					$Type2 = $responseArray['RequestTransactionResult']['Response']['Identifier']['Type2'];


					$ResponseDataDecode = base64_decode($ResponseData1);
					$ResponseDataDecode2 = base64_decode($ResponseData2);
					$ResponseDataDecode3 = base64_decode($ResponseData3);


					$xmlString = $ResponseDataDecode; // Tu XML completo como una cadena
					$xml = simplexml_load_string($xmlString);
					// Utiliza namespaces para acceder a los elementos
					$xml->registerXPathNamespace('dte', 'http://www.sat.gob.gt/dte/fel/0.2.0');
					// Encuentra y muestra el valor de FechaHoraCertificacion
					$fechaHoraCertificacion = $xml->xpath('//dte:FechaHoraCertificacion');
					if (!empty($fechaHoraCertificacion)) {
						echo 'Fecha y Hora de Certificación: ' . $fechaHoraCertificacion[0] . '</br>';
					} else {
						echo 'No se encontró la Fecha y Hora de Certificación.' . '</br>';
					}

					// Puedes hacer lo mismo para Serie y Numero
					$serie = $xml->xpath('//dte:NumeroAutorizacion/@Serie');
					$numero = $xml->xpath('//dte:NumeroAutorizacion/@Numero');
					if (!empty($serie) && !empty($numero)) {
						$Fel_Serie = $serie[0];
						$Fel_Documento = $numero[0];
						//echo 'Serie: ' . $serie[0] . ', Numero: ' . $numero[0] . '</br>';
					} else {
						echo 'No se encontró la Serie y el Numero.' .  '</br>';
					}

					//$fechaHoraCert = (string) date('Y-m-d\TH:i:s', $fechaHoraCertificacion[0]);

					$update_sql = "UPDATE Persona_Factura_Venta set estado_id = 3 WHERE factura_venta_id = '[p_factura_venta_Id]'";
					sc_exec_sql($update_sql);
				//'No_Serie' => "'$Batch'",
					// SQL statement parameters
					$insert_table  = 'Fel_Response';      // Table name
					$insert_fields = array(   // Field list, add as many as needed
						'UUID' => "'$DocumentGUID'",
						'No_Serie' => "'$InsertSerie_interna'",
						'No_Doc' => "'$InsertNumero_interno'",
						'factura_venta_Id' => [p_factura_venta_Id],
						'Fel_Serie' => "'$Fel_Serie'",
						'Fel_Documento' => "'$Fel_Documento'",
						'Fel_Response' => "'$ResponseData1'",
						'Fel_Message' => "'$Description'",
						'CreatedAt' => "GetDate()",
						'Empresa_Id' => "'$codigoEstablecimientoEmisor'",
						'Fel_Fecha' => "'$fechaHoraCertificacion[0]'",
						'Fel_Link' => "'$InternalID'",
						'Tipo_Doc' => "'FACT'",
					);

					// Insert record
					$insert_sql = 'INSERT INTO ' . $insert_table
						. ' ('   . implode(', ', array_keys($insert_fields))   . ')'
						. ' VALUES ('    . implode(', ', array_values($insert_fields)) . ')';

					//echo $insert_sql;
					sc_exec_sql($insert_sql);
					echo $DocumentGUID;
					sc_redir(grid_dbo_Vw_Factura_Venta);
					
					
                }
            }
        } else {
            echo 'No se recibió una respuesta válida del servicio.<br>';
					$insert_table  = 'Fel_Response';      // Table name
					$insert_fields = array(   // Field list, add as many as needed
						'UUID' => "'$DocumentGUID'",
						'No_Serie' => "'$InsertSerie_interna'",
						'No_Doc' => "'$InsertNumero_interno'",
						'factura_venta_Id' => [p_factura_venta_Id],
						'Fel_Serie' => "'$Fel_Serie'",
						'Fel_Documento' => "'$Fel_Documento'",
						'Fel_Response' => "'$ResponseData1'",
						'Fel_Message' => "'$Description'",
						'CreatedAt' => "GetDate()",
						'Empresa_Id' => "'$codigoEstablecimientoEmisor'",
						'Fel_Fecha' => "'$fechaHoraCertificacion[0]'",
						'Fel_Link' => "'$InternalID'",
						'Tipo_Doc' => "'ERROR_FACT_RESPUESTA_INVALIDAXML'",
					);

					// Insert record
					$insert_sql = 'INSERT INTO ' . $insert_table
						. ' ('   . implode(', ', array_keys($insert_fields))   . ')'
						. ' VALUES ('    . implode(', ', array_values($insert_fields)) . ')';

					//echo $insert_sql;
					sc_exec_sql($insert_sql);
			
			sc_redir(grid_dbo_Vw_Factura_Venta);
        }
    } else {
        echo 'No se recibió una respuesta válida del servicio.<br>';
					$insert_table  = 'Fel_Response';      // Table name
					$insert_fields = array(   // Field list, add as many as needed
						'UUID' => "'$DocumentGUID'",
						'No_Serie' => "'$InsertSerie_interna'",
						'No_Doc' => "'$InsertNumero_interno'",
						'factura_venta_Id' => [p_factura_venta_Id],
						'Fel_Serie' => "'$Fel_Serie'",
						'Fel_Documento' => "'$Fel_Documento'",
						'Fel_Response' => "'$ResponseData1'",
						'Fel_Message' => "'$Description'",
						'CreatedAt' => "GetDate()",
						'Empresa_Id' => "'$codigoEstablecimientoEmisor'",
						'Fel_Fecha' => "'$fechaHoraCertificacion[0]'",
						'Fel_Link' => "'$InternalID'",
						'Tipo_Doc' => "'ERROR_FACT_SERVICIO'",
					);

					// Insert record
					$insert_sql = 'INSERT INTO ' . $insert_table
						. ' ('   . implode(', ', array_keys($insert_fields))   . ')'
						. ' VALUES ('    . implode(', ', array_values($insert_fields)) . ')';

					//echo $insert_sql;
					sc_exec_sql($insert_sql);
		sc_redir(grid_dbo_Vw_Factura_Venta);
    }
} catch (SoapFault $e) {
    echo 'Error: ' . $e->getMessage();
	sc_redir(grid_dbo_Vw_Factura_Venta);
}





?>