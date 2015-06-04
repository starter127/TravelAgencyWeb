<?php

class DBHandler {

    function __construct() {
        require_once dirname(__FILE__) . '/DBConnection.php';

        $db = new DBConnection();
        $this->_Conn = $db->connect();
    }

    public function getAppointments(){
        $appointments = $this->_Conn->query("SELECT * FROM saludnaturaldb.cita_view");

        $this->_Conn->close();
        return $appointments;
    }

    public function getAppointmentsByIdClient($idClient){
        $sqlQuery = "SELECT * FROM Cita WHERE idCliente = %d";
        $sqlQuery = sprintf($sqlQuery, $idClient);

        $appointments = $this->_Conn->query($sqlQuery);

        $this->_Conn->close();
        return $appointments;
    }

    public function getAppointmentsLogbook(){
        $appointments = $this->_Conn->query("SELECT * FROM saludnaturaldb.bitacora_cita_view;");

        $this->_Conn->close();
        return $appointments;
    }

    public function getDiseases(){
        $diseases = $this->_Conn->query("SELECT * FROM Enfermedad");

        $this->_Conn->close();
        return $diseases;
    }

    public function getDiseaseByName($name){
        $sqlQuery = "SELECT * FROM Enfermedad WHERE nombre = %s";
        $sqlQuery = sprintf($sqlQuery, $name);

        $diseases = $this->_Conn->query($sqlQuery);

        $this->_Conn->close();
        return $diseases;
    }

    public function getProducts(){
        $products = $this->_Conn->query("SELECT * FROM saludnaturaldb.producto_view;");
        
        $this->_Conn->close();
        return $products;
    }

    public function getReservations(){
        $reservations = $this->_Conn->query("SELECT * FROM saludnaturaldb.reservacion_producto_view;");

        $this->_Conn->close();
        return $reservations;
    }

    public function getReservationsLogbook(){
        $reservations = $this->_Conn->query("SELECT * FROM saludnaturaldb.bitacora_reservacion_view;");

        $this->_Conn->close();
        return $reservations;
    }

    public function getReservationsByClient($idClient){
        $sqlQuery = "SELECT * FROM Reservacion_Producto WHERE idCliente = %d";
        $sqlQuery = sprintf($sqlQuery, $idClient);

        $reservations = $this->_Conn->query($sqlQuery);
        
        $this->_Conn->close();
        return $reservations;
    }

    public function getClients(){
        $clients = $this->_Conn->query("SELECT * FROM Cliente");

        $this->_Conn->close();
        return $clients;
    }

    public function getClientById($idClient){
        $sqlQuery = "SELECT * FROM Cliente WHERE idCliente = %d";
        $sqlQuery = sprintf($sqlQuery, $idClient);

        $client = $this->_Conn->query($sqlQuery);
        
        $this->_Conn->close();
        return $client;
    }

    //TODO EN CASO QUE NO AGREGUE NADA.
    public function createAppointment($time, $date, $idClient){
        $sqlQuery = "call sp_cita_INSERT(%s, %s, %d)";
        $sqlQuery = sprintf($sqlQuery, $time, $date, $idClient);

        if($this->_Conn->query($sqlQuery) == TRUE){
            $this->_Conn->close();
            return TRUE;
        } else{
            $this->_Conn->close();
            return FALSE;
        }
    }

    public function login($username, $password){
        $sqlQuery = "SELECT * FROM saludnaturaldb.login_view WHERE idAdministrador = %d AND contraseña = %s;";
        $sqlQuery = sprintf($sqlQuery, $username, $password);

        $user = $this->_Conn->query($sqlQuery);

        $this->_Conn->close();
        return $user;
    }

    //TODO EN CASO QUE NO BORRE NADA.
    public function deleteAppointmentById($idSchedule){
        $sqlQuery = "call sp_cita_DELETE(%d)";
        $sqlQuery = sprintf($sqlQuery, $idSchedule);

        if($this->_Conn->query($sqlQuery) == TRUE){
            $this->_Conn->close();
            return TRUE;
        } else{
            $this->_Conn->close();
            return FALSE;
        }
    }

    public function getLocations(){
        $locations = $this->_Conn->query("SELECT idLugar, provincia FROM saludnaturaldb.Lugar");

        $this->_Conn->close();
        return $locations;
    }

    public function createCollaborator($idCollaborator, $username, $name, $lastName, $password, $idLocation){
        $sqlQuery = "call sp_colaborador_INSERT(%s, %s, %s, %s, %s, %d);";
        $sqlQuery = sprintf($sqlQuery, $idCollaborator, $username, $name, $lastName, $password, $idLocation);

        $collaborator = $this->_Conn->query($sqlQuery);

        $this->_Conn->close();
        return $collaborator;
    }

    public function updateCollaborator($name, $lastName, $password, $idLocation){
        $sqlQuery = "call sp_colaborador_UPDATE(%s, %s, %s, %d);";
        $sqlQuery = sprintf($sqlQuery, $name, $lastName, $password, $idLocation);

        $collaborator = $this->_Conn->query($sqlQuery);

        $this->_Conn->close();
        return $collaborator;
    }

    public function deleteCollaborator($idCollaborator){
        $sqlQuery = "call sp_colaborador_DELETE(%s);";
        $sqlQuery = sprintf($sqlQuery, $idCollaborator);

        $collaborator = $this->_Conn->query($sqlQuery);

        $this->_Conn->close();
        return $collaborator;
    }

    private $_Conn;
}
