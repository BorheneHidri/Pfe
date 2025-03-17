<?php
namespace App\DTO\Workspace;


class WorkspaceDTO {
    
    public function __construct(
        public string $name,
        public string |null $description
    ){} 
}
