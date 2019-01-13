<?php

require "connection.php";
require "auth.php";

// Instancia de conexión a la BD :

$db = new dbObj();
$connection =  $db->getConnstring();

// Autenticamos que vengan los datos del usuario y coincida el user con la
// contraseña.

$auth = new Auth();
$auth->usuario_valido();

// Obtenemos el VERBO HTTP que está pidiendo la petición, las opciones pueden ser :
// GET : Para obtener datos.
// POST : Para crear datos.
// UPDATE : Para actualizar datos.
// DELETE : Para eliminar datos.

$request_method = $_SERVER['REQUEST_METHOD'];

//echo '<pre>'; var_export($_SERVER);
//echo $request_method; exit;

// Identificamos la acción que debemos ejecutar según la petición :

switch($request_method)
{

    case 'GET':
    
        if (!empty($_GET["id"]))
        {

            // endpoint : GET /bares.php/{id}
            // Obtiene la información delautor dado el $id.

            $id = intval($_GET["id"]);
            get_autor($id);

        }
        else
        {

            // responde a endpoint : GET /autores
            // Obtiene la información de todos losautores.

            get_autores();

        }
        break;
    
    case 'POST':

        // responde a endpoint : POST /autores
        // Inserta un autor.

        if ($auth->permite_escritura())
            insertar_autor();

        break;

    case 'PUT':

        // responde a endpoint : PUT /autores/{id}
        // actualiza el autor dado el {id}.
    
        $id = intval($_GET['id']);

        if ($id == 0)
            header("HTTP/1.0 405 Method Not Allowed");
        else 
        {
            if ($auth->permite_escritura())
                actualizar_autor($id);
        }
            

        break;

    case 'DELETE':
        
        // responde a endpoint : DELETE /autores/{id}
        // elimina el autor dado el {id}.

	$id = intval($_GET['id']);

        if ($id == 0)
            header("HTTP/1.0 405 Method Not Allowed");
        else 
        {
            if ($auth->permite_escritura())
                eliminar_autor($id);
        }

        break;

	default:
		header("HTTP/1.0 405 Method Not Allowed");
		break;
}

function get_autor($id)
{
    global $connection;

    $query_bares = 'SELECT * FROM Bar WHERE id = '.$id;

    $respuesta = array();
    $resultado = mysqli_query($connection, $query_bares);

    while ($item = mysqli_fetch_array($resultado))
    {
           $respuesta[] = array(
            'id' => $item['id'],
            'nombre' => utf8_decode($item['nombre']),
            'nombre_sucursal' => utf8_decode($item['nombre_sucursal']),
            'direccion_sucursal' => utf8_decode($item['direccion_sucursal'])
        );
    }
    header('Content-Type: application/json');
    echo json_encode(array('bar' => $respuesta));

}

function get_autores()
{

    global $connection;
    $query_autores = 'SELECT * FROM Bar';

    $respuesta = array();
    $resultado = mysqli_query($connection, $query_autores);
    while ($item = mysqli_fetch_array($resultado))
    {

        $respuesta[] = array(
            'id' => $item['id'],
            'nombre' => utf8_decode($item['nombre']),
            'nombre_sucursal' => utf8_decode($item['nombre_sucursal']),
            'direccion_sucursal' => utf8_decode($item['direccion_sucursal'])
        );
    }

    header('Content-Type: application/json');
    echo json_encode(array('bar' => $respuesta));

}

function insertar_autor()
{
    global $connection;
    $data = json_decode(file_get_contents('php://input'), true);
    $nombre = utf8_decode($data['nombre']);
    $nombre_sucursal = utf8_decode($data['nombre_sucursal']);
    $direccion_sucursal = utf8_decode($data['direccion_sucursal']);

    $query = '
        INSERT INTO Bar 
        SET 
            nombre = "'.$nombre.'",
            nombre_sucursal = "'.$nombre_sucursal.'",
            direccion_sucursal = "'.$direccion_sucursal.'"
    ';
    //print_r($query);

    if (mysqli_query($connection, $query))
    {
        $response = array(
            'status' => 1,
            'status_message' =>'Autor ingresado correctamente.'
        );
    }
    else
    {
        $response = array(
            'status' => 0,
            'status_message' =>'Error en el ingreso del autor.'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);

}

function actualizar_autor($id)
{
    global $connection;

    $post_vars = json_decode(file_get_contents('php://input'), true);

    $nombre = $post_vars['nombre'];
    $nombre_sucursal = $post_vars['nombre_sucursal'];
    $direccion_sucursal = $post_vars['direccion_sucursal'];
    $query = '
        UPDATE Bar
        SET
            nombre = "'.$nombre.'", 
            nombre_sucursal = "'.$nombre_sucursal.'",
            direccion_sucursal = "'.$direccion_sucursal.'"
        WHERE id = '.$id;

    if(mysqli_query($connection, $query))
    {
        $response = array(
            'status' => 1,
            'status_message' =>'Bar actualizado satisfactoriamente.'
        );
    }
    else
    {
        $response = array(
            'status' => 0,
            'status_message' =>'No se pudo actualizar el Bar.'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);

}

function eliminar_autor($id)
{

    global $connection;
    
    $query = 'DELETE FROM Bar WHERE id = '.$id;
    
	if (mysqli_query($connection, $query))
	{
		$response = array(
			'status' => 1,
			'status_message' =>'Autor eliminado existosamente.'
		);
	}
	else
	{
		$response = array(
			'status' => 0,
			'status_message' => 'No se pudo eliminar el autor.'
		);
    }
    
	header('Content-Type: application/json');
    echo json_encode($response);
    
}
