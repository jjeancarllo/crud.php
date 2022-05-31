<?php
include_once "conexao.php";

$acao = $_GET['acao'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

    switch ($acao){
        case 'inserir':
            $name = $_POST['name'];
            $email = $_POST['email'];
            $data = $_POST['data'];
            $mensagem = $_POST['mensagem'];

            $sql = "INSERT INTO users (user_name, user_email, user_date, user_mensagem) VALUES ('$name', '$email', '$data', '$mensagem')";

            if (!mysqli_query($conn, $sql)) {
                die ("Erro ao inserir informações" . mysqli_error($conn)); 
            }  else {
                echo "<script language='javascript' type='text/javascript'>
                alert('Dados cadastrados com sucesso!')
                window.location.href='crud.php?acao=selecionar'</script>";
            }
            break;

        case 'montar':
            
            $id = $_GET['id'];
            $sql = 'SELECT * FROM users WHERE user_id =' . $id;
            $resultado = mysqli_query($conn, $sql) or die("Erro ao retornar dados");
            
            //montando formulário
            echo "<form method= 'post' name='dados' action='crud.php?acao=atualizar' onSubmit='return enviardados();' >";
            echo "<table width='588' border= '0' align='center' >";
            
            while ($registro = mysqli_fetch_array($resultado)){
                echo "<tr>";
                echo "<td width='118'><font size='1' face='Verdana, Arial, Helvetica, sans-serif'>Código:</font></td>";
                echo "<td width='460'>";
                echo "<input name='id' type='text' class='formbutton' id='id' size='5' maxlength'10' value=" . $id . " readonly> ";
                echo "</td> ";
                echo "</td> ";
                
                echo " <tr>";
                echo "<td><font face='Verdana, Arial, Helvetica, sans-serif'><font
                size='1'>Nome<strong>:</strong></font></font></td>";
                echo " <td rowspan='2'><font size='2'>";
                echo "<style>textarea{resize:nome;}</style>";
                echo "<textarea name='nome' cols='50' rows='3' class='formbutton'>" . htmlspecialchars
                ($registro['user_name']) . "</textarea>";
                echo "</font></td>";
                echo "</tr>";
                echo "<tr>";
                
                echo " <tr>";
                echo "<td><font face='Verdana, Arial, Helvetica, sans-serif'><font
                size='1'>Data<strong>:</strong></font></font></td>";
                echo " <td rowspan='2'><font size='2'>";
                echo "<style>textarea{resize:data;}</style>";
                echo "<textarea name='data' cols='50' rows='3' class='formbutton'>" . htmlspecialchars
                ($registro['user_date']) . "</textarea>";
                echo "</font></td>";
                echo "</tr>";
                echo "<tr>";
        
                echo " <tr>";
                echo "<td><font face='Verdana, Arial, Helvetica, sans-serif'><font
                size='1'>Email<strong>:</strong></font></font></td>";
                echo " <td rowspan='2'><font size='2'>";
                echo "<style>textarea{resize:email;}</style>";
                echo "<textarea name='email' cols='50' rows='3' class='formbutton'>" . htmlspecialchars
                ($registro['user_email']) . "</textarea>";
                echo "</font></td>";
                echo "</tr>";
                echo "<tr>";
                
                echo " <tr>";
                echo "<td><font face='Verdana, Arial, Helvetica, sans-serif'><font
                size='1'>Mensagem<strong>:</strong></font></font></td>";
                echo " <td rowspan='2'><font size='2'>";
                echo "<style>textarea{resize:mensagem;}</style>";
                echo "<textarea name='mensagem' cols='50' rows='3' class='formbutton'>" . htmlspecialchars
                ($registro['user_mensagem']) . "</textarea>";
                echo "</font></td>";
                echo "</tr>";
                echo "<tr>";
                
                echo "<tr>";
                echo " <td height='22'></td>";
                echo " <td>";
                echo "<input name='Submit' type='submit'  class='formobjects' value='Atualizar'> ";
                echo " <button type='submit' formaction='crud.php?acao=selecionar'>Selecionar</button>   ";
                echo " <input name='Reset' type='reset' class='formobjects' value='Limpar campos'>";
                echo "  </td>";
                echo "  </tr>";
                echo "</table>";
                echo "</form>   ";
                 }
                mysqli_close($conn);
                break;

        case 'atualizar':
            
                $codigo = $_POST['id'];
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $data = $_POST['data'];
                $mensagem = $_POST['mensagem'];
                
                $sql = "UPDATE users SET user_name = '" . $nome . "', user_email = '" . $email . "', user_date = 
                '" . $data . "', user_mensagem = '" . $mensagem . "' WHERE user_id = '" . $codigo . "'";
                
                if (!mysqli_query($conn, $sql)) {
                    die('</br> Erro no comando SQL UPDATE: ' . mysqli_error($conn));
                } else {
                    echo "<script language='javascript' type='text/javascript'>
                    alert('Dados atualizados com sucesso!')
                    window.location.href='crud.php?acao=selecionar'</script>";
                }
            break;

        case 'deletar':
            $sql = "DELETE FROM users WHERE user_id = '" . $id . "'";
            if (!mysqli_query($conn, $sql)) {
                die('Error: ' . mysqli_error($conn));
            } else {
                echo "<script language='javascript' type='text/javascript'>
                alert('Dados excluidos com sucesso!')
                window.location.href='crud.php?acao=selecionar'</script>";
            }
            mysqli_close($conn);
            header("Location:crud.php?acao=selecionar");
            break;
        
        case 'selecionar':
            echo "<meta charset='utf-8'>";
            echo "<style>
                table.center{
                    margin-top: 85px;
                }
            th{
                background: yellow;
            }
            </style>";
            echo "<center><table border=1 class=center>";
            echo "<tr>";
            echo "<th>CODE</th>";
            echo "<th>NAME</th>";
            echo "<th>E-MAIL</th>";
            echo "<th>BIRTH DATE</th>";
            echo "<th>MESSAGE</th>";
            echo "<th>ACTION</th>";
            echo "</tr>";

            $sql = "SELECT * FROM users";
            $resultado = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

            echo "<CENTER>Registro cadastrados na base de dados.<br/><CENTER>";
            echo "<br/>";

            while ($registro = mysqli_fetch_array($resultado)) {
                $id = $registro['user_id'];
                $name = $registro['user_name'];
                $email = $registro['user_email'];
                $data = $registro['user_date'];
                $mensagem = $registro['user_mensagem'];

                    echo "<tr>";
                    echo "<td>" . $id . "</td>";
                    echo "<td>" . $name . "</td>";
                    echo "<td>" . $email . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($data)) . "</td>";
                    echo "<td>" . $mensagem . "</td>";
                    echo "<td>
                            <a href='crud.php?acao=deletar&id=$id'>
                                <img src='delete.png' alt='Deletar' title='Deletar usuário'>
                            </a>
                            <a href='crud.php?acao=montar&id=$id'>
                                <img src='update.png' alt='Atualizar' title='Atualizar registro'>
                            </a>
                            <a href='index.php'>
                                <img src='insert.png' alt='Inserir' title='Inserir registro'>
                            </a> ";
                    echo "</tr>";
            }
            mysqli_close($conn);

            break;

        default:
            header("location:crud.php?acao=selecionar");
            break;
    }
?>