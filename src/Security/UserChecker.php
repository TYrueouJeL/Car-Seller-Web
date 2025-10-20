<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        // rien ici
    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!\in_array('ROLE_CUSTOMER', $user->getRoles(), true)) {
            throw new CustomUserMessageAuthenticationException('Votre compte n\'est pas autorisé à se connecter.');
        }
    }
}
