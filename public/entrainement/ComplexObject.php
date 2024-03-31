<?php

namespace App\service;

class ComplexObject
{
    private int $id;
    private string $nom;
    private float $prix;
    private string $description;

    public function __construct(int $id, string $nom, float $prix, string $description){
        $this->id = $id;
        $this->nom = $nom;
        $this->prix = $prix;
        $this->description = $description;
    }
}