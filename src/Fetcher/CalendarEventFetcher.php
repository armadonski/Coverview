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

    /**
     * Function that groups an array of associative arrays by some key.
     *
     * @param {String} $key Property to sort by.
     * @param {Array} $data Array that stores multiple associative arrays.
     * @return array
     */
    public function groupBy($key, $data): array
    {
        $result = array();

        foreach ($data as $val) {
            if (array_key_exists($key, $val)) {
                $result[$val[$key]][] = $val;
            } else {
                $result[""][] = $val;
            }
        }

        return $result;
    }

    public function fetchAllCalendarEvents(string $order = 'DESC')
    {
        return $this->em->getRepository(CalendarEvent::class)->getAllCalendarEventsAndUsers();
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

    public function removeCalendarEvent(int $calendarEventId): JsonResponse
    {
        try {
            $calendarEvent = $this->em->getRepository(CalendarEvent::class)->find($calendarEventId);
            $this->em->remove($calendarEvent);
            $this->em->flush();
            return new JsonResponse('Calendar Event removed', Response::HTTP_OK);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $this->logger->error($error);
        }
        return new JsonResponse($error, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}