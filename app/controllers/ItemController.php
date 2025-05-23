<?php

class ItemController {
    private $dataHandler;
    private $itemDAO;

    public function __construct() {
        $this->dataHandler = new DataHandler(DATA_FILE);
        $this->itemDAO = new ItemDAO();
    }

    public function getAll() {
        // $items = $this->dataHandler->getAll();
        // $respuesta = new ApiJsonResponse('OK', 200, 'Todos los items', $items);
        // $this->sendApiResponse($respuesta);
        // return true;

        $itemDTOs = $this->itemDAO->getAll();

        $response = null;
        if(count($itemDTOs) > 0) {
            $response = new ApiJsonResponse('OK', 200, 'Todos los items', $itemDTOs);
        } else {
            $response = new ApiJsonResponse('Not Found', 404, 'No hay ítems', null);
        }

        $this->sendApiResponse($response);
    }

    public function getById($id) {
        // $item = null;
        // $item = $this->dataHandler->getById($id);
        // $respuesta = null;
        // if ($item != null) {
        //     $respuesta = new ApiJsonResponse('OK','200', 'Item solicitado', $item);
        // } else {
        //     $respuesta = new ApiJsonResponse('Not Found', '404', 'El ítem solicitado no existe', null);
        // }
        // $this->sendApiResponse($respuesta);

        $itemDTO = $this->itemDAO->getByID($id);


        $respuesta = null;
        if ($itemDTO) {
            $respuesta = new ApiJsonResponse('OK','200', 'Item solicitado', $itemDTO);
        } else {
            $respuesta = new ApiJsonResponse('Not Found', '404', 'El ítem solicitado no existe', null);
        }
        $this->sendApiResponse($respuesta);
    }

    public function create($data) {
        // $id = $this->createNewId();

        // $item = $this->dataHandler->create($id, $data);
        // $respuesta = null;
        // if ($item) {
        //     $respuesta = new ApiJsonResponse('Created', '204', 'Item agregado', $item);
        // } else {
        //     $respuesta = new ApiJsonResponse('Server Error', '500', 'No se pudo agregar el ítem', null);
        // }
        // $this->sendApiResponse($respuesta);

        $itemDTOCrear = new ItemDTO($data['nombre'], $data['telefono']);

        $itemDTO = $this->itemDAO->create($itemDTOCrear);

        $respuesta = null;
        if ($itemDTO) {
            $respuesta = new ApiJsonResponse('Created', '204', 'Item agregado', $itemDTO);
        } else {
            $respuesta = new ApiJsonResponse('Server Error', '500', 'No se pudo agregar el ítem', null);
        }
        $this->sendApiResponse($respuesta);
        
    }

    public function update($data) {
        // $respuesta = null;

        // if($this->dataHandler->getById($data['id'])) {
        //     $itemEditado = $this->dataHandler->update($data);
            
        //     if ($itemEditado) {
        //         $respuesta = new ApiJsonResponse('No Content', 204, 'Item actualizado', $itemEditado);
        //     } else {
        //         $respuesta = new ApiJsonResponse('Server Error', 500, 'No se pudo actualizar el ítem', null);
        //     }
        // } else {
        //     $respuesta = new ApiJsonResponse('Not Found', 404, 'No existe el item a actualizar', null);
        // }

        // $this->sendApiResponse($respuesta);

        $respuesta = null;

        if($this->itemDAO->getByID($data['id'])) {

            $itemActualizado = $this->itemDAO->update($data);

            if($itemActualizado) {

                $respuesta = new ApiJsonResponse('No Content', 204, 'Item actualizado', $itemActualizado);
            } else {
                $respuesta = new ApiJsonResponse('Server Error', 500, 'No se pudo actualizar el ítem', null);
            }

        } else {
            $respuesta = new ApiJsonResponse('Not Found', 404, 'No existe el item a actualizar', null);
        }

        $this->sendApiResponse($respuesta);
    }


    public function delete($data) {
        // $respuesta = null;

        // if($this->dataHandler->getById($data['id'])) {
        //     $itemEliminado = $this->dataHandler->delete($data['id']);
            
        //     if ($itemEliminado) {
        //         $respuesta = new ApiJsonResponse('No Content', 204, 'Item eliminado', $itemEliminado);
        //     } else {
        //         $respuesta = new ApiJsonResponse('Server Error', 500, 'No se pudo eliminar el ítem', null);
        //     }
        // } else {
        //     $respuesta = new ApiJsonResponse('Not Found', 404, 'No existe el item a eliminar', null);
        // }

        // $this->sendApiResponse($respuesta);

        $respuesta = null;

        if($this->itemDAO->getByID($data['id'])) {
            $itemDTOEliminado = $this->itemDAO->delete($data['id']);

            if ($itemDTOEliminado) {
                $respuesta = new ApiJsonResponse('No Content', 204, 'Item eliminado', $itemDTOEliminado);
            } else {
                $respuesta = new ApiJsonResponse('Server Error', 500, 'No se pudo eliminar el ítem', null);
            }
        } else {
            $respuesta = new ApiJsonResponse('Not Found', 404, 'No existe el item a eliminar', null);
        }

        $this->sendApiResponse($respuesta);

    }



    private function sendApiResponse (ApiJsonResponse $respuesta) {
        header("Content-type: application/json");
        echo json_encode($respuesta, JSON_PRETTY_PRINT);
    }

    private function createNewId(): int {
        $items = $this->dataHandler->getAll();
        $newId = 0;

        foreach($items as $item) {
            if($newId <= $item->getId()) {
                $newId = $item->getId() + 1;
            }
        }

        return $newId;
    }
}