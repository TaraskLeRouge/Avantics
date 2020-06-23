<?php

namespace App\Controller\FrontOffice;

use App\Form\SubscribeType;
use App\Service\Campaigns;
use App\Service\Protocol;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request, Campaigns $campaigns)
    {
        $allCampaignsActiveNow = $campaigns->getAllCampaignsActiveNow();

		$form = $this->createForm(SubscribeType::class);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
		    $em = $this->getDoctrine()->getManager();
		    $subscribe = $form->getData();

		    if (null === $subscribe->getTravel()) {
                $subscribe->setTravel(false);
            }

            if (null === $subscribe->getContestGame()) {
                $subscribe->setContestGame(false);
            }

            if (null === $subscribe->getAutoMoto()) {
                $subscribe->setAutoMoto(false);
            }

            if (null === $subscribe->getShopping()) {
                $subscribe->setShopping(false);
            }

            if (null === $subscribe->getCosmetic()) {
                $subscribe->setCosmetic(false);
            }

            if (null === $subscribe->getInsurance()) {
                $subscribe->setInsurance(false);
            }

            if (null === $subscribe->getMutualHealth()) {
                $subscribe->setMutualHealth(false);
            }

            $serviceProtocol = new Protocol();
		    $now = new \DateTime('@'.strtotime('now'));
		    $subscribe->setOptinDate($now);
		    $subscribe->setOptinip($serviceProtocol->getIp());

		    $em->persist($subscribe);
		    $em->flush();

		    return $this->redirectToRoute('homepage');
		}

        return $this->render('fo/homepage/index.html.twig', [
            'campaigns' => $allCampaignsActiveNow,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/change_locale/{locale}", name="change_locale")
     */
    public function changeLocale($locale, Request $request)
    {
        $request->getSession()->set('_locale', $locale);
        return $this->redirect($request->headers->get('referer'));
    }

}
