<?php

class Paciente{

    private int $id;
    private string $nombre;
    private string $apellido;
    private string $fecha_nacimiento;
    private int $telefono;
    private ?string $adulto_responsable;
    private string $motivo_consulta;

        public function __construct
            (int $id, 
            string $nombre, 
            string $apellido, 
            string $fecha_nacimiento, 
            int $telefono, 
            string $motivo_consulta,
            ?string $adulto_responsable = null) 

        {
            
            $this->id = $id;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->fecha_nacimiento = $fecha_nacimiento;
            $this->telefono = $telefono;
            $this->motivo_consulta = $motivo_consulta;
            $this->adulto_responsable = $adulto_responsable;
        }

    // Metodos Gets

        public function getId(): int {
            return $this->id;
        }
        
        public function getNombre(): string {
            return $this->nombre;
        }

        public function getApellido(): string {
            return $this->apellido;
        }

        public function getFecha_nacimiento(): string {
            return $this->fecha_nacimiento;
        }

        public function getTelefono(): int {
            return $this->telefono;
        }

        public function getMotivo_consulta(): string {
            return $this->motivo_consulta;

        }

        public function getAdulto_responsable(): ?string {
            return $this->adulto_responsable;
        }

    //Metodos Sets

        public function setId(int $id): void {
            $this->id = $id;
        }

        public function setNombre(string $nombre): void {
            $this->nombre = $nombre;
        }

        public function setApellido(string $apellido): void {
            $this->apellido = $apellido;
        }

        public function setFecha_nacimiento(string $fecha_nacimiento): void {
            $this->fecha_nacimiento = $fecha_nacimiento;
        }

        public function setTelefono(int $telefono): void {
            $this->telefono = $telefono;
        }

        public function setMotivo_consulta(string $motivo_consulta): void {
            $this->motivo_consulta = $motivo_consulta;
        }
        
        public function setAdulto_responsable(?string $adulto_responsable): void {
            $this->adulto_responsable = $adulto_responsable;
        }

    // Método para calcular edad

        public function calcularEdad(): int {
            $fechaNacimiento = new DateTime($this->fecha_nacimiento);

            $hoy = new DateTime();

            $edad = $hoy->diff($fechaNacimiento)->y;

            return $edad;
        }

    // Método que indica si es menor de edad
        public function esMenorEdad(): bool {

            return $this->calcularEdad() < 18;
        }



    //Mostrar informacion del paciente

        public function mostrarInformacion(): string {
            $info = "ID: " . $this->id . "\n" .
                    "Nombre: " . $this->nombre . "\n" .
                    "Apellido: " . $this->apellido . "\n" .
                    "Fecha de Nacimiento: " . $this->fecha_nacimiento . "\n" .
                    "Teléfono: " . $this->telefono . "\n" .
                    "Motivo de Consulta: " . $this->motivo_consulta . "\n";

            if ($this->adulto_responsable !== null) {
                $info .= "Adulto Responsable: " . $this->adulto_responsable . "\n";
            }
            
            $info .= "Edad: " . $this->calcularEdad() . " años\n";

            if ($this->esMenorEdad() && $this->adulto_responsable === null) {
            $info .= "¡Paciente menor de edad! Se recomienda completar adulto responsable \n";
            }

            return $info;
        }

}

?>