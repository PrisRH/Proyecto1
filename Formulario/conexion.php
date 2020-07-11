<?php

/**
 *
 */
class Conexion
{
  private $pdo;
  private $_servername = "localhost";
  private $_username = "SQLEXPRESS";
  private $_database = "proyecto";
  private $_password = "";

  private $_consulta = [];

  public function __construct()
  {
    
 }

public function conectar()
  {
    $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
    //Objeto PDO, Controlador de BD, IP del servidor o localhost, nombre de la BD, usuario y contraseña
    $this->pdo= new PDO("sqlsrv:server=".$this->_servername.";database=".$this->_database, $this->_username, $this->_password );
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $this->pdo;
  }

 public function realizarConsulta($Consulta)
  {
    $Resultado = $this->pdo->query($Consulta);
    if (!$Resultado) {
      echo $Resultado;
    }
    if ($Resultado) {
    foreach ($Resultado as $fila) {
      $contenidoFila=[];
      for ($i=0; $i <sizeof($fila)/2 ; $i++) {
        $contenidoFila[sizeof($contenidoFila)]=$fila[$i];
      }
      $this->_consulta[sizeof($this->_consulta)]=$contenidoFila;
    }
  }
    $retorno=$this->_consulta;
    $this->_consulta=[];
    return $retorno;
  }

 public function getMaxID($tbl,$campo)
  {
    $Resultado = $this->realizarConsulta("SELECT MAX($campo) AS Maximo FROM $tbl");
    $idMAximo=-1;
    if ($Resultado) {
      $idMAximo=$Resultado[0];
      $idMAximo=$idMAximo[0];
    }
    return $idMAximo;
  }

 public function IEA($Sql)
  {
    var_dump($Sql);
    $Sql=$this->pdo->prepare($Sql);
    $Resultado = $Sql->execute();
    var_dump($Resultado);
    return $Resultado;
  }

  /**
  * iEA Insertar Eliminar Actualizar
  */
  public function getNextID($tbl,$campo)
  {

    $idActual = $this->getMaxID($tbl,$campo);
    if ($idActual==null) {
      $idActual=0;
    }
    $idActual=$idActual+1;
    return $idActual;
  }
}
$conexion= new Conexion();
$conexion-> conectar();