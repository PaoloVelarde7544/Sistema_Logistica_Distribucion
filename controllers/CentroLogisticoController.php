<?php
require_once '../config/db.php';
require_once '../models/CentroLogistico.php';

class CentroLogisticoController {
    private $db;
    private $model;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->model = new CentroLogistico($this->db);
    }

    public function listAll() {
        return $this->model->getAllWithCategory();
    }

    public function create($data) {
        $this->model->nombre = $data['nombre'];
        $this->model->id_categoria = $data['id_categoria'];
        $this->model->descripcion = $data['descripcion']; // Nuevo campo
        $this->model->longitud = $data['longitud'];
        $this->model->latitud = $data['latitud'];
        $this->model->horario_operacion = $data['horario_operacion'];
        $this->model->capacidad = $data['capacidad'];
        $this->model->tipos_recursos = $data['tipos_recursos'];
        $this->model->zona_cobertura = $data['zona_cobertura'];
        $this->model->contacto = $data['contacto'];

        return $this->model->create();
    }

    public function update($data) {
        $this->model->id_centro = $data['id_centro'];
        $this->model->nombre = $data['nombre'];
        $this->model->id_categoria = $data['id_categoria'];
        $this->model->descripcion = $data['descripcion']; // Nuevo campo
        $this->model->longitud = $data['longitud'];
        $this->model->latitud = $data['latitud'];
        $this->model->horario_operacion = $data['horario_operacion'];
        $this->model->capacidad = $data['capacidad'];
        $this->model->tipos_recursos = $data['tipos_recursos'];
        $this->model->zona_cobertura = $data['zona_cobertura'];
        $this->model->contacto = $data['contacto'];

        return $this->model->update();
    }

    public function delete($id_centro) {
        $this->model->id_centro = $id_centro;
        return $this->model->delete();
    }
}
?>
