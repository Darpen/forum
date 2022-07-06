<?php

namespace App\Controller;

use App\Controller\Trait\VoteTrait;
use App\Entity\Message;
use App\Entity\Topic;
use App\Form\MessageType;
use App\Repository\TopicRepository;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/message', name: 'message_')]
class MessageController extends AbstractController
{
    use VoteTrait;

    public function __construct(
        private EntityManagerInterface $em,
        private TopicRepository $topicRepository,
    ){}

    #[Route('/creation', name: 'create')]
    public function create(Request $request): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $topic = $this->topicRepository->find($request->request->get('topic'));
            if(is_null($topic)){
                $this->addFlash(
                    'warning',
                    Topic::NOT_FOUND_MESSAGE
                );
                return $this->redirectToRoute('topic_create');
            }
            $message = $form->getData();
            $message
                ->setTopic($topic)
                ->setVote($this->createVote())
                ->setCreatedAt(new DateTimeImmutable('now', new DateTimeZone('Europe/Paris')));
            $this->em->persist($message);
            $this->em->flush();

            return $this->redirectToRoute('topic_show', ['id'=>$topic->getId()]);
        }
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }
}
