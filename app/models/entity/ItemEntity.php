<?php

class ItemEntity {
    private int $id;
    private string $nombre;
    private string $telefono;

    public function __construct(int $id, string $nombre, string $telefono) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
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

    /**
     * Get the value of nombre
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of telefono
     */
    public function getTelefono(): string
    {
        return $this->telefono;
    }

    /**
     * Set the value of telefono
     */
    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }
}