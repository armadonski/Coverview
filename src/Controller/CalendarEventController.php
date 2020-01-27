<?php

namespace App\Controller;

use App\Repository\CalendarEventRepository;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarEventController
{
    private $calendarEventRepository;

    public function __construct(CalendarEventRepository $calendarEventRepository)
    {
        $this->calendarEventRepository = $calendarEventRepository;
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
        $this->calendarEventRepository->saveCalendarEvent($username, $date, $eventType);

        return new JsonResponse(['status' => 'Calendar event created'], Response::HTTP_CREATED);
    }
}