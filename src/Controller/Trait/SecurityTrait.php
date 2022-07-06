<?php

namespace App\Controller\Trait;

use App\Entity\User;

Trait SecurityTrait
{
    /**
     * @param User|null $user
     * @param int|null $id
     */
    protected function checkAccess(?User $user = null, ?int $id = null)
    {
        if(!$this->isGranted('ROLE_USER')){
            return $this->redirectToRoute('app_login');
        }
        if(!is_null($user) && !is_null($id)){
            $user = $this->userRepository->find($id);
            // Si l'utilisateur essaie de fermer un autre compte et que ce n'est pas un admin
            if($this->getUser() != $user && !$this->isGranted('ROLE_ADMIN')){
                return $this->redirectToRoute('home');
            }
        }
    }
}