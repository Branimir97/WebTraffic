<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\User;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/delete/{id}", name="account_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user) 
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) 
        {
            $this->doctrine->delete($user);
            $this->doctrine->flush();
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->remove($user);
            // $entityManager->flush();
        }
        return $this->redirectToRoute("home");
    }
}
