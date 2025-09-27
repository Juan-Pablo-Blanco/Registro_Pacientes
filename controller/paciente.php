<?php

require_once 'model/paciente.php';


// Controlador Paciente

class PacienteController {

    public $page_title;
    public $view;
    public $con;

    public function __construct($dbConnection) {
        $this->con = $dbConnection;
    }

//listar pacientes

    public function list(){
        $this->page_title = 'Listado de pacientes';
        
        $sql = "SELECT * FROM pacientes";
        $result = $this->con->query($sql);

        $pacientes = [];
        if($result && $result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $pacientes[] = new Paciente(
                    $row['id'],
                    $row['nombre'],
                    $row['apellido'],
                    $row['fecha_nacimiento'],
                    $row['telefono'],
                    $row['motivo_consulta'],
                    $row['adulto_responsable']
                );
            }
        }

        return $pacientes;
    }


//editar paciente

    public function edit($id = null){
        $this->page_title = 'Editar Paciente';
        $this->view = 'edit_paciente';

        if(isset($_GET["id"])) $id = $_GET["id"];

        $stmt = $this->con->prepare("SELECT * FROM pacientes WHERE id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $paciente = new Paciente(
                $row['id'],
                $row['nombre'],
                $row['apellido'],
                $row['fecha_nacimiento'],
                $row['telefono'],
                $row['motivo_consulta'],
                $row['adulto_responsable']
            );
            return $paciente;
        } else {
            return null;
        }
    }

//guardar paciente

    public function save() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null; // si existe, actualizamos
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $telefono = (int)$_POST['telefono'];
        $motivo = $_POST['motivo_consulta'];
        $adulto = $_POST['adulto_responsable'] ?? null;

        if ($id) {
            // Actualizar paciente
            $stmt = $this->con->prepare("UPDATE pacientes SET nombre=?, apellido=?, fecha_nacimiento=?, telefono=?, motivo_consulta=?, adulto_responsable=? WHERE id=?");
            $stmt->bind_param("sssisii", $nombre, $apellido, $fecha_nacimiento, $telefono, $motivo, $adulto, $id);
            $stmt->execute();
        } else {
            // Insertar paciente
            $stmt = $this->con->prepare("INSERT INTO pacientes (nombre, apellido, fecha_nacimiento, telefono, motivo_consulta, adulto_responsable) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssiss", $nombre, $apellido, $fecha_nacimiento, $telefono, $motivo, $adulto);
            $stmt->execute();
            $id = $stmt->insert_id;
        }

        // Obtener paciente actualizado
        return $this->edit($id);
        }
}

//eliminar paciente

    public function delete() {
    $id = $_POST['id'] ?? null;
    if ($id) {
        $stmt = $this->con->prepare("DELETE FROM pacientes WHERE id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
    }
    header("Location: index.php?controller=paciente&action=list");
    exit;
}

//confirmar eliminacion paciente

    public function confirmDelete() {
        $this->page_title = 'Eliminar paciente';
        $this->view = 'confirm_delete_paciente';
        $id = $_GET['id'] ?? null;
        return $this->edit($id);
    }


}

?>