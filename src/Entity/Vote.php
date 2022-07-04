<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $up;

    #[ORM\Column(type: 'integer')]
    private $down;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUp(): ?int
    {
        return $this->up;
    }

    public function setUp(int $up): self
    {
        $this->up = $up;

        return $this;
    }

    public function getDown(): ?int
    {
        return $this->down;
    }

    public function setDown(int $down): self
    {
        $this->down = $down;

        return $this;
    }
}
