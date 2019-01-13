<?php

class Auth 
{

    private $user = '';
    private $password = '';
    private $connection = null;
    private $rol = 'W';

    public function usuario_valido() {

        global $connection;
        $usuario_valido = false;

        // Obtenemos los valores de usuario y password que vienen desde le llamda HTTP
        // para validar la autenticación y obtener el ROL para saber si es de sólo 
        // lectura o permite modificar registros.

        $user = $_SERVER['PHP_AUTH_USER'];
        $pass = $_SERVER['PHP_AUTH_PW'];

        // Se verifican las credenciales contra la BD.

        $query_usuario = '
            SELECT * FROM usuario
            WHERE 
                nombre = "'.$user.'"
                AND password = "'.$pass.'"
            LIMIT 1';

        $respuesta = array();
        $resultado = mysqli_query($connection, $query_usuario);

        while ($item = mysqli_fetch_array($resultado))
        {

            // Si el usuario es válido, guarda el rol en la variable de la clase $auth->rol.

            // Los valores posibles de $this->rol son :
            // R : Sólo lectura (Read).
            // W : Escritura (Write).

            $this->rol = $item['tipo'];
            $usuario_valido = true;

        }

        if (!$usuario_valido) {

            header('WWW-Authenticate: Basic realm="Catalogo Libros UMAYOR"');
            header('HTTP/1.0 401 Unauthorized');
            die ("Not authorized");

        }

    }

    public function permite_escritura() {

        // Valida si el usuario que está llamando a la peticion tiene permisos de 
        // escritura (Write) : 

        return $this->rol == 'W' ? true : header("HTTP/1.0 406 Not Acceptable");
        
    }

}
