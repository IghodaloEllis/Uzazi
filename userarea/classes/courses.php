class Course {
    private $id;
    private $name;
    private $description;
    private $duration;
    private $level;
    private $createdAt;
    private $updatedAt;

    // Constructor
    public function __construct($id, $name, $description, $duration, $level, $createdAt, $updatedAt) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->duration = $duration;
        $this->level = $level;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getLevel() {
        return $this->level;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    // Setters (if needed)
    // ...

    // Other methods (e.g., save, update, delete)
}
