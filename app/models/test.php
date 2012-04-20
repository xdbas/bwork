<?php

class TestModel extends Bwork_Data_PDO {
    
    public function test() {
        $stmt = $this->db()->prepare('SELECT * FROM `test`');
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
}