<?php

namespace App\Controller;

use App\Controller\Trait\ConnectionHistoryTrait;
use App\Controller\Trait\UserTrait;
use App\Entity\User;
use App\Form\RegisterType;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class RegisterController extends AbstractController
{
    use UserTrait;
    use ConnectionHistoryTrait;

    public function __construct(
        private EntityManagerInterface $em,
        private TokenStorageInterface $tokenStorage,
        private EventDispatcherInterface $eventDispatcher
    ){}

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            if($this->checkForm($user)){ return $this->redirectToRoute('app_register'); }

            // Password
            $plaintextPassword = $user->getPassword();
            $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);

            $user
                ->setUsername(trim($user->getUsername()))
                ->setPassword($hashedPassword)
                ->addConnectionHistory($this->createConnectionHistory($request))
                ->setCreatedAt(new DateTimeImmutable('now', new DateTimeZone('Europe/Paris')));
            $this->em->persist($user);
            $this->em->flush();

            // Authenticate
            $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
            $this->tokenStorage->setToken($token);

            return $this->redirectToRoute('app_home');
        }
        return $this->renderForm('register/index.html.twig', [
            'form' => $form,
        ]);
    }
}
