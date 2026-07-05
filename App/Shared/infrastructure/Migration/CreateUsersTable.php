<?php  

class CreateUsersTable
{
    public function up(PDO $pdo)
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255),
                email VARCHAR(255) NOT NULL UNIQUE,
                username VARCHAR(100),
                phone VARCHAR(100),
                password VARCHAR(255) NOT NULL,
                user_type_id INT,
                status ENUM('active','inactive') DEFAULT 'active',
                available TINYINT(1) DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }
}