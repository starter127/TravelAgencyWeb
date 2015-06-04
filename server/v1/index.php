<?php

require_once '../include/DBHandler.php';
require '.././libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

//Retorna el JSON del query y el estado de la operación.
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');
    
    echo json_encode($response);
}

//Obtiene las citas en general.
$app->get('/citas', function() {
    $response = array();
    $db = new DBHandler();

    $result = $db->getAppointments();

    while ($appointment = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["idCita"] = $appointment["idCita"];
        $tmp["horaCita"] = $appointment["horaCita"];
        $tmp["diaCita"] = $appointment["diaCita"];
        $tmp["horaSolicitada"] = $appointment["horaSolicitada"];
        $tmp["diaSolicitada"] = $appointment["diaSolicitada"];
        $tmp["cliente"] = $appointment["cliente"];
        $tmp["lugar"] = $appointment["lugar"];
        array_push($response, $tmp);
    }
    echoRespnse(200, $response);
});

//Obtiene todas las enfermedades
$app->get('/enfermedades', function() {
    $response = array();
    $db = new DBHandler();

    $result = $db->getDiseases();

    while ($disease = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["nombre"] = $disease["nombre"];
        $tmp["descripcion"] = $disease["descripcion"];
        array_push($response, $tmp);
    }

    echoRespnse(200, $response);
});

//Obtiene todas las sedes
$app->get('/lugares', function(){
    $response = array();
    $db = new DBHandler();

    $result = $db->getLocations();

    while($location = $result->fetch_assoc()){
        $tmp = array();
        $tmp["idLugar"] = $location["idLugar"];
        $tmp["provincia"] = $location["provincia"];
        array_push($response, $tmp);
    }

    echoRespnse(200, $response);
});

//Obtiene todos los productos
$app->get('/productos', function() {
    $response = array();
    $db = new DBHandler();

    $result = $db->getProducts();

    while ($product = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["idProducto"] = $product["idProducto"];
        $tmp["nombre"] = $product["nombre"];
        $tmp["descripcion"] = $product["descripcion"];
        $tmp["precio"] = $product["precio"];
        $tmp["dosis"] = $product["dosis"];
        $tmp["indicaciones"] = $product["indicaciones"];
        $tmp["contraIndicaciones"] = $product["contraIndicaciones"];
        $tmp["lugar"] = $product["lugar"];
        $tmp["cantidad"] = $product["cantidad"];
        array_push($response, $tmp);
    }

    echoRespnse(200, $response);
});

//Obtiene todos los clientes
$app->get('/usuarios/clientes', function() {
    $response = array();
    $db = new DBHandler();

    $result = $db->getClients();

    while ($client = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["idCliente"] = $client["idCliente"];
        $tmp["nombre"] = $client["nombre"];
        $tmp["correo"] = $client["correo"];
        $tmp["idLugar"] = $client["idLugar"];
        array_push($response, $tmp);
    }

    echoRespnse(200, $response);
});

//Obtiene todas las reservaciones.
$app->get('/reservaciones', function(){
    $response = array();
    $db = new DBHandler();

    $result = $db->getReservations();

    while ($reservation = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["idReservacion_Producto"] = $reservation["idReservacion_Producto"];
        $tmp["producto"] = $reservation["producto"];
        $tmp["cliente"] = $reservation["cliente"];
        $tmp["cantidad"] = $reservation["cantidad"];
        $tmp["hora"] = $reservation["hora"];
        $tmp["dia"] = $reservation["dia"];
        $tmp["lugar"] = $reservation["lugar"];
        array_push($response, $tmp);
    }

    echoRespnse(200, $response);
});

//Obtiene todas las reservaciones de la bitácora.
$app->get('/bitacora/reservaciones', function(){
    $response = array();
    $db = new DBHandler();

    $result = $db->getReservationsLogbook();

    while ($reservation = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["idReservacion_Producto"] = $reservation["idReservacion_Producto"];
        $tmp["producto"] = $reservation["producto"];
        $tmp["cliente"] = $reservation["cliente"];
        $tmp["cantidad"] = $reservation["cantidad"];
        $tmp["hora"] = $reservation["hora"];
        $tmp["dia"] = $reservation["dia"];
        $tmp["lugar"] = $reservation["lugar"];
        $tmp["vendido"] = $reservation["vendido"];
        array_push($response, $tmp);
    }

    echoRespnse(200, $response);
});

//Obtiene todas las citas de la bitácora.
$app->get('/bitacora/citas', function(){
    $response = array();
    $db = new DBHandler();

    $result = $db->getAppointmentsLogbook();

    while ($appointment = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["idCita"] = $appointment["idCita"];
        $tmp["horaCita"] = $appointment["horaCita"];
        $tmp["diaCita"] = $appointment["diaCita"];
        $tmp["horaSolicitada"] = $appointment["horaSolicitada"];
        $tmp["diaSolicitada"] = $appointment["diaSolicitada"];
        $tmp["cliente"] = $appointment["cliente"];
        $tmp["lugar"] = $appointment["lugar"];
        $tmp["realizada"] = $appointment["realizada"];
        array_push($response, $tmp);
    }
    echoRespnse(200, $response);
});

