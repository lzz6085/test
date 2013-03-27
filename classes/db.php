<?php

function mysqli_prepared_query($link,$sql,$bindParams = FALSE){
  if($stmt = mysqli_prepare($link,$sql)){
    if ($bindParams){                                                                                                    
      $bindParamsMethod = new ReflectionMethod('mysqli_stmt', 'bind_param');  //allows for call to mysqli_stmt->bind_param using variable argument list       
      $bindParamsReferences = array();  //will act as arguments list for mysqli_stmt->bind_param  
      
      $typeDefinitionString = array_shift($bindParams);
      foreach($bindParams as $key => $value){
        $bindParamsReferences[$key] = &$bindParams[$key];  
      }
      
      array_unshift($bindParamsReferences,$typeDefinitionString); //returns typeDefinition as the first element of the string  
      $bindParamsMethod->invokeArgs($stmt,$bindParamsReferences); //calls mysqli_stmt->bind_param suing $bindParamsRereferences as the argument list
    }
    if(mysqli_stmt_execute($stmt)){
      $resultMetaData = mysqli_stmt_result_metadata($stmt);
      if($resultMetaData){                                                                               
        $stmtRow = array(); //this will be a result row returned from mysqli_stmt_fetch($stmt)   
        $rowReferences = array();  //this will reference $stmtRow and be passed to mysqli_bind_results 
        while ($field = mysqli_fetch_field($resultMetaData)) { 
          $rowReferences[] = &$stmtRow[$field->name]; 
        }                                
        mysqli_free_result($resultMetaData);
        $bindResultMethod = new ReflectionMethod('mysqli_stmt', 'bind_result'); 
        $bindResultMethod->invokeArgs($stmt, $rowReferences); //calls mysqli_stmt_bind_result($stmt,[$rowReferences]) using object-oriented style
        $result = array();
        while(mysqli_stmt_fetch($stmt)){
          foreach($stmtRow as $key => $value){  //variables must be assigned by value, so $result[] = $stmtRow does not work (not really sure why, something with referencing in $stmtRow)
            $row[$key] = $value;           
          }
          $result[] = $row;
        }
        mysqli_stmt_free_result($stmt);
      } else {
        $result = mysqli_stmt_affected_rows($stmt);
      }
      mysqli_stmt_close($stmt);
    } else {
      $result = FALSE;
    }
  } else {
    $result = FALSE;
  }
  return $result;
}

