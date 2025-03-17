<?php

namespace App\Entity;

use App\Repository\WorkspaceMembershipRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkspaceMembershipRepository::class)]
class WorkspaceMembership
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?workspace $workspace = null;

    #[ORM\ManyToOne]
    private ?member $member = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorkspace(): ?workspace
    {
        return $this->workspace;
    }

    public function setWorkspace(?workspace $workspace): static
    {
        $this->workspace = $workspace;

        return $this;
    }

    public function getMember(): ?member
    {
        return $this->member;
    }

    public function setMember(?member $member): static
    {
        $this->member = $member;

        return $this;
    }
}
