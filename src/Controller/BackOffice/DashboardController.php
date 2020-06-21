<?php

namespace App\Controller\BackOffice;

use App\Service\Protocol;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SubscribeType;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="bo_dashboard")
     */
    public function index(Request $request)
    {
        return $this->render('bo/dashboard/index.html.twig');
    }
}
