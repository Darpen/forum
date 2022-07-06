<?php

namespace App\Controller;

use App\Controller\Trait\SecurityTrait;
use App\Controller\Trait\UserTrait;
use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/compte', name: 'account_')]
class AccountController extends AbstractController
{
    use SecurityTrait;
    use UserTrait;

    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $em
    ){}

    #[Route('/profil/{id}', name: 'profile', requirements: ['id' => '\d+'])]
    public function account(int $id): Response
    {
        $this->checkAccess($this->getUser());
        $user = $this->userRepository->find($id);
        return $this->render('account/index.html.twig', [
            'user'=>$user
        ]);
    }

    #[Route('/modifier/{id}', name: 'edit', requirements: ['id' => '\d+'])]
    public function edit(Request $request, int $id): Response
    {
        $this->checkAccess($this->getUser(), $id);
        $user = $this->getUser();
        $form = $this->createForm(RegisterType::class, $user)->remove('password');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            if($this->checkForm($user)){ return $this->redirectToRoute('account_edit'); }

            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('account_profile', ['id'=>$user->getId()]);
        }
        return $this->renderForm('account/edit.html.twig', [
            'form' => $form,
        ]);
    }
    
    #[Route('/cloturer/{id}', name: 'close', requirements: ['id' => '\d+'])]
    public function close(int $id): Response
    {
        $this->checkAccess($this->getUser(), $id);
        $user = $this->userRepository->find($id);
        $this->em->remove($user);
        $this->em->flush();

        return $this->redirectToRoute('app_home');
    }
}
