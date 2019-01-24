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

        if (!empty($_GET["id_registro"]))
        {

            // endpoint : GET /bares.php/{id}
            // Obtiene la información delautor dado el $id.

            $id_registro = intval($_GET["id_registro"]);
            get_autor($id_registro);

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

        $id_registro = intval($_GET['id_registro']);

        if ($id_registro == 0)
            header("HTTP/1.0 405 Method Not Allowed");
        else
        {
            if ($auth->permite_escritura())
                actualizar_autor($id_registro);
        }


        break;

    case 'DELETE':

        // responde a endpoint : DELETE /autores/{id}
        // elimina el autor dado el {id}.

	$id_registro = intval($_GET['id_registro']);

        if ($id_registro == 0)
            header("HTTP/1.0 405 Method Not Allowed");
        else
        {
            if ($auth->permite_escritura())
                eliminar_autor($id_registro);
        }

        break;

	default:
		header("HTTP/1.0 405 Method Not Allowed");
		break;
}

function get_autor($id_registro)
{
    global $connection;

    $query_bares = 'SELECT * FROM registro WHERE id_registro = '.$id_registro;

    $respuesta = array();
    $resultado = mysqli_query($connection, $query_bares);

    while ($item = mysqli_fetch_array($resultado))
    {
           $respuesta[] = array(
            'id_registro' => $item['id_registro'],
            'id_bar' => utf8_decode($item['id_bar']),
            'id_cerveceria' => utf8_decode($item['id_cerveceria']),
            'id_producto' => utf8_decode($item['id_producto']),
            'fecha_registro' => utf8_decode($item['fecha_registro']),
            'factura' => utf8_decode($item['factura']),
            'receptor' => utf8_decode($item['receptor']),
            'linea' => utf8_decode($item['linea']),
            'fecha_elaboracion' => utf8_decode($item['fecha_elaboracion']),
            'fecha_vencimiento' => utf8_decode($item['fecha_vencimiento']),
            'tipo_barril' => utf8_decode($item['tipo_barril']),
            'etiqueta' => utf8_decode($item['etiqueta'])
        );
    }
    header('Content-Type: application/json');
    echo json_encode(array('registro' => $respuesta));

}

function get_autores()
{

    global $connection;
    $query_autores = 'SELECT * FROM registro';

    $respuesta = array();
    $resultado = mysqli_query($connection, $query_autores);
    while ($item = mysqli_fetch_array($resultado))
    {
        $respuesta[] = array(
            'id_registro' => $item['id_registro'],
            'id_bar' => utf8_decode($item['id_bar']),
            'id_cerveceria' => utf8_decode($item['id_cerveceria']),
            'id_producto' => utf8_decode($item['id_producto']),
            'fecha_registro' => utf8_decode($item['fecha_registro']),
            'factura' => utf8_decode($item['factura']),
            'receptor' => utf8_decode($item['receptor']),
            'linea' => utf8_decode($item['linea']),
            'fecha_elaboracion' => utf8_decode($item['fecha_elaboracion']),
            'fecha_vencimiento' => utf8_decode($item['fecha_vencimiento']),
            'tipo_barril' => utf8_decode($item['tipo_barril']),
            'etiqueta' => utf8_decode($item['etiqueta'])
        );
    }

    header('Content-Type: application/json');
    echo json_encode(array('registro' => $respuesta));

}

function insertar_autor()
{
    global $connection;
    $data = json_decode(file_get_contents('php://input'), true);
    $id_bar = utf8_decode($data['id_bar']);
    $id_cerveceria = utf8_decode($data['id_cerveceria']);
    $id_producto = utf8_decode($data['id_producto']);
    $fecha_registro = utf8_decode($data['fecha_registro']);
    $factura = utf8_decode($data['factura']);
    $receptor = utf8_decode($data['receptor']);
    $linea = utf8_decode($data['linea']);
    $fecha_elaboracion = utf8_decode($data['fecha_elaboracion']);
    $fecha_vencimiento = utf8_decode($data['fecha_vencimiento']);
    $tipo_barril = utf8_decode($data['tipo_barril']);
    $etiqueta = utf8_decode($data['etiqueta']);


    $query = '
        INSERT INTO registro
        SET
            id_bar = "'.$id_bar.'",
            id_cerveceria = "'.$id_cerveceria.'",
            id_producto = "'.$id_producto.'",
            fecha_registro = "'.$fecha_registro.'",
            factura = "'.$factura.'",
            receptor = "'.$receptor.'",
            linea = "'.$linea.'",
            fecha_elaboracion = "'.$fecha_elaboracion.'",
            fecha_vencimiento = "'.$fecha_vencimiento.'",
            tipo_barril = "'.$tipo_barril.'",
            etiqueta = "'.$etiqueta.'"
    ';
    print_r($query);

    if (mysqli_query($connection, $query))
    {
        $response = array(
            'status' => 1,
            'status_message' =>'registro ingresado correctamente.'
        );
    }
    else
    {
        $response = array(
            'status' => 0,
            'status_message' =>'Error en el ingreso del registro.'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);

}

function actualizar_autor($id_registro)
{
    global $connection;

    $post_vars = json_decode(file_get_contents('php://input'), true);

    $id_bar = utf8_decode($post_vars['id_bar']);
    $id_cerveceria = utf8_decode($post_vars['id_cerveceria']);
    $id_producto = utf8_decode($post_vars['id_producto']);
    $fecha_registro = utf8_decode($post_vars['fecha_registro']);
    $factura = utf8_decode($post_vars['factura']);
    $receptor = utf8_decode($post_vars['receptor']);
    $linea = utf8_decode($post_vars['linea']);
    $fecha_elaboracion = utf8_decode($post_vars['fecha_elaboracion']);
    $fecha_vencimiento = utf8_decode($post_vars['fecha_vencimiento']);
    $tipo_barril = utf8_decode($post_vars['tipo_barril']);
    $etiqueta = utf8_decode($post_vars['etiqueta']);

    $query = '
        UPDATE registro
        SET
            id_bar = "'.$id_bar.'",
            id_cerveceria = "'.$id_cerveceria.'",
            id_producto = "'.$id_producto.'",
            fecha_registro = "'.$fecha_registro.'",
            factura = "'.$factura.'",
            receptor = "'.$receptor.'",
            linea = "'.$linea.'",
            fecha_elaboracion = "'.$fecha_elaboracion.'",
            fecha_vencimiento = "'.$fecha_vencimiento.'",
            tipo_barril = "'.$tipo_barril.'",
            etiqueta = "'.$etiqueta.'"
        WHERE id_registro = '.$id_registro;

    if(mysqli_query($connection, $query))
    {
        $response = array(
            'status' => 1,
            'status_message' =>'registro actualizado satisfactoriamente.'
        );
    }
    else
    {
        $response = array(
            'status' => 0,
            'status_message' =>'No se pudo actualizar el registro.'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);

}

function eliminar_autor($id)
{

    global $connection;

    $query = 'DELETE FROM registro WHERE id_registro = '.$id;

	if (mysqli_query($connection, $query))
	{
		$response = array(
			'status' => 1,
			'status_message' =>'registro eliminado existosamente.'
		);
	}
	else
	{
		$response = array(
			'status' => 0,
			'status_message' => 'No se pudo eliminar el registro.'
		);
    }

	header('Content-Type: application/json');
    echo json_encode($response);

}
