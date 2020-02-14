<?php

namespace App\Service;

use App\Entity\CalendarEvent;
use App\Fetcher\CalendarEventFetcher;
use App\Service\Dto\CalendarEventDataDto;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CalendarEventManager
{
    private $validator;
    private $logger;
    private $em;
    private $calendarEventFetcher;

    public function __construct(ValidatorInterface $validator, LoggerInterface $logger, EntityManagerInterface $em, CalendarEventFetcher $calendarEventFetcher)
    {
        $this->validator = $validator;
        $this->logger = $logger;
        $this->em = $em;
        $this->calendarEventFetcher = $calendarEventFetcher;
    }

    public function formatCalendarEvents()
    {
        $calendarData = new ArrayCollection();
        $calendarEventDto = new CalendarEventDataDto();
        $calendarEvents = $this->calendarEventFetcher->fetchAllCalendarEvents();
        foreach ($calendarEvents as $calendarEvent) {
            $calendarEventDto
                ->setCalendarEventId($calendarEvent['id'])
                ->setEventDateKey($calendarEvent['eventDate']->getTimestamp())
                ->setEventType($calendarEvent['eventType'])
                ->setFullName($calendarEvent['fullName'])
                ->setUserId($calendarEvent['userId']);
            $calendarData->add($calendarEventDto->serialize());
        }
        var_dump($calendarData);
        return;
    }

    public function validateAndSaveCalendarEvent(string $userId, DateTime $date, string $eventType): JsonResponse
    {

        try {
            $calendarEvent = new CalendarEvent();
            return $this->setEntityDataAndValidate($calendarEvent, $userId, $date, $eventType);

        } catch (\Exception $e) {
            $error = $e->getMessage();
            $this->logger->error($error);
        }
        return new JsonResponse($error, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function validateAndUpdateCalendarEvent(int $calendarEventId, string $userId, DateTime $date, string $eventType): JsonResponse
    {
        try {
            $calendarEvent = $this->em->getRepository(CalendarEvent::class)->find($calendarEventId);
            return $this->setEntityDataAndValidate($calendarEvent, $userId, $date, $eventType);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $this->logger->error($error);
        }
        return new JsonResponse($error, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    private function setEntityDataAndValidate(CalendarEvent $calendarEvent, string $userId, DateTime $date, string $eventType): ?JsonResponse
    {
        $calendarEvent
            ->setUserId($userId)
            ->setEventDate($date)
            ->setEventType($eventType);
        $errors = $this->validator->validate($calendarEvent);
        if (count($errors) > 0) {
            $errorsString = (string)$errors;

            return new JsonResponse($errorsString, Response::HTTP_BAD_REQUEST);
        }
        $this->em->persist($calendarEvent);
        $this->em->flush();
        return new JsonResponse('Calendar Event created/updated', Response::HTTP_CREATED);
    }
}