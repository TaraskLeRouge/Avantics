<?php

namespace App\Controller\FrontOffice;

use App\Form\LocaleType;
use App\Form\SubscribeType;
use App\Service\Protocol;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request)
    {
		$form = $this->createForm(SubscribeType::class);
        $formLocale = $this->createForm(LocaleType::class);
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
            'controller_name' => 'HomepageController',
            'form' => $form->createView(),
            'form_locale' => $formLocale->createView()
        ]);
    }
}
