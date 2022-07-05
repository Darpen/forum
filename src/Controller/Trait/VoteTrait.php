<?php

namespace App\Controller\Trait;

use App\Entity\Vote;

/**
 * construct need:
 * - EntityManagerInterface
 */
Trait VoteTrait
{
    /**
     * @return Vote
     */
    protected function createVote():Vote
    {
        $vote = new Vote();
        $vote->setUp(0)->setDown(0);
        $this->em->persist($vote);
        return $vote;
    }
}