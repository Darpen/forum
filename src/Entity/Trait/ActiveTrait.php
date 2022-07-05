<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

Trait ActiveTrait
{
    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private $active;

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}