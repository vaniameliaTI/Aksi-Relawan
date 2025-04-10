<?php
class Relawan {
    private $conn;
    private $table_name = "relawan";

    public $id;
    public $nama;
    public $email;
    public $no_telp;
    public $alamat;
    public $keahlian;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                (nama, email, no_telp, alamat, keahlian)
                VALUES
                (:nama, :email, :no_telp, :alamat, :keahlian)";

        $stmt = $this->conn->prepare($query);

        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->no_telp = htmlspecialchars(strip_tags($this->no_telp));
        $this->alamat = htmlspecialchars(strip_tags($this->alamat));
        $this->keahlian = htmlspecialchars(strip_tags($this->keahlian));

        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":no_telp", $this->no_telp);
        $stmt->bindParam(":alamat", $this->alamat);
        $stmt->bindParam(":keahlian", $this->keahlian);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?> 