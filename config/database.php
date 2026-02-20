<?php
declare(strict_types=1);

/**
 * Database Singleton Class
 * 
 * Implements the Singleton Design Pattern to manage a shared PDO connection
 * throughout the application lifecycle.
 * 
 * Architecture Benefits:
 * - Resource Management: Prevents multiple expensive connections to MySQL.
 * - Centralized Configuration: Manages credentials in one secure location.
 * - Error Handling: Wraps connection logic in robust try/catch blocks.
 */
class Database {

    private static ?Database $instance = null;
    private ?PDO $connection = null;

    // Database Credentials (Encapsulated)
    private readonly string $host;
    private readonly string $db_name;
    private readonly string $username;
    private readonly string $password;

    /**
     * Private Constructor to prevent direct instantiation.
     */
    private function __construct()
    {
        $host = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?? 'localhost';
        $port = $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?? '3306';
        $name = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?? 'nexus';
        $user = $_ENV['DB_USER'] ?? getenv('DB_USER') ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?? '';

        $this->host = $host;
        $this->db_name = $name;
        $this->username = $user;
        $this->password = $pass;

        try {
            $dsn = "mysql:host={$this->host};port={$port};dbname={$this->db_name};charset=utf8mb4";
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->connection = new PDO($dsn, $this->username, $this->password, $options);

        } catch (PDOException $e) {
            // Log error internally (don't expose sensitive info to user)
            error_log("Database Connection Error: " . $e->getMessage());
            throw new Exception("Critical System Error: Database service unavailable.");
        }
    }

    /**
     * Singleton Accessor
     * 
     * @return Database The single instance of the database wrapper.
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Get the Raw PDO Connection
     * 
     * @return PDO The active database connection.
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Prevent cloning of the instance
     */
    private function __clone() {}

    /**
     * Prevent unserializing of the instance
     */
    public function __wakeup() {}
}