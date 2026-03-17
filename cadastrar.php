<?php
   $nome       = $_POST['nome'] ?? null;
   $email       = $_POST['email'] ?? null;
   $telefone    = $_POST['telefone'] ?? null;
   $endereco    = $_POST['endereco'] ?? null;
   $tipo_cliente = $_POST['tipo_cliente'] ?? null;
   $sexo        = $_POST['sexo'] ?? null;
  

  Echo 'Cliente: '.$nome.' mora em '.$endereco.'<br>';
  Echo '<br>';
  if ($tipo_cliente == 'pf'){
      Echo 'Pessoa Física';
  }else{
     Echo 'Pessoa Jurídica';
  }
 ?>

	   