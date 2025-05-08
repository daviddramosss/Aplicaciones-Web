<?php
namespace es\ucm\fdi\aw\entidades\ingrediente;

class IngredienteDTO {
    private ?int $id;
    private ?string $nombre;

    public function __construct(?int $id, ?string $nombre, bool $allowEmpty = false) {
        $this->id = $id;
        $this->setNombre($nombre, $allowEmpty);
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNombre(): ?string {
        return $this->nombre;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function setNombre(?string $nombre, bool $allowEmpty = false): void {
        $nombre = trim($nombre ?? '');
        if (!$allowEmpty && empty($nombre)) {
            throw new \InvalidArgumentException("El nombre del ingrediente no puede estar vacío");
        }
        $this->nombre = $nombre;
    }
}