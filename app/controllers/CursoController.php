<?php

if (isset($_SERVER['REQUEST_METHOD'])){

  require_once "../models/Curso.php";
  $curso = new Curso();

  switch($_SERVER['REQUEST_METHOD']){
    
    case 'GET':
      header('Content-Type: application/json; charset=utf-8');

      if ($_GET['task'] == 'getAll'){
        echo json_encode($curso->getAll());
      } else if ($_GET['task'] == 'getById'){
        echo json_encode($curso->getById($_GET['idcurso']));
      }
      break;

    case 'POST':
      $input = file_get_contents('php://input');
      $dataJSON = json_decode($input, true);

      $registro = [
        'idcategoria' => $dataJSON['idcategoria'],
        'titulo'      => $dataJSON['titulo'],
        'duracion'    => $dataJSON['duracion'],
        'nivel'       => $dataJSON['nivel'],
        'precio'      => $dataJSON['precio'],
        'fechas'      => $dataJSON['fechas'],
      ];

      $filasAfectadas = $curso->add($registro);

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(["filas" => $filasAfectadas]);
      break;

    case 'PUT':
      $input = file_get_contents('php://input');
      $dataJSON = json_decode($input, true);

      $registro = [
        'idcurso'     => $dataJSON['idcurso'],
        'idcategoria' => $dataJSON['idcategoria'],
        'titulo'      => $dataJSON['titulo'],
        'duracion'    => $dataJSON['duracion'],
        'nivel'       => $dataJSON['nivel'],
        'precio'      => $dataJSON['precio'],
        'fechas'      => $dataJSON['fechas'],
      ];

      $filasAfectadas = $curso->edit($registro);

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(["filas" => $filasAfectadas]);
      break;

    case 'DELETE':
      header('Content-Type: application/json; charset=utf-8');

      $url = $_SERVER['REQUEST_URI'];
      $arrayURL = explode('/', $url);
      $idcurso = end($arrayURL);

      $filasAfectadas = $curso->delete(['idcurso' => $idcurso]);
      echo json_encode(["filas" => $filasAfectadas]);
      break;
  }

}
?>
