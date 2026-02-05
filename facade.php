 
<?php

// Complex subsystem classes

class DatabaseConnection {
    public function connect() {
        echo "Connecting to database...\n";
        return true;
    }
    
    public function disconnect() {
        echo "Disconnecting from database...\n";
    }
}

class Authentication {
    public function login($username, $password) {
        echo "Authenticating user: $username\n";
        // Simulate authentication logic
        return true;
    }
    
    public function validateSession($token) {
        echo "Validating session token: $token\n";
        return true;
    }
}

class Logger {
    public function logInfo($message) {
        echo "[INFO] " . date('Y-m-d H:i:s') . " - $message\n";
    }
    
    public function logError($message) {
        echo "[ERROR] " . date('Y-m-d H:i:s') . " - $message\n";
    }
}

class EmailService {
    public function sendEmail($to, $subject, $body) {
        echo "Sending email to $to\n";
        echo "Subject: $subject\n";
        echo "Body: $body\n";
    }
}

class CacheManager {
    public function get($key) {
        echo "Getting cache for key: $key\n";
        return null;
    }
    
    public function set($key, $value) {
        echo "Setting cache for key: $key\n";
    }
}

// FACADE - Simplifies interaction with all subsystems

class UserManagementFacade {
    private $db;
    private $auth;
    private $logger;
    private $email;
    private $cache;
    
    public function __construct() {
        $this->db = new DatabaseConnection();
        $this->auth = new Authentication();
        $this->logger = new Logger();
        $this->email = new EmailService();
        $this->cache = new CacheManager();
    }
    
    // Simple method that hides complex operations
    public function registerUser($username, $email, $password) {
        echo "\n=== Starting User Registration ===\n";
        
        // Connect to database
        $this->db->connect();
        
        // Log the registration attempt
        $this->logger->logInfo("New user registration attempt: $username");
        
        // Simulate user creation
        echo "Creating user account for: $username\n";
        
        // Send welcome email
        $this->email->sendEmail(
            $email, 
            "Welcome!", 
            "Thank you for registering, $username!"
        );
        
        // Cache user data
        $this->cache->set("user_$username", ['email' => $email]);
        
        // Log success
        $this->logger->logInfo("User registered successfully: $username");
        
        // Disconnect
        $this->db->disconnect();
        
        echo "=== Registration Complete ===\n\n";
    }
    
    public function loginUser($username, $password) {
        echo "\n=== Starting User Login ===\n";
        
        // Connect to database
        $this->db->connect();
        
        // Check cache first
        $cached = $this->cache->get("user_$username");
        
        // Authenticate
        if ($this->auth->login($username, $password)) {
            $this->logger->logInfo("User logged in: $username");
            echo "Login successful!\n";
        } else {
            $this->logger->logError("Failed login attempt: $username");
            echo "Login failed!\n";
        }
        
        // Disconnect
        $this->db->disconnect();
        
        echo "=== Login Complete ===\n\n";
    }
}

// CLIENT CODE - Uses the simple facade instead of complex subsystems

echo "CLIENT: Using the Facade Pattern\n";
echo "=====================================\n";

$userManager = new UserManagementFacade();

// Register a new user - one simple call handles everything
$userManager->registerUser("john_doe", "john@example.com", "secret123");

// Login a user - again, one simple call
$userManager->loginUser("john_doe", "secret123");

echo "\n\nWITHOUT FACADE (what it would look like):\n";
echo "==========================================\n";
echo "// You'd have to manually coordinate all these:\n";
echo "\$db = new DatabaseConnection();\n";
echo "\$db->connect();\n";
echo "\$logger = new Logger();\n";
echo "\$logger->logInfo('Starting registration');\n";
echo "\$email = new EmailService();\n";
echo "\$email->sendEmail(...);\n";
echo "\$cache = new CacheManager();\n";
echo "\$cache->set(...);\n";
echo "// ... and so on\n";

?>