<?php

namespace App\Controller\Trait;

use App\Entity\User;

/**
 * construct need:
 * - EntityManagerInterface
 */
Trait UserTrait
{
    public function __construct(
    ){}

    /**
     * @param User $request
     * @return bool
     */
    protected function checkForm(User $user):bool
    {
        $error = false;
        if(strlen(trim($user->getUsername())) < 6){
            $this->addFlash('warning', User::INCORRECT_USERNAME_LENGTH);
            $error =true;
        }
        if(strlen(trim($user->getPassword())) < 6){
            $this->addFlash('warning', User::INCORRECT_PASSWORD_LENGTH);
            $error =true;
        }
        $email = $user->getEmail();
        if(strlen(trim($email)) > 0 && !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->addFlash('warning', User::INCORRECT_EMAIL);
            $error =true;
        }
        return $error;
    }
}