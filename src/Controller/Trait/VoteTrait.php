<?php

namespace App\Controller\Trait;

use App\Entity\UserVote;

/**
 * construct need:
 * - EntityManagerInterface
 */
Trait VoteTrait
{
    /**
     * @return string|null
     */
    protected function getVoteAction(?UserVote $userVote, string $action):?string
    {
        if(is_null($userVote)){
            $vote = $action === 'up' ? UserVote::UP : UserVote::DOWN;
        }elseif($userVote->getAction() === UserVote::UP && $action === 'up'){
            $vote = null;
        }elseif($userVote->getAction() === UserVote::DOWN && $action === 'down'){
            $vote = null;
        }elseif($userVote->getAction() === UserVote::DOWN && $action === 'up'){
            $vote = UserVote::UP;
        }elseif($userVote->getAction() === UserVote::UP && $action === 'down'){
            $vote = UserVote::DOWN;
        }
        return $vote;
    }
}