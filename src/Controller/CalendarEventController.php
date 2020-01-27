<?php

namespace App\Controller;

use App\Service\CalendarEventMediator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarEventController
{
    /**
     * @return Response
     * @Route("/create")
     */
    public function createAction()
    {
        $arrayData = ['username'=>'gigel','event_type'=>'work from home','date'=>new \DateTime()];
        $data = json_encode($arrayData);

        return new Response($data);
    }
}