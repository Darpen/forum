<?php

namespace App\Controller\Trait;

use App\Entity\Message;
use App\Entity\Topic;
use App\Entity\User;
use App\Entity\UserVote;

/**
 * construct need:
 * - EntityManagerInterface
 */
Trait MessageTrait
{
    public function __construct(
    ){}

    /**
     * @param User|null $user
     * @return bool
     */
    protected function getMessages(?User $user, Topic $topic):array
    {
        $messages = [];
        foreach ($this->messageRepository->findBy(['topic'=>$topic, 'active'=>true], ['created_at'=>'DESC']) as $message) {
            $messages[] = [
                'id' => $message->getId(),
                'vote'=> [
                    'up' => $this->userVoteRepository->count(['message'=>$message, 'action'=>UserVote::UP]),
                    'upChecked' => $this->userVoteRepository->count(['message'=>$message, 'user'=> $user, 'action'=>UserVote::UP]) > 0 ? true : false,
                    'down' => $this->userVoteRepository->count(['message'=>$message, 'action'=>UserVote::DOWN]),
                    'downChecked' => $this->userVoteRepository->count(['message'=>$message, 'user'=> $user, 'action'=>UserVote::DOWN]) > 0 ? true : false,
                ],
                'createdAt' => $message->getCreatedAt(),
                'content' => $message->getContent(),
                'author' => $message->getUser()->getUsername()
            ];
        }
        return $messages;
    }
}