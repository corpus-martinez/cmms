<?php
date_default_timezone_set("America/Mexico_City");

/*-- Incluir informacion de la base de datos y conectar --*/
//
include("config/mysql.php");

$conn = mysqli_connect("$mysql_localhost", "$mysql_username", "$mysql_password", "$mysql_database");


/*-- Manejo de error de conexion --*/
//
if(!$conn)
  {
  die("Error: ".mysqli_connect_error());
  }


$a = isset($_GET['a'])? $_GET['a']: "";   // action
$f = isset($_GET['f'])? $_GET['f']: "";   // filter
$i = isset($_GET['i'])? $_GET['i']: "";   // info
$s = isset($_GET['s'])? $_GET['s']: "";   // screen
$t = isset($_GET['t'])? $_GET['t']: "";   // tab
$v = isset($_GET['v'])? $_GET['v']: "";   // value
$n = isset($_GET['n'])? $_GET['n']: "";   // number
$o = isset($_GET['o'])? $_GET['o']: "";   // option

if($a=="logout")
  {
  mysqli_close($conn);
  session_destroy();
  $_SESSION['username']="";
  }

$login = 0;
$username = isset($_SESSION['username'])? $_SESSION['username']: "";

if($username=="")
  {
  $username = isset($_POST['username'])? $_POST['username']: "";
  $password = isset($_POST['password'])? $_POST['password']: "";
  if($username=="")
    {
    ?>
    <!DOCTYPE html>
    <head>
    <title>Servicio - Inicio de sesion </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body>
	    <table width="100%" height="75%">
        <tr>
          <td align="center" valign="middle">
            <h2 style="font-family:Arial narrow;color:gray">Inicio de sesion</h2><br>
            <form action="index.php?a=login" method="POST">
            <table width="454" bgcolor="black" cellpadding="5" cellspacing="5" border="0">
              <tr> 
                <td colspan="2" bgcolor="#ffbe10">
                  <font face="Arial" size="5">&nbsp; <b>CMMS </b><br>&nbsp; Servicio </font>
                </td>
              </tr>
              <tr>
                <td align="right">
                  <font face="Verdana" size="2" color="#ffbe10"><b>Nombre de usuario: </b>
                </td>
                <td>
                  <input type="text" size="20" name="username">
                </td>
              </tr>
              <tr>
                <td align="right">
                  <font face="Verdana" size="2" color="#ffbe10"><b>Contrase&ntilde;a: </b>
                </td>
                <td>
                  <input type="password" size="20" name="password">
                </td> 
              </tr>
              <tr>
                <td>
                  &nbsp; 
                </td>
                <td>
                  <input type="submit" value=" Aceptar ">
                </td>
              </tr>
            </table><br>
            </form>
          </td>
        </tr>
       </table>
    </body>
    </html>
    
    <?php
    exit();
    }
  else
    {
	  $query  = "SELECT id, username, password, nombre ";
	  $query .= "FROM usuarios  ";
	  $query .= "WHERE username='$username' AND password='$password'";
	
	  $rs = mysqli_query($conn, $query);
	
	  if($row = mysqli_fetch_array($rs)) {
      if($password == $row["password"] And $password != NULL) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['nombre']   = $row['nombre'];
        $login = 1;
      }
    }



	if(!$login)
	  {
	  ?>
	  <!DOCTYPE html>
    <head>
      <title>Error: Inicio de sesion fall&oacute;</title>
      <style type="text/css">
        body {
          font-family:Arial;
        }

        .hh2 {
          color: white;
          font-size: 22px;
        }
      </style>
    </head>
    <body>
      &nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>
	   <table width="100%"" height="75%">
	     <tr>
	     <td align="center" valign="middle">
	      <table width="90%" cellpadding="8">
	       <tr>
	         <td bgcolor="red" align="center">
	          <b><span class="hh2">&iexcl;Error! </span><br>&nbsp;<br>
	         El nombre de usuario no esta registrado o el password es incorrecto</b><P>
	         </td>
	       </tr>
	       </table>
         &nbsp;<br>&nbsp;<br>
	       <a href=index.php>Volver a intentar </a>
	     </td>
	     </tr>
	   </table>
   </body>
	   
	  <?php
	  exit();
      }
    }
  }

?>