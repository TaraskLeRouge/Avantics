<?php

namespace App\Controller\BackOffice;

use App\Entity\Campaigns;
use App\Form\CampaignsType;
use App\Repository\CampaignsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
        return $this->render('bo/campaigns/index.html.twig', [
            'campaigns' => $campaignsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="campaigns_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $userId = $this->getUser()->getId();
        $campaign = new Campaigns();
        $form = $this->createForm(CampaignsType::class, $campaign);
        $form->handleRequest($request);
        $now = new \DateTime('@'.strtotime('now'));

        if ($form->isSubmitted() && $form->isValid()) {
            $thumbnailImageFilename = $form->get('thumbnailImageFilename')->getData();
            $lanscapeImageFilename = $form->get('lanscapeImageFilename')->getData();
            if ($thumbnailImageFilename && $lanscapeImageFilename) {
                $originalFilenameLanscapeImageFilename = pathinfo($thumbnailImageFilename->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilenameLanscapeImageFilename);
                $newFilenameLanscapeImageFilename = $safeFilename.'-'.uniqid().'.'.$thumbnailImageFilename->guessExtension();

                $originalFilenameThumbnailImageFilename = pathinfo($thumbnailImageFilename->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilenameThumbnailImageFilename);
                $newFilenameThumbnailImageFilename = $safeFilename.'-'.uniqid().'.'.$thumbnailImageFilename->guessExtension();

                try {
                    $lanscapeImageFilename->move(
                        $this->getParameter('campaigns_images_directory'),
                        $newFilenameLanscapeImageFilename
                    );

                    $thumbnailImageFilename->move(
                        $this->getParameter('campaigns_images_directory'),
                        $newFilenameThumbnailImageFilename
                    );
                } catch (FileException $e) {
                    echo 'trace';exit;
                    // ... handle exception if something happens during file upload
                }

                $campaign->setLanscapeImageFilename($newFilenameLanscapeImageFilename);
                $campaign->setThumbnailImageFilename($newFilenameThumbnailImageFilename);
            }
            else {
                echo 'trace';exit;
                // ... handle exception if something happens during file upload
            }

            $campaign->setCreationUserId($userId);
            $campaign->setCreationDate($now);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($campaign);
            $entityManager->flush();

            return $this->redirectToRoute('campaigns_index');
        }

        return $this->render('bo/campaigns/new.html.twig', [
            'campaign' => $campaign,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="campaigns_show", methods={"GET"})
     */
    public function show(Campaigns $campaign): Response
    {
        return $this->render('bo/campaigns/show.html.twig', [
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

        return $this->render('bo/campaigns/edit.html.twig', [
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
