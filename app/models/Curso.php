<?php

//Acceso al servidor y a la BD
require_once "../config/Database.php";

class Curso {

  private $conexion;

  public function __construct() {
    $this->conexion = Database::getConexion();
  }
  
  /**
   * Devuelve un conjunto de cursos contenidos en un arreglo
   * @return array
   */
  public function getAll(): array {
    $sql = "SELECT * FROM vista_cursos_todos";
    
    $stmt = $this->conexion->prepare($sql); //1. Preparación (seguridad)
    $stmt->execute(); //2. Ejecución

    return $stmt->fetchAll(PDO::FETCH_ASSOC); //3. Retorno FETCH_ASSOC (arreglo asociativo)
  }

  /**
   * Registra un nuevo curso en la BD
   * @param mixed $params
   * @return int
   */
  public function add($params = []): int {
    $sql = "CALL spu_cursos_registrar(?,?,?,?,?,?)"; //? = comodín (índice-ubicación)
    
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["idcategoria"],
        $params["titulo"],
        $params["duracion"],
        $params["nivel"],
        $params["precio"],
        $params["fechas"]
      )
    );

    return $stmt->rowCount();
  }

  /**
   * Actualiza un curso existente en la BD
   * @param mixed $params
   * @return int
   */
  public function edit($params = []): int {
    $sql = "CALL spu_cursos_actualizar(?,?,?,?,?,?,?)"; //? = comodín (índice-ubicación)
    
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["idcurso"],
        $params["idcategoria"],
        $params["titulo"],
        $params["duracion"],
        $params["nivel"],
        $params["precio"],
        $params["fechas"]
      )
    );

    return $stmt->rowCount();
  }

  /**
   * Elimina un curso de la BD
   * @param mixed $params
   * @return int
   */
  public function delete($params = []): int {
    //Tipos de eliminación: FÍSICA (DELETE) - LÓGICA (UPDATE)
    $sql = "DELETE FROM cursos WHERE id = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["idcurso"],
      )
    );

    return $stmt->rowCount();
  }

  /**
   * Obtiene un curso por su ID
   * @param int $idcurso
   * @return array
   */
  public function getById($idcurso): array {
    $sql = "SELECT * FROM cursos WHERE id = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array($idcurso)
    );
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

}
?>
