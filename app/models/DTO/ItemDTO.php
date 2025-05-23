<?php

class ItemDTO implements JsonSerializable {

    private string $nombre;
    private string $telefono;

    public function __construct(string $nombre, string $telefono) {
        $this->nombre = $nombre;
        $this->telefono = $telefono;
    }

    public function jsonSerialize(): mixed {
        return [
            'nombre' => $this->nombre,
            'telefono' => $this->telefono
        ];
    }

    /**
     * Get the value of nombre
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Get the value of telefono
     */
    public function getTelefono(): string
    {
        return $this->telefono;
    }
}