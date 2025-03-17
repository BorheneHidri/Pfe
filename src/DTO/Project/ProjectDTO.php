<?php

namespace App\DTO\Project;

class ProjectDTO
{
    public ?string $name;
    public ?string $description;
    public array $members;

    public function __construct(?string $name = null, ?string $description = null, array $members = [])
    {
        $this->name = $name;
        $this->description = $description;
        $this->members = $members;
    }
}
