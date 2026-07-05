<?php  

namespace App\Shared\Validation;

class Validator
{
    private array $errors = [];

    public function required(string $field, $value): self
    {
        if (empty(trim($value))) {
            $this->errors[$field] = "$field is required";
        }
        return $this;
    }

    public function email(string $field, $value): self
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = "Invalid email format";
        }
        return $this;
    }

    public function min(string $field, $value, int $len): self
    {
        if (strlen($value) < $len) {
            $this->errors[$field] = "$field must be at least $len characters";
        }
        return $this;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }
}