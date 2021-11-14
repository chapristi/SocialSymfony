<?php
namespace App\Services\Friend;


use App\Entity\BFF;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FriendService implements FriendServiceInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct( EntityManagerInterface $entityManager)
    {
        $this -> entityManager = $entityManager;

    }

    /**
     * @param string $token
     * @param User $sender
     *
     * Add new friend
     */
    public function addFriend(string $token, User $sender):?array
    {
        $infos = [];
        $friend = new BFF();
        $receiver = $this->entityManager->getRepository(User::class)->findOneBy(["token" => $token]);
        $isFriend = $this->isFriend($sender, $receiver);

        if (!$isFriend) {

            $friend->setSender($sender);
            $friend->setReceiver($receiver);
            $friend->setToken(Uuid::uuid4());
            $this->entityManager->persist($friend);
            $this->entityManager->flush();
            $infos [] = [
                "message" => "l'utilisateur est bien ajouté en ami",
                "code" => 200,
                "isFriend" => true,
            ];
        } else {
            $this->entityManager->remove($isFriend[0]);
            $this->entityManager->flush();
            $infos [] = [
                "message" => "l'utilisateur est supprimée de vos amis ",
                "code" => 200,
                "isFriend" => false
            ];
        }


        return $infos;






    }

    public function removeFriend()
    {
        // TODO: Implement removeFriend() method.
    }

    public function getFriend()
    {
        // TODO: Implement getFriend() method.
    }

    /**
     * @param User $sender
     * @param User $receiver
     * @return array
     * Its verification to know if friend request twice
     */
    public function isFriend(User $sender, User $receiver):array
    {
        $isFriend = $this -> entityManager -> getRepository(BFF::class)->findIfIsFriend($sender,$receiver);
        return $isFriend;
    }

    public function acceptFriend(string $token)
    {
        $acceptFriend = $this -> entityManager -> getRepository(BFF::class)->findOneBy(["token" => $token]);
        $acceptFriend -> setIsAccepted(1);
        $this -> entityManager -> flush();


    }
}