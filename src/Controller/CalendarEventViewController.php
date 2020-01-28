<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CalendarEventViewController extends AbstractController
{
    /**
     * @Route("/",name="index",methods={"GET"})
     */
    public function indexAction()
    {
        return $this->render();
    }
}