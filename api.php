<?php

$env = parse_ini_file('.env');

require_once 'core.php';
require_once 'db.php';
require_once 'function.php';
header("Content-Type:application/json");

// Memcached start
$mem = new Memcached();
$mem->addServer('localhost', $env['MC_PORT']);


$id = isset($_GET['id']) ? $_GET['id'] : null;
//RESTful: API
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        if ($id === null) {
            // Get data
            response($pdo->query('SELECT * FROM subscriber')->fetchAll(PDO::FETCH_ASSOC));
        } else {
            // get data with id
            $sData = $mem->get('sub');
            if ($sData) {
                if ($sData['id'] === intval($id)) {
                    response([$sData, 'cache'], 200);
                } else {
                    $res = getDataById($id);
                    response([$res, 'query 1'], 200);
                    $mem->set('sub', $res);
                }
            } else {
                $res = $res = getDataById($id);
                response([$res, 'query 2'], 200);
                $mem->set('sub', $res);
            }
        }
        break;

    case 'POST':
        //filter input
        $input = parse_input(['email', 'firstname', 'lastname']);
        $input['status'] = 1;    // default
        $res = '';

        $mData = $mem->get('data');
        if ($mData) {
            //echo '<h2>Data from Cache:</h2>';
            //print_r($mData);
            if ($mData['email'] === $input['email']) {
                response(['message' => 'Subscriber exists', 'cache' => true], 200);
            } else {
                $res = getDataByEmail($input['email']);
                if ($res) {
                    response(['message' => 'Subscriber exists', 'cache' => false], 200);
                } else {
                    InsertData($input);
                    response(['message' => 'Add Success.'], 201);
                }
            }
        } else {
            // query to check email
            $res = getDataByEmail($input['email']);
            if ($res) {
                response(['message' => 'Subscriber exists', 'cache' => false], 200);
            } else {
                InsertData($input);
                response(['message' => 'Add Success.'], 201);
            }
        }
        // store to mem
        $mem->set('data', ['email' => $input['email']]);
        //response([$input, $mData, $res]);
        break;

    case 'PATCH':
        //filter input
        $input = parse_input(['email', 'firstname', 'lastname']);

        // add id
        $input['id'] = $id;

        $stmt = $pdo->prepare('UPDATE subscriber SET email = :email, firstname = :firstname, lastname = :lastname WHERE id = :id');
        $stmt->execute($input);

        response(['message' => 'Update success'], 200);
        break;

    case 'DELETE':
        // Remove data
        $stmt = $pdo->prepare('DELETE FROM subscriber WHERE id = :id');
        $stmt->execute(compact('id'));

        response(['message' => 'Delete success'], 200);
        break;

    case 'OPTIONS':
        // Metode HTTP OPTIONS can be use on cross-site request dan RESTful.
        // for now,return empty response (204 No Content)
        response(null, 204);
        break;

    default:
        response(['message' => 'Method unavailable'], 405);
}
