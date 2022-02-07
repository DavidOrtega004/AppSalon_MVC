<?php
namespace Model;

class CitaServicio extends ActiveRecord{
    protected static $tabla = 'citasServicios';
    protected static $columnasDB = ['id', 'citaId', 'servicioId'];

    public $id;
    public $citaId;
    public $servicioId;
    
    public function __construct($args = []) {
        $this->id = $args['id'] = NULL;
        $this-> citaId = $args['citaId'] ?? '';
        $this->servicioId = $args['servicioId'] ?? '';
    }
}