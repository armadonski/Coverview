<?php

namespace App\Controller;


use App\Service\SaveCalendarEvent;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CalendarEventController
{
    private $saveCalendarEvent;

    public function __construct(SaveCalendarEvent $saveCalendarEvent)
    {
        $this->saveCalendarEvent = $saveCalendarEvent;
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