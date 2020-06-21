<?php

namespace App\Controller\BackOffice;

use App\Entity\Campaigns;
use App\Form\CampaignsType;
use App\Repository\CampaignsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/campaigns")
 */
class CampaignsController extends AbstractController
{
    /**
     * @Route("/", name="campaigns_index", methods={"GET"})
     */
    public function index(CampaignsRepository $campaignsRepository): Response
    {
        return $this->render('campaigns/index.html.twig', [
            'campaigns' => $campaignsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="campaigns_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $campaign = new Campaigns();
        $form = $this->createForm(CampaignsType::class, $campaign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($campaign);
            $entityManager->flush();

            return $this->redirectToRoute('campaigns_index');
        }

        return $this->render('campaigns/new.html.twig', [
            'campaign' => $campaign,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="campaigns_show", methods={"GET"})
     */
    public function show(Campaigns $campaign): Response
    {
        return $this->render('campaigns/show.html.twig', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="campaigns_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Campaigns $campaign): Response
    {
        $form = $this->createForm(CampaignsType::class, $campaign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('campaigns_index');
        }

        return $this->render('campaigns/edit.html.twig', [
            'campaign' => $campaign,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="campaigns_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Campaigns $campaign): Response
    {
        if ($this->isCsrfTokenValid('delete'.$campaign->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($campaign);
            $entityManager->flush();
        }

        return $this->redirectToRoute('campaigns_index');
    }
}
