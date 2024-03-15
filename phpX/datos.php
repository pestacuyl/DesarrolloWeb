// Extraer los valores necesarios
    $Batch = $responseArray['RequestTransactionResult']['Response']['Identifier']['Batch'];
    $Serial = $responseArray['RequestTransactionResult']['Response']['Identifier']['Serial'];
    $InternalID = $responseArray['RequestTransactionResult']['Response']['Identifier']['InternalID'];
    $ResponseData1 = $responseArray['RequestTransactionResult']['ResponseData']['ResponseData1'];
    $Description = $responseArray['RequestTransactionResult']['Response']['Description'];
    $Type1 = $responseArray['RequestTransactionResult']['Response']['Identifier']['Type1'];

    $InternalId = $responseArray['RequestTransactionResult']['Response']['Identifier']['InternalID'];
    $Entity = $responseArray['RequestTransactionResult']['Response']['Identifier']['Entity'];
    $FiscalName = $responseArray['RequestTransactionResult']['Response']['Identifier']['FiscalName'];
    $IssuedTimeStamp = $responseArray['RequestTransactionResult']['Response']['Identifier']['IssuedTimeStamp'];
    $BatchTimeStamp = $responseArray['RequestTransactionResult']['Response']['Identifier']['BatchTimeStamp'];
    $BatchRequestorEntity = $responseArray['RequestTransactionResult']['Response']['Identifier']['BatchRequestorEntity'];
    $Type2 = $responseArray['RequestTransactionResult']['Response']['Identifier']['Type2'];

    //'No_Serie' => "'$Batch'",
    // SQL statement parameters
    $insert_table  = 'Fel_Response';      // Table name
    $insert_fields = array(   // Field list, add as many as needed
        'UUID' => "'$UUIDERR'",
        'No_Serie' => "'$InsertSerie_interna'",
        'No_Doc' => "'$InsertNumero_interno'",
        'factura_venta_Id' => "[p_factura_venta_Id]",
        'Fel_Serie' => "'$FelSerieErro'",
        'Fel_Documento' => "'$FelDocErro'",
        'Fel_Response' => "'$ResponseData1'",
        'Fel_Message' => "'$Description'",
        'CreatedAt' => "GetDate()",
        'Empresa_Id' => "'$codigoEstablecimientoEmisor'",
        'Fel_Fecha' => "''",
        'Fel_Link' => "'$InternalID'",
        'Tipo_Doc' => "'FACT_ERROR_CERTIFICACION'",
    );

    // Insert record
    $insert_sql = 'INSERT INTO ' . $insert_table
        . ' (' . implode(', ', array_keys($insert_fields)) . ')'
        . ' VALUES (' . implode(', ', array_values($insert_fields)) . ')';

    // Ejecutar consulta de inserción
    sc_exec_sql($insert_sql);
    echo 'Error: ' . $response['Description'] . '<br>';
    sc_redir(grid_dbo_Vw_Factura_Venta);