<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\User;
use App\Repository\VisitorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index(VisitorRepository $visitorRepository): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $visitors = $visitorRepository->findAll();
        return $this->render('admin/index.html.twig', [
            'visitors' => $visitors
        ]);
    }

    /**
     * @Route("/delete/{id}", name="account_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager) 
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) 
        {
            $session = new Session();
            $session->invalidate();
            $entityManager->remove($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute("home");
    }
}
