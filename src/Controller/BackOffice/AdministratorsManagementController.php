<?php

namespace App\Controller\BackOffice;

use App\Entity\Administrators;
use App\Form\AdministratorsType;
use App\Repository\AdministratorsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/**
 * @Route("/administators-management")
 */
class AdministratorsManagementController extends AbstractController
{
    /**
     * @Route("/", name="bo_administators-management_index", methods={"GET"})
     */
    public function index(AdministratorsRepository $adminRepository): Response
    {
        return $this->render('bo/administrators-management/index.html.twig', [
            'admins' => $adminRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="bo_administators-management_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $admin = new Administrators();
        $form = $this->createForm(AdministratorsType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $admin->setPassword(
                $encoder->encodePassword(
                    $admin,
                    $form->get('password')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($admin);
            $entityManager->flush();

            return $this->redirectToRoute('bo_administators-management_index');
        }

        return $this->render('bo/administrators-management/new.html.twig', [
            'admin' => $admin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bo_administators-management_show", methods={"GET"})
     */
    public function show(Administrators $admin): Response
    {
        return $this->render('bo/administrators-management/show.html.twig', [
            'admin' => $admin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bo_administators-management_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Administrators $admin, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(AdministratorsType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $admin->setPassword(
                $encoder->encodePassword(
                    $admin,
                    $form->get('password')->getData()
                )
            );

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bo_administators-management_index');
        }

        return $this->render('bo/administrators-management/edit.html.twig', [
            'admin' => $admin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bo_administators-management_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Administrators $admin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$admin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($admin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bo_administators-management_index_index');
    }
}
