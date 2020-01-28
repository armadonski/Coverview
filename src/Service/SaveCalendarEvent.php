<?php

namespace App\Service;

use App\Entity\CalendarEvent;
use App\Repository\CalendarEventRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SaveCalendarEvent
{
    private $calendarEventRepository;
    private $validator;

    public function __construct(CalendarEventRepository $calendarEventRepository, ValidatorInterface $validator)
    {
        $this->calendarEventRepository = $calendarEventRepository;
        $this->validator = $validator;
    }

    public function validateAndSaveCalendarEvent(string $username, \DateTime $date, string $eventType): JsonResponse
    {
        $calendarEvent = new CalendarEvent();
        $calendarEvent
            ->setUsername($username)
            ->setEventDate($date)
            ->setEventType($eventType);
        $errors = $this->validator->validate($calendarEvent);
        if (count($errors) > 0) {
            $errorsString = (string)$errors;

            return new JsonResponse($errorsString, Response::HTTP_BAD_REQUEST);
        }
        $this->calendarEventRepository->saveCalendarEvent($calendarEvent);
        return new JsonResponse('Calendar Event created', Response::HTTP_CREATED);

    }
}