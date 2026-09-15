<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column]
    private bool $isVerified = false;

    /**
     * @var Collection<int, LiveEventComment>
     */
    #[ORM\OneToMany(targetEntity: LiveEventComment::class, mappedBy: 'user')]
    private Collection $liveEventComments;

    /**
     * @var Collection<int, EventPicture>
     */
    #[ORM\OneToMany(targetEntity: EventPicture::class, mappedBy: 'publishedBy')]
    private Collection $eventPictures;

    #[ORM\Column]
    private ?bool $hasNewsletter = null;

    public function __construct()
    {
        $this->liveEventComments = new ArrayCollection();
        $this->eventPictures = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->username;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0" . self::class . "\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, LiveEventComment>
     */
    public function getLiveEventComments(): Collection
    {
        return $this->liveEventComments;
    }

    public function addLiveEventComment(LiveEventComment $liveEventComment): static
    {
        if (!$this->liveEventComments->contains($liveEventComment)) {
            $this->liveEventComments->add($liveEventComment);
            $liveEventComment->setUser($this);
        }

        return $this;
    }

    public function removeLiveEventComment(LiveEventComment $liveEventComment): static
    {
        if ($this->liveEventComments->removeElement($liveEventComment)) {
            // set the owning side to null (unless already changed)
            if ($liveEventComment->getUser() === $this) {
                $liveEventComment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EventPicture>
     */
    public function getEventPictures(): Collection
    {
        return $this->eventPictures;
    }

    public function addEventPicture(EventPicture $eventPicture): static
    {
        if (!$this->eventPictures->contains($eventPicture)) {
            $this->eventPictures->add($eventPicture);
            $eventPicture->setPublishedBy($this);
        }

        return $this;
    }

    public function removeEventPicture(EventPicture $eventPicture): static
    {
        if ($this->eventPictures->removeElement($eventPicture)) {
            // set the owning side to null (unless already changed)
            if ($eventPicture->getPublishedBy() === $this) {
                $eventPicture->setPublishedBy(null);
            }
        }

        return $this;
    }

    public function hasNewsletter(): ?bool
    {
        return $this->hasNewsletter;
    }

    public function setHasNewsletter(bool $hasNewsletter): static
    {
        $this->hasNewsletter = $hasNewsletter;

        return $this;
    }
}
