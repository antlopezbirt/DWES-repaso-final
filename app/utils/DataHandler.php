<?php

class DataHandler {

    private $jsonFile;

    public function __construct($ficheroDatos) {
        $this->jsonFile = $ficheroDatos;
    }

    public function getAll() {
        $datos = json_decode(file_get_contents($this->jsonFile), true);

        // Array de datos
        $items = [];
        foreach($datos as $dato) {
            $item = new ItemModel($dato['id'], $dato['nombre'], $dato['telefono']);
            array_push($items, $item);
        }
        return $items;
    }

    public function getById(int $id) {
        $items = $this->getAll();
        foreach($items as $item) {
            if($item->getId() == $id) return $item;
        }

        return false;
    }

    public function create($id, $data) {
        $item = new ItemModel($id, $data['nombre'], $data['telefono']);

        $items = $this->getAll();

        array_push($items, $item);


        if ($this->save($items)) {
            return $item;
        } else return false;
    }

    public function update($data) {

        $items = $this->getAll();

        for ($i = 0; $i < count($items); $i++) {
            if ($items[$i]->getId() == $data['id']) {

                $itemEditado = new ItemModel($data['id'],$data['nombre'], $data['telefono']);

                array_splice($items, $i, 1, [$itemEditado]);
                if ($this->save($items)) return $itemEditado;
                else return false;
            }
        }

        return false;

    }

    public function delete($id) {
        $items = $this->getAll();

        for ($i = 0; $i < count($items); $i++) {
            if ($items[$i]->getId() == $id) {
                $itemEliminado = array_splice($items, $i, 1);
                if ($this->save($items)) return $itemEliminado;
                else return false;
            }
        }

        return false;
    }

    private function save($data) {
        try {
            file_put_contents($this->jsonFile, json_encode($data, JSON_PRETTY_PRINT));
            return true;
        } catch (Error $e) {
            return false;
        }
    }
}