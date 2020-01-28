<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CalendarEventViewController extends AbstractController
{
    /**
     * @Route("/",name="index",methods={"GET"})
     */
    public function indexAction(): Response
    {
        return $this->render('index.html.twig');
    }
}