<?php
namespace App\DataTransferObjects;

class CategoryDTO
{
    public function __construct(
        public string $name,
        public ?int $parent_id = null
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            parent_id: $data['parent_id'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'parent_id' => $this->parent_id,
        ];
    }
}
