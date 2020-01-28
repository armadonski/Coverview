<?php

namespace App\Service;

use App\Entity\CalendarEvent;
use App\Repository\CalendarEventRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SaveCalendarEvent
{
    private $validator;
    private $logger;
    private $em;

    public function __construct(ValidatorInterface $validator, LoggerInterface $logger, EntityManagerInterface $em)
    {
        $this->validator = $validator;
        $this->logger = $logger;
        $this->em = $em;
    }

    public function validateAndSaveCalendarEvent(string $username, \DateTime $date, string $eventType): JsonResponse
    {
        try {
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
            $this->em->persist($calendarEvent);
            $this->em->flush();

            return new JsonResponse('Calendar Event created', Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $this->logger->error($error);
        }
        return new JsonResponse($error, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}