<?php

namespace App\Controller;

use App\Controller\Trait\CategoryTrait;
use App\Entity\Message;
use App\Entity\Topic;
use App\Form\MessageType;
use App\Form\TopicType;
use App\Repository\CategoryRepository;
use App\Repository\MessageRepository;
use App\Repository\TopicRepository;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sujet', name: 'topic_')]
class TopicController extends AbstractController
{
    use CategoryTrait;
    private $createdAt;

    public function __construct(
        private EntityManagerInterface $em,
        private CategoryRepository $categoryRepository,
        private MessageRepository $messageRepository,
        private TopicRepository $topicRepository
    ){
        $this->createdAt = new DateTimeImmutable('now', new DateTimeZone('Europe/Paris'));
    }

    #[Route('/creation', name: 'create')]
    public function create(Request $request): Response
    {
        $topic = new Topic();
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $this->createCategory($request->request->all()['topic']['category']);
            if(is_null($category)){
                return $this->redirectToRoute('topic_create');
            }
            $topic = $form->getData();
            $topic
                ->setCategory($category)
                ->setCreatedAt($this->createdAt);
            $this->em->persist($topic);
            $this->em->flush();

            return $this->redirectToRoute('topic_show', ['id'=>$topic->getId()]);
        }

        return $this->renderForm('topic/index.html.twig', [
            'form' => $form,
            'categories' => $this->categoryRepository->findBy([],['title'=>'ASC'])
        ]);
    }

    #[Route('/detail/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $topic = $this->topicRepository->find($id);
        if(is_null($topic)){
            $this->addFlash(
                'warning',
                Topic::NOT_FOUND_MESSAGE
            );
            $this->redirectToRoute('topic_create');
        }

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message, [
            'action' => $this->generateUrl('message_create'),
            'method' => 'POST'
        ]);

        return $this->renderForm('topic/show.html.twig', [
            'topic' => $topic,
            'messages' => $this->messageRepository->findBy(['topic'=>$topic],['created_at'=>'DESC']),
            'form' => $form
        ]);
    }
}