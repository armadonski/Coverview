<?php

namespace App\Controller;


use App\Fetcher\CalendarEventFetcher;
use App\Service\SaveCalendarEvent;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CalendarEventController
{
    private $saveCalendarEvent;
    private $calendarEventFetcher;

    public function __construct(SaveCalendarEvent $saveCalendarEvent, CalendarEventFetcher $calendarEventFetcher)
    {
        $this->saveCalendarEvent = $saveCalendarEvent;
        $this->calendarEventFetcher = $calendarEventFetcher;
    }

    /**
     * @Route("/read_all",name="read_all_calendar_event",methods={"GET"})
     */
    public function readAllCalendarEventsAction(): JsonResponse
    {
        return $this->calendarEventFetcher->fetchAllCalendarEvents();
    }

    /**
     * @Route("/create",name="create_event",methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function createAction(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $username = $data['username'];
        $date = new \DateTime($data['eventDate']);
        $eventType = $data['eventType'];

        return $this->saveCalendarEvent->validateAndSaveCalendarEvent($username, $date, $eventType);
    }
}