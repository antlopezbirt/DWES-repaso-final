<?php

class Router {
    protected $routes;

    public function __construct() {
        $this->routes = [
            '/' => 'ItemController@getAll',
            '/item' => 'ItemController@getAll',
            '/item/{id}' => 'ItemController@getById',
            '/item/create' => 'ItemController@create',
            '/item/update' => 'ItemController@update',
            '/item/delete' => 'ItemController@delete'
        ];
    }

    public function match($url) {
        // echo "REQUEST_URI: " . $url ."<br>";
        $url = str_replace(BASE_URL, '', $url);
        // echo "RUTA: " . $url;

        foreach($this->routes as $ruta => $destino) {

            // Extracción de parámetros por URL con preg_match

            $patronRuta = preg_replace('/\{[a-zA-Z0-9]+\}/', '([0-9]+)?', $ruta);
            $patronRuta = str_replace('/', '\/', $patronRuta);
            if(preg_match('/^' . $patronRuta . '$/i', $url, $parametros)) {
                array_shift($parametros);

                // Identificación del controlador y el método a llamar

                list($controlador, $metodo) = explode('@', $destino);

                // Volcado de parámetros pasados en el body al array de parámetros
                if(in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT', 'DELETE'])) {
                    $parametros[] = json_decode(file_get_contents('php://input'), true);
                }

                if(class_exists($controlador) && method_exists($controlador, $metodo)) {
                    $controlador = new $controlador;
                    call_user_func_array([$controlador, $metodo], $parametros);
                    return true;
                }
            }
            
        }

        //echo "Ruta no válida";

        $this->sendNotFound($url);
    }

    private function sendNotFound($ruta) {
        header('Content-type: application/json');
        http_response_code(200);


        $respuesta = [
            'status' => 'Error',
            'code' => '404',
            'description' => 'Ruta no válida: ' . $ruta,
            'data' => null
        ];
        echo json_encode($respuesta);
    }
}