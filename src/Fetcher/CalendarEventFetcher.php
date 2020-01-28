<?php

namespace App\Fetcher;

use App\Entity\CalendarEvent;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CalendarEventFetcher
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    private $logger;

    public function __construct(EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function fetchAllCalendarEvents(string $order = 'DESC'): JsonResponse
    {
        try {
            return new JsonResponse($this->em->getRepository(CalendarEvent::class)->getAllCalendarEvents(), Response::HTTP_OK);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $this->logger->error($error);
        }
        return new JsonResponse($error, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function fetchCalendarEvent(int $calendarEventId): JsonResponse
    {
        try {
            return new JsonResponse($this->em->getRepository(CalendarEvent::class)->find($calendarEventId)->serialize(), Response::HTTP_OK);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $this->logger->error($error);
        }
        return new JsonResponse($error, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}