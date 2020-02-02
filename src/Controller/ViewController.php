<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    /**
     * @Route("/view_popover",name="view_popover",methods={"GET"})
     */
    public function readAllCalendarEventsAction(): Response
    {
        return $this->render('popover.html.twig');
    }


}