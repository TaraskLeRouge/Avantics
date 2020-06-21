<?php

namespace App\Controller\FrontOffice;

use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Service\Protocol;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UnsubscribeType;

class UnsubscribeController extends AbstractController
{
    /**
     * @Route("/unsubscribe/", name="desinscription", methods={"GET", "POST"})
     */
    public function unsubscribe(Request $request)
    {
        $users = new Users();
		$form = $this->createForm(UnsubscribeType::class, $users);
		$form->handleRequest($request);
        $dataToView = [];

		if ($form->isSubmitted() && $form->isValid()) {
		    $em = $this->getDoctrine()->getManager();
		    $formData = $form->getData();
            $UsersRepository = $this->getDoctrine()->getRepository(Users::class);
            $users = $UsersRepository->findOneBy([
                'email' => $formData['email'],
                'birthdate' => $formData['birthdate'],
            ]);

            if (null !== $users) {
                $serviceProtocol = new Protocol();
                $now = new \DateTime('@'.strtotime('now'));
                $users->setUnsubscripeDate($now);
                $users->setUnsubscripeIp($serviceProtocol->getIp());
                $em->flush();
                $dataToView['unsubscribe'] = true;

                return $this->redirectToRoute('homepage');
            }
            else {
                $form->addError(new FormError('email non reconnue'));
            }
		}

		$dataToView['form'] = $form->createView();

        return $this->render('fo/unsubscribe/index.html.twig', $dataToView);
    }
}
