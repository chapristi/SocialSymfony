<?php
namespace App\Security;

use App\Entity\VerifMail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;
class UserChecker extends AbstractController implements UserCheckerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }
        $userDetails = $this->entityManager->getRepository(VerifMail::class)->findOneBy(["user" => $user]);
        if (!$user->getIsVerified()) {
            // exception en ca de non verrification du compte
            throw new CustomUserMessageAccountStatusException("compte non actif consultez vos mail pour l'activer avant le {$userDetails -> getCreatedAt()->modify('+ 3 hour') -> format('Y-m-d H:i:s')}");
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

    }
}