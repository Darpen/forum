<?php

namespace App\Controller;

use App\Controller\Trait\MessageTrait;
use App\Controller\Trait\VoteTrait;
use App\Entity\UserVote;
use App\Repository\MessageRepository;
use App\Repository\UserVoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/vote', name: 'vote_')]
class VoteController extends AbstractController
{
    use VoteTrait;
    use MessageTrait;

    public function __construct(
        private MessageRepository $messageRepository,
        private EntityManagerInterface $em,
        private UserVoteRepository $userVoteRepository,
        private Security $security
    )
    {}

    #[Route('/ajouter', name: 'add', methods:["POST"])]
    public function add(Request $request): JsonResponse
    {
        if(!$this->security->isGranted('ROLE_USER')){
            return $this->json(['error'=>true, 'url'=> $this->generateUrl('app_login')]);
        }
        if($data = json_decode($request->getContent())){
            $message = $this->messageRepository->find($data->message);
            if(!is_null($message)){
                $userVote = $this->userVoteRepository->findOneBy(['user'=>$this->getUser(), 'message'=>$message]);
                $vote = $this->getVoteAction($userVote, $data->action);
                if(is_null($vote)){
                    $this->em->remove($userVote);
                }else{
                    if(is_null($userVote)){
                        $userVote = new UserVote();
                        $userVote
                            ->setUser($this->getUser())
                            ->setMessage($message);
                    }
                    $userVote->setAction($vote);
                    $this->em->persist($userVote);
                }
                $this->em->flush();
                $content = $this->renderView('message/show.html.twig',[
                    'messages' => $this->getMessages($this->getUser(), $message->getTopic()) 
                ]);
                return $this->json(['error' => false, 'content' => $content]);
            }
        }
        return $this->json(['error'=>true, 'url'=> $this->generateUrl('app_login')]);
    }
}
