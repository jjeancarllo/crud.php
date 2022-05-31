<?php
define('HOST', 'localhost');
define('USUARIO', 'id18876985_jeancarlorocha');
define('SENHA', '+ES+[jkn~8Jv*Qv!');
define('DB', 'id18876985_jcsmr');

$conn = mysqli_connect(HOST, USUARIO, SENHA, DB) 
or
die ('Não foi posível conectar');

echo "A conexão foi efetuada com sucesso!";
?>