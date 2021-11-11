<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = 0;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\OneToMany(targetEntity=BFF::class, mappedBy="sender")
     */
    private $sender;

    /**
     * @ORM\OneToMany(targetEntity=BFF::class, mappedBy="receiver")
     */
    private $receiver;

    /**
     * @ORM\OneToMany(targetEntity=MessagePrivate::class, mappedBy="sender")
     */
    private $senderMessage;

    /**
     * @ORM\OneToMany(targetEntity=MessagePrivate::class, mappedBy="receiver")
     */
    private $receiverMessage;

    public function __construct()
    {
        $this->sender = new ArrayCollection();
        $this->receiver = new ArrayCollection();
        $this->senderMessage = new ArrayCollection();
        $this->receiverMessage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return Collection|BFF[]
     */
    public function getSender(): Collection
    {
        return $this->sender;
    }

    public function addSender(BFF $sender): self
    {
        if (!$this->sender->contains($sender)) {
            $this->sender[] = $sender;
            $sender->setSender($this);
        }

        return $this;
    }

    public function removeSender(BFF $sender): self
    {
        if ($this->sender->removeElement($sender)) {
            // set the owning side to null (unless already changed)
            if ($sender->getSender() === $this) {
                $sender->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BFF[]
     */
    public function getReceiver(): Collection
    {
        return $this->receiver;
    }

    public function addReceiver(BFF $receiver): self
    {
        if (!$this->receiver->contains($receiver)) {
            $this->receiver[] = $receiver;
            $receiver->setReceiver($this);
        }

        return $this;
    }

    public function removeReceiver(BFF $receiver): self
    {
        if ($this->receiver->removeElement($receiver)) {
            // set the owning side to null (unless already changed)
            if ($receiver->getReceiver() === $this) {
                $receiver->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MessagePrivate[]
     */
    public function getSenderMessage(): Collection
    {
        return $this->senderMessage;
    }

    public function addSenderMessage(MessagePrivate $senderMessage): self
    {
        if (!$this->senderMessage->contains($senderMessage)) {
            $this->senderMessage[] = $senderMessage;
            $senderMessage->setSender($this);
        }

        return $this;
    }

    public function removeSenderMessage(MessagePrivate $senderMessage): self
    {
        if ($this->senderMessage->removeElement($senderMessage)) {
            // set the owning side to null (unless already changed)
            if ($senderMessage->getSender() === $this) {
                $senderMessage->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MessagePrivate[]
     */
    public function getReceiverMessage(): Collection
    {
        return $this->receiverMessage;
    }

    public function addReceiverMessage(MessagePrivate $receiverMessage): self
    {
        if (!$this->receiverMessage->contains($receiverMessage)) {
            $this->receiverMessage[] = $receiverMessage;
            $receiverMessage->setReceiver($this);
        }

        return $this;
    }

    public function removeReceiverMessage(MessagePrivate $receiverMessage): self
    {
        if ($this->receiverMessage->removeElement($receiverMessage)) {
            // set the owning side to null (unless already changed)
            if ($receiverMessage->getReceiver() === $this) {
                $receiverMessage->setReceiver(null);
            }
        }

        return $this;
    }
}
