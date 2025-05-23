<?php

class ItemDAO {
    private $conn;
    private string $table = "item";

    public function __construct() {
        $this->conn = DatabaseSingleton::getInstance()->connect();
    }

    public function getAll() {

        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $res = $stmt->fetchAll();

        $itemEntities = [];
        foreach($res as $result) {
            $itemEntity = new ItemEntity($result['ID'], $result['nombre'], $result['telefono']);
            array_push($itemEntities, $itemEntity);
        }

        $itemDTOs = [];

        foreach($itemEntities as $itemEntity) {
            $itemDTO = new ItemDTO($itemEntity->getNombre(), $itemEntity->getTelefono());
            array_push($itemDTOs, $itemDTO);
        }

        return $itemDTOs;
    }

    function getByID($id) {
        $query = "SELECT * FROM $this->table WHERE `ID` = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        $res = $stmt->fetchAll();

        if(count($res) === 1) {
            $itemEntity = new ItemEntity($res[0]['ID'], $res[0]['nombre'], $res[0]['telefono']);
            $itemDTO = new ItemDTO($itemEntity->getNombre(), $itemEntity->getTelefono());
            return $itemDTO;
        }
        
        return false;
    }

    function create(ItemDTO $itemDTO) {
        $query = "INSERT INTO $this->table (`nombre`, `telefono`) VALUES (:nombre, :telefono)";

        $stmt = $this->conn->prepare($query);

        // Empieza la transaccion

        $this->conn->beginTransaction();
        $res = $stmt->execute([':nombre' => $itemDTO->getNombre(), ':telefono' => $itemDTO->getTelefono()]);

        $nuevoID = $this->conn->lastInsertId();

        // Termina la transacción
        $this->conn->commit();

        if($nuevoID) {
            return $this->getByID($nuevoID);
        } else return false;
    }

    function update($data) {
        $query = "UPDATE $this->table SET `nombre` = :nombre, `telefono` = :telefono WHERE `ID` = :id";
        $stmt = $this->conn->prepare($query);
        $res = $stmt->execute([':id' => $data['id'], ':nombre' => $data['nombre'], ':telefono' => $data['telefono']]);

        if($res) return $this->getByID($data['id']);
        else return false;
    }

    function delete($id) {
        $itemDTOEliminado = $this->getByID($id);
        $query = "DELETE FROM $this->table WHERE `ID` = :id";
        $stmt = $this->conn->prepare($query);
        $res = $stmt->execute([':id' => $id]);

        if($res) return $itemDTOEliminado;
        else return false;
    }
}