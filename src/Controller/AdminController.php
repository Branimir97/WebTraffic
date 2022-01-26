<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

/**
 * @Route("/admin")
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
     * @Route("/delete", name="account_delete")
     */
    public function delete(Request $request, User $user) 
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) 
        {
            $this->doctrine->remove($user);
            $this->doctrine->flush();
        }
    }
}
