<?php 
require_once 'app/confic/confic.php';
class Model {
    protected $db;

    public function __construct() {
        // Conectamos una sola vez
        $this->db = new PDO("mysql:host=" . HOST .";dbname=" . DBNAME . ";charset=utf8",USER,PASS);

        // Si querés, activás el deploy automático (opcional)
        // $this->_deploy();
    }

    // private function _deploy() {
    //     // Verifica si hay tablas creadas y las genera si está vacío (opcional)
    //     $query = $this->db->query('SHOW TABLES');
    //     $tables = $query->fetchAll();
    //     if (count($tables) == 0) {
    //         $sql = <<<END
            
    //         END;
    //         $this->db->query($sql);
    //     }
    // }
}

?>