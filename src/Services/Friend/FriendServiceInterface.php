<?php
namespace App\Services\Friend;
use App\Entity\User;

interface FriendServiceInterface{

    public function addFriend(string $token, User $sender);
    public function removeFriend();
    public function getFriend();
    public function isFriend(User $sender, User $receiver);
    public function acceptFriend(string $token);
}