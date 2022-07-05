<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vote', name: 'vote_')]
class VoteController extends AbstractController
{
    #[Route('/ajouter/{topicId}', name: 'add', requirements: ['topicId' => '\d+'])]
    public function add(int $topicId): Response
    {
        return $this->render('vote/index.html.twig', [
            'controller_name' => 'VoteController',
        ]);
    }
}
