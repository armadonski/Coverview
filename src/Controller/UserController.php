<?php

namespace App\Controller;

use App\Fetcher\UserFetcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController
{
    private $userFetcher;

    public function __construct(UserFetcher $userFetcher)
    {
        $this->userFetcher = $userFetcher;
    }

    /**
     * @Route("/read_all_users",name="read_all_users",methods={"GET"})
     */
    public function readAllCalendarEventsAction(): JsonResponse
    {
        return $this->userFetcher->fetchAllCalendarEvents();
    }
}