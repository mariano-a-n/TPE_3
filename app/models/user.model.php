<?php
    require_once 'app/models/model.php';
    class UserModel extends Model {

        public function get($id) {
            $query = $this->db->prepare('SELECT * FROM usuarios WHERE id = ?');
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_OBJ);
        }

        public function getByUser($email) {
            $query = $this->db->prepare('SELECT * FROM usuarios WHERE email = ?');
            $query->execute([$email]);
            return $query->fetch(PDO::FETCH_OBJ);
        }

        public function getAll() {
            $query = $this->db->prepare('SELECT * FROM usuarios');
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function insert($email, $password) {
            $query = $this->db->prepare("INSERT INTO usuarios(email, password) VALUES(?, ?)");
            $query->execute([$email, $password]);
            return $this->db->lastInsertId();
        }
    }
?>