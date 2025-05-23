<?php

class ItemModel implements JsonSerializable {
    private int $id;
    private String $nombre;
    private int $telefono;

    public function __construct($id, $nombre, $telefono) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'telefono' => $this->telefono
        ];
    }

    

    /**
     * Get the value of telefono
     */
    public function getTelefono(): int
    {
        return $this->telefono;
    }

    /**
     * Set the value of telefono
     */
    public function setTelefono(int $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getNombre(): String
    {
        return $this->nombre;
    }

    /**
     * Set the value of name
     */
    public function setNombre(String $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}