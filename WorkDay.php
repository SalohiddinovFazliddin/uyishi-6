<?php

require 'DB.php';

class WorkDay{
    const REQUIRED_HOUR_DURATION = 8;

    public $pdo;

    public function __construct (){
        $db = new DB();
        $this->pdo = $db->pdo;
    }
    public function store (
        string $name,
        string $arrived_at,
        string $leaved_at
    ){
        $arrived_at = new DateTime($arrived_at);
        $leaved_at = new DateTime($leaved_at);

        $diff = $arrived_at->diff($leaved_at);
        $hour = $diff->h;
        $minute = $diff->i;
        $total =((self::REQUIRED_HOUR_DURATION * 3600) - (($hour * 3600) + ($minute * 60)));

        $query = "INSERT INTO work_time (name, arrived_at, leaved_at,required_of )
                        VALUES (:name, :arrived_at, :leaved_at, :required_of)";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindPAram(':name', $name);
        $stmt->bindValue(':arrived_at', $arrived_at->format('Y-m-d H:i'));
        $stmt->bindValue(':leaved_at', $leaved_at->format('Y-m-d H:i'));
        $stmt->bindPAram(':required_of', $total);
        $stmt->execute();
        header('Location: index.php');


        

    }
}   