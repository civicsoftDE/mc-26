<?php

namespace App\Entity;

use App\Repository\LiveEventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Attribute as Vich;
#[ORM\Entity(repositoryClass: LiveEventRepository::class)]
#[Vich\Uploadable]
class LiveEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Gedmo\Slug(fields: ['title'])]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $shortDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    #[Gedmo\Timestampable]
    private ?\DateTimeImmutable $updatedAt = null;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'concerts', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    // NOTE: This field and the next one need to be nullable, otherwise the deletion won't work
    //       if you want non-nullable fields, set the "erase_fields" option to false in the mapping config
    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    #[ORM\Column]
    private ?\DateTimeImmutable $startsAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $doorsOpenAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $endsAt = null;

    #[ORM\ManyToOne(inversedBy: 'liveEvents')]
    private ?EventLocation $location = null;

    /**
     * @var Collection<int, SupportAct>
     */
    #[ORM\ManyToMany(targetEntity: SupportAct::class, inversedBy: 'liveEvents')]
    private Collection $supportActs;

    #[ORM\Column]
    private ?bool $hasTickets = null;

    #[ORM\Column]
    private ?bool $isFreeEntry = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $pricePresale = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $priceDoor = null;

    #[ORM\Column]
    private ?bool $isSoldOut = null;

    #[ORM\Column]
    private ?bool $isCanceled = null;

    #[ORM\Column(nullable: true)]
    private ?int $ageLimit = null;

    #[ORM\Column]
    private ?bool $isAgeRestricted = null;

    #[ORM\Column]
    private ?bool $hasVkk = null;

    #[ORM\Column]
    private ?bool $hasAk = null;

    #[ORM\Column(nullable: true)]
    private ?int $ticketAmount = null;

    /**
     * @var Collection<int, LiveEventComment>
     */
    #[ORM\OneToMany(targetEntity: LiveEventComment::class, mappedBy: 'liveEvent')]
    private Collection $liveEventComments;

    /**
     * @var Collection<int, EventPicture>
     */
    #[ORM\OneToMany(targetEntity: EventPicture::class, mappedBy: 'liveEvent')]
    private Collection $eventPictures;

    public function __construct()
    {
        $this->supportActs = new ArrayCollection();
        $this->liveEventComments = new ArrayCollection();
        $this->eventPictures = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getStartsAt()->format('d.m.Y') . " - " . $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartsAt(): ?\DateTimeImmutable
    {
        return $this->startsAt;
    }

    public function setStartsAt(\DateTimeImmutable $startsAt): static
    {
        $this->startsAt = $startsAt;

        return $this;
    }

    public function getDoorsOpenAt(): ?\DateTimeImmutable
    {
        return $this->doorsOpenAt;
    }

    public function setDoorsOpenAt(\DateTimeImmutable $doorsOpenAt): static
    {
        $this->doorsOpenAt = $doorsOpenAt;

        return $this;
    }

    public function getEndsAt(): ?\DateTimeImmutable
    {
        return $this->endsAt;
    }

    public function setEndsAt(?\DateTimeImmutable $endsAt): static
    {
        $this->endsAt = $endsAt;

        return $this;
    }

    public function getLocation(): ?EventLocation
    {
        return $this->location;
    }

    public function setLocation(?EventLocation $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    /**
     * @return Collection<int, SupportAct>
     */
    public function getSupportActs(): Collection
    {
        return $this->supportActs;
    }

    public function addSupportAct(SupportAct $supportAct): static
    {
        if (!$this->supportActs->contains($supportAct)) {
            $this->supportActs->add($supportAct);
        }

        return $this;
    }

    public function removeSupportAct(SupportAct $supportAct): static
    {
        $this->supportActs->removeElement($supportAct);

        return $this;
    }

    public function hasTickets(): ?bool
    {
        return $this->hasTickets;
    }

    public function setHasTickets(bool $hasTickets): static
    {
        $this->hasTickets = $hasTickets;

        return $this;
    }

    public function isFreeEntry(): ?bool
    {
        return $this->isFreeEntry;
    }

    public function setIsFreeEntry(bool $isFreeEntry): static
    {
        $this->isFreeEntry = $isFreeEntry;

        return $this;
    }

    public function getPricePresale(): ?string
    {
        return $this->pricePresale;
    }

    public function setPricePresale(?string $pricePresale): static
    {
        $this->pricePresale = $pricePresale;

        return $this;
    }

    public function getPriceDoor(): ?string
    {
        return $this->priceDoor;
    }

    public function setPriceDoor(?string $priceDoor): static
    {
        $this->priceDoor = $priceDoor;

        return $this;
    }

    public function isSoldOut(): ?bool
    {
        return $this->isSoldOut;
    }

    public function setIsSoldOut(bool $isSoldOut): static
    {
        $this->isSoldOut = $isSoldOut;

        return $this;
    }

    public function isCanceled(): ?bool
    {
        return $this->isCanceled;
    }

    public function setIsCanceled(bool $isCanceled): static
    {
        $this->isCanceled = $isCanceled;

        return $this;
    }

    public function getAgeLimit(): ?int
    {
        return $this->ageLimit;
    }

    public function setAgeLimit(int $ageLimit): static
    {
        $this->ageLimit = $ageLimit;

        return $this;
    }

    public function isAgeRestricted(): ?bool
    {
        return $this->isAgeRestricted;
    }

    public function setIsAgeRestricted(bool $isAgeRestricted): static
    {
        $this->isAgeRestricted = $isAgeRestricted;

        return $this;
    }

    public function hasVkk(): ?bool
    {
        return $this->hasVkk;
    }

    public function setHasVkk(bool $hasVkk): static
    {
        $this->hasVkk = $hasVkk;

        return $this;
    }

    public function hasAk(): ?bool
    {
        return $this->hasAk;
    }

    public function setHasAk(bool $hasAk): static
    {
        $this->hasAk = $hasAk;

        return $this;
    }

    public function getTicketAmount(): ?int
    {
        return $this->ticketAmount;
    }

    public function setTicketAmount(?int $ticketAmount): static
    {
        $this->ticketAmount = $ticketAmount;

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
            $liveEventComment->setLiveEvent($this);
        }

        return $this;
    }

    public function removeLiveEventComment(LiveEventComment $liveEventComment): static
    {
        if ($this->liveEventComments->removeElement($liveEventComment)) {
            // set the owning side to null (unless already changed)
            if ($liveEventComment->getLiveEvent() === $this) {
                $liveEventComment->setLiveEvent(null);
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
            $eventPicture->setLiveEvent($this);
        }

        return $this;
    }

    public function removeEventPicture(EventPicture $eventPicture): static
    {
        if ($this->eventPictures->removeElement($eventPicture)) {
            // set the owning side to null (unless already changed)
            if ($eventPicture->getLiveEvent() === $this) {
                $eventPicture->setLiveEvent(null);
            }
        }

        return $this;
    }
}
