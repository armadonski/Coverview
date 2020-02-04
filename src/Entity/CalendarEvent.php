<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CalendarEventRepository")
 */
class CalendarEvent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="User id be empty")
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="User.php", inversedBy="id")
     */
    private $userId;

    /**
     * @ORM\Column(name="event_type")
     * @Assert\NotBlank(message="Event Type cannot be empty")
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $eventType;

    /**
     * @ORM\Column(name="event_date")
     * @Assert\NotBlank(message="Event Type cannot be empty")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $eventDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(?string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getEventType(): ?string
    {
        return $this->eventType;
    }

    public function setEventType(?string $eventType): self
    {
        $this->eventType = $eventType;

        return $this;
    }

    public function getEventDate(): ?\DateTimeInterface
    {
        return $this->eventDate;
    }

    public function setEventDate(?\DateTimeInterface $eventDate): self
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    public function serialize(): ?array
    {
        return [
            'id' => $this->getId(),
            'userId' => $this->getUserId(),
            'eventDate' => $this->getEventDate(),
            'eventType' => $this->getEventType()
        ];
    }
}
