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
     * @Assert\NotBlank(message="Username cannot be empty")
     * @Assert\Length(min="3", minMessage="Username should have at least 3 characters")
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $username;

    /**
     * @Assert\NotBlank(message="Event Type cannot be empty")
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $event_type;

    /**
     * @Assert\NotBlank(message="Event Type cannot be empty")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $event_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEventType(): ?string
    {
        return $this->event_type;
    }

    public function setEventType(?string $event_type): self
    {
        $this->event_type = $event_type;

        return $this;
    }

    public function getEventDate(): ?\DateTimeInterface
    {
        return $this->event_date;
    }

    public function setEventDate(?\DateTimeInterface $event_date): self
    {
        $this->event_date = $event_date;

        return $this;
    }

    public function serialize(): array
    {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'eventDate' => $this->getEventDate(),
            'eventType' => $this->getEventType()
        ];
    }
}
