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

            // endpoint : GET /libros/{id}
            // Obtiene la información del libro dado el $id.

            $id = intval($_GET["id"]);
            get_libro($id);

        }
        else
        {

            // responde a endpoint : GET /libros
            // Obtiene la información de todos los libros.

            get_libros();

        }
        break;
    
    case 'POST':

        // responde a endpoint : POST /libros
        // Inserta un libro.

        if ($auth->permite_escritura())
            insertar_libro();

        break;

    case 'PUT':

        // responde a endpoint : PUT /libros/{id}
        // actualiza el libro dado el {id}.
    
        $id = intval($_GET['id']);

        if ($id == 0)
            header("HTTP/1.0 405 Method Not Allowed");
        else 
        {
            if ($auth->permite_escritura())
                actualizar_libro($id);
        }
            

        break;

    case 'DELETE':
        
        // responde a endpoint : DELETE /libros/{id}
        // elimina el libro dado el {id}.

        $id = intval($_GET['id']);

        if ($id == 0)
            header("HTTP/1.0 405 Method Not Allowed");
        else 
        {
            if ($auth->permite_escritura())
                eliminar_libro($id);
        }

        break;

	default:
		header("HTTP/1.0 405 Method Not Allowed");
		break;
}

function get_libro($id)
{
    global $connection;

    $query_cerveza = 'SELECT * FROM Cerveza WHERE id = '.$id;

    
    $respuesta = array();
    $resultado = mysqli_query($connection, $query_cerveza);

    while ($item = mysqli_fetch_array($resultado))
    {
           $respuesta[] = array(
            'id' => $item['id'],
            'nombre' => utf8_decode($item['nombre'])
        );

    header('Content-Type: application/json');
    echo json_encode(array('libro' => $respuesta));
    
    /*while ($item = mysqli_fetch_array($resultado))
    {
	$query_autores = 'SELECT * FROM autor_libro WHERE id_libro = '.$item['id'];
        $resultado_autores = mysqli_query($connection, $query_autores);
        $autores = array();
        while ($autor = mysqli_fetch_array($resultado_autores))
        {
            $autores[] = array(
                'id' => $autor['id_autor']
            );
        }
        $respuesta[] = array(
            'id' => $item['id'],
            'nombre' => utf8_decode($item['nombre']),
            'genero' => utf8_decode($item['genero']),
            'precio' => $item['precio'],
	    'autores' => $autores
        );
    }

    header('Content-Type: application/json');
    echo json_encode(array('libro' => $respuesta));*/
    
    /*
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
    echo json_encode(array('autor' => $respuesta));

    */

}

function get_libros()
{

    global $connection;

    $query_autores = 'SELECT * FROM Cerveza';

    $respuesta = array();
    $resultado = mysqli_query($connection, $query_autores);
    while ($item = mysqli_fetch_array($resultado))
    {

        $respuesta[] = array(
            'id' => $item['id'],
            'nombre' => utf8_decode($item['nombre'])        
        );
    }

    header('Content-Type: application/json');
    echo json_encode(array('autores' => $respuesta));
   /* $respuesta = array();
    $resultado = mysqli_query($connection, $query_libros);

    while ($item = mysqli_fetch_array($resultado))
    {

        $query_autores = 'SELECT * FROM autor_libro WHERE id_libro = '.$item['id'];
        $resultado_autores = mysqli_query($connection, $query_autores);
        $autores = array();
	while ($autor = mysqli_fetch_array($resultado_autores))
        {
	    $autores[] = array(
	        'id' => $autor['id_autor']
	    );
	}

        $respuesta[] = array(
            'id' => $item['id'],
            'nombre' => utf8_decode($item['nombre']),
            'genero' => utf8_decode($item['genero']),
            'autores' => $autores
        );
    }

    header('Content-Type: application/json');
    echo json_encode(array('libros' => $respuesta));
    */

}

function insertar_libro()
{
    global $connection;

    $data = json_decode(file_get_contents('php://input'), true);

    $nombre = utf8_decode($data['nombre']);
    $genero = utf8_decode($data['genero']);
    $precio = $data['precio'];
    $autores = $data['autores'];

    $query = '
        INSERT INTO libros 
        SET 
            nombre = "'.$nombre.'", 
            genero = "'.$genero.'", 
            precio = '.$precio.'
    ';

    if (mysqli_query($connection, $query))
    {

	$libro_id = mysqli_insert_id($connection);

        foreach ($autores as $autor)
        {
            $query = '
                 INSERT INTO autor_libro
                 SET
                     id_autor = '.$autor.',
                     id_libro = '.$libro_id.'
            ';
            mysqli_query($connection, $query);

        }
        $response = array(
            'status' => 1,
            'status_message' =>'Libro ingresado correctamente.'
        );
    }
    else
    {
        $response = array(
            'status' => 0,
            'status_message' =>'Error en el ingreso del libro.'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);

}

function actualizar_libro($id)
{
    global $connection;

    $post_vars = json_decode(file_get_contents('php://input'), true);

    $nombre = $post_vars['nombre'];
    $genero = $post_vars['genero'];
    $precio = $post_vars['precio'];
    $autores = $post_vars['autores'];

    $query = '
        UPDATE libros 
        SET
            nombre = "'.$nombre.'", 
            genero = "'.$genero.'", 
            precio = "'.$precio.'" 
        WHERE id = '.$id;

    if(mysqli_query($connection, $query))
    {

	mysqli_query($connection, 'DELETE FROM autor_libro WHERE id_libro = '.$id);
 
        foreach ($autores as $autor)
        {
            $query = '
                 INSERT INTO autor_libro
                 SET
                     id_autor = '.$autor.',
                     id_libro = '.$id.'
            ';
            mysqli_query($connection, $query);

        }

        $response = array(
            'status' => 1,
            'status_message' =>'Libro actualizado satisfactoriamente.'
        );
    }
    else
    {
        $response = array(
            'status' => 0,
            'status_message' =>'No se pudo actualizar el libro.'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);

}

function eliminar_libro($id)
{

    global $connection;
    
    $query = 'DELETE FROM libros WHERE id = '.$id;
    
	if (mysqli_query($connection, $query))
	{
		$response = array(
			'status' => 1,
			'status_message' =>'Libro eliminado existosamente.'
		);
	}
	else
	{
		$response = array(
			'status' => 0,
			'status_message' => 'No se pudo eliminar el libro..'
		);
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
}