//Obtiene las citas de una persona.
$app->post('/citas/usuario', function() use($app) {
    $response = array();
    $db = new DBHandler();

    $idClient = $app->request()->post('idClient');

    $result = $db->getAppointmentsByIdClient($idClient);

    while ($appointment = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["idCita"] = $appointment["idCita"];
        $tmp["horaCita"] = $appointment["horaCita"];
        $tmp["diaCita"] = $appointment["diaCita"];
        $tmp["horaSolicitada"] = $appointment["horaSolicitada"];
        $tmp["diaSolicitada"] = $appointment["diaSolicitada"];
        $tmp["idCliente"] = $appointment["idCliente"];
        array_push($response, $tmp);
    }

    echoRespnse(200, $response);
});

//Obtiene un cliente por número
$app->post('/usuarios/clientes', function() use($app) {
    $response = array();
    $db = new DBHandler();

    $idClient = $app->request()->post('idClient');

    $result = $db->getClientById($idClient);

    while ($client = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["idCliente"] = $client["idCliente"];
        $tmp["nombre"] = $client["nombre"];
        $tmp["correo"] = $client["correo"];
        $tmp["idLugar"] = $client["idLugar"];
        array_push($response, $tmp);
    }

    echoRespnse(200, $response);
});

//Obtiene todos los productos por lugar
$app->post('/productos/lugar', function() use($app){
    $response = array();
    $db = new DBHandler();

    $location = $app->request()->post('');

    $result = $db->getProductsByLocation();
});

//Obtiene todas las reservaciones de un cliente.
$app->post('/reservaciones/usuario', function() use($app) {
    $response = array();
    $db = new DBHandler();

    $idClient = $app->request()->post('idClient');
    
    $result = $db->getReservationsByClient($idClient);

    while ($reservation = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["idReservacion_Producto"] = $reservation["idReservacion_Producto"];
        $tmp["idProducto"] = $reservation["idProducto"];
        $tmp["idCliente"] = $reservation["idCliente"];
        $tmp["cantidad"] = $reservation["cantidad"];
        $tmp["hora"] = $reservation["hora"];
        $tmp["dia"] = $reservation["dia"];
        array_push($response, $tmp);
    }

    echoRespnse(200, $response);
});

//Inicia sesión de un usuario. //TODO
$app->post('/usuarios/login', function() use($app){
    $response = array();
    $db = new DBHandler();

    $username = $app->request()->post('username');
    $password = $app->request()->post('password');

    $result = $db->login($username, $password);

    while ($login = $result->fetch_assoc()) {
        $tmp = array();
        $tmp["idAdministrador"] = $login["idAdministrador"];
        $tmp["nombre"] = $login["nombre"];
        $tmp["apellido"] = $login["apellido"];
        $tmp["contraseña"] = $login["contraseña"];
        $tmp["principal"] = $login["principal"];
        array_push($response, $tmp);
    }
    echoRespnse(200, $response);
});

//Crea una nueva reservación.
$app->post('/citas/usuario/nueva', function() use($app){
    $response = array();
    $db = new DBHandler();

    $time = $app->request()->post('time');
    $date = $app->request()->post('date');
    $idClient = $app->request()->post('idClient');

    $result = $db->createAppointment($time, $date, $idClient);

    if($result){
        echoRespnse(201, $response);
    }else{
        echoRespnse(304, $response);
    }
});

//Borra una cita por id
$app->post('/citas/usuario/borrar', function() use($app){
    $response = array();
    $db = new DBHandler();

    $idAppointment = $app->request()->post('idAppointment');

    $result = $db->deleteAppointmentById($idAppointment);

    if($result){
        echoRespnse(202, $response);
    }else{
        echoRespnse(304, $response);
    }

});

$app->post('/usuarios/colaborador/nuevo', function() use($app){
    $response = array();
    $db = new DBHandler();

    $idCollaborator = $app->request()->post('idCollaborator');
    $username = $app->request()->post('username');
    $name = $app->request()->post('name');
    $lastName = $app->request()->post('lastName');
    $password = $app->request()->post('password');
    $idLocation = $app->request()->post('idLocation');

    $result = $db->createCollaborator($idCollaborator, $username, $name, $lastName, $password, $idLocation);

    if($result){
        echoRespnse(200, $response);
    }else{
        echoRespnse(201, $response);
    }
});

$app->post('/usuarios/colaborador/actualizar', function() use($app){
    $response = array();
    $db = new DBHandler();

    $name = $app->request()->post('name');
    $lastName = $app->request()->post('lastName');
    $password = $app->request()->post('password');
    $idLocation = $app->request()->post('idLocation');

    $result = $db->updateCollaborator($name, $lastName, $password, $idLocation);

    if($result){
        echoRespnse(200, $response);
    }else{
        echoRespnse(201, $response);
    }
});

$app->post('/usuarios/colaborador/borrar', function() use($app){
    $response = array();
    $db = new DBHandler();

    $idCollaborator = $app->request()->post('idCollaborator');

    $result = $db->deleteCollaborator($idCollaborator);

    if($result){
        echoRespnse(200, $response);
    }else{
        echoRespnse(201, $response);
    }
});

$app->post('/productos/nuevo', function() use($app){
    $response = array();
    $db = new DBHandler();

    $idCollaborator = $app->request()->post('');

    $result = $db->deleteCollaborator($idCollaborator);

    if($result){
        echoRespnse(200, $response);
    }else{
        echoRespnse(201, $response);
    }
});

$app->run();
