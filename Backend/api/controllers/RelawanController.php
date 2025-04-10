<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/Relawan.php';

$database = new Database();
$db = $database->getConnection();

$relawan = new Relawan($db);

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $stmt = $relawan->read();
        $num = $stmt->rowCount();

        if($num > 0) {
            $relawan_arr = array();
            $relawan_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $relawan_item = array(
                    "id" => $id,
                    "nama" => $nama,
                    "email" => $email,
                    "no_telp" => $no_telp,
                    "alamat" => $alamat,
                    "keahlian" => $keahlian,
                    "created_at" => $created_at
                );
                array_push($relawan_arr["records"], $relawan_item);
            }
            http_response_code(200);
            echo json_encode($relawan_arr);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Tidak ada relawan ditemukan."));
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if(
            !empty($data->nama) &&
            !empty($data->email) &&
            !empty($data->no_telp) &&
            !empty($data->alamat) &&
            !empty($data->keahlian)
        ) {
            $relawan->nama = $data->nama;
            $relawan->email = $data->email;
            $relawan->no_telp = $data->no_telp;
            $relawan->alamat = $data->alamat;
            $relawan->keahlian = $data->keahlian;

            if($relawan->create()) {
                http_response_code(201);
                echo json_encode(array("message" => "Relawan berhasil ditambahkan."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Tidak dapat menambahkan relawan."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Data tidak lengkap."));
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method tidak diizinkan."));
        break;
}
?> 