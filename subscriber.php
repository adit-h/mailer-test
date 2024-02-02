<?php
require 'core.php';
require 'db.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;

//RESTful: API
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if ($id === null) {
            // Ambil semua data
            response($pdo->query('SELECT * FROM subscriber')->fetchAll());
        } else {
            // Ambil data dengan $id bersangkutan
            $stmt = $pdo->prepare('SELECT * FROM subscriber WHERE id = :id');
            $stmt->execute(compact('id'));

            response($stmt->fetch());
        }
        break;

    case 'POST':
        //filter input
        $input = parse_input(['email', 'firstname', 'lastname']);

        // Simpan data
        $stmt = $pdo->prepare('INSERT INTO subscriber (email, firstname, lastname) VALUES (:email, :firstname, :lastname)');
        $stmt->execute($input);

        response(['message' => 'Add Success.'], 201);
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
        // Simpan perubahan data
        $stmt = $pdo->prepare('DELETE FROM subscriber WHERE id = :id');
        $stmt->execute(compact('id'));

        response(['message' => 'Delete success'], 200);
        break;

    case 'OPTIONS':
        // Metode HTTP OPTIONS biasa dipakai di cross-site request dan RESTful.
        // Untuk sementara, berikan respon kosong (204 No Content)
        response(null, 204);
        break;

    default:
        response(['message' => 'Method unavailable'], 405);
}