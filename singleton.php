<?php
// Singleton class definition
class Singleton {
    // Hold the single instance of the class
    private static ?Singleton $instance = null;

    // Private constructor prevents direct object creation
    private function __construct() {
        // Initialization code here
        echo "Singleton instance created.
";
    }

    // Prevent cloning of the instance
    private function __clone() { }

    // Prevent unserialization of the instance
    private function __wakeup() { }

    // This method returns the single instance of the class
    public static function getInstance(): Singleton {
        if (self::$instance === null) {
            self::$instance = new Singleton();
        }
        return self::$instance;
    }

    // Example method
    public function doSomething() {
        echo "Doing something...
";
    }
}

// Usage example
$instance1 = Singleton::getInstance();
$instance1->doSomething();

$instance2 = Singleton::getInstance();
$instance2->doSomething();

// Verify both instances are the same
if ($instance1 === $instance2) {
    echo "Both instances are identical.
";
} else {
    echo "Instances are different.
";
}
?>