<?php

namespace App\Controller\FrontOffice;

use App\Form\SubscribeType;
use App\Service\Campaigns;
use App\Service\Protocol;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CampaignController extends AbstractController
{
    /**
     * @Route("/campaign/{id}-{name}", name="campaign_detail")
     */
    public function index(Request $request, Campaigns $campaigns, $id)
    {
        $campaign = $campaigns->get($id);

        if (null === $campaign) {
            //return $this->redirectToRoute('homepage', [], 301);
        }

        $form = $this->createForm(SubscribeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }

        return $this->render('fo/campaign/index.html.twig', [
            'campaign' => $campaign,
            'form' => $form->createView(),
        ]);
    }
}
