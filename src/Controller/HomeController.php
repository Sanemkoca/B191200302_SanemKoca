<?php

namespace App\Controller;

use App\Entity\Ip;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $em = $managerRegistry->getManager();

        dump($request->server, $request->headers);

        exit;

        $userIp = (string) $request->server->get('REMOTE_ADDR');

        $requestAddIp = new Ip();
        $requestAddIp->setIp($userIp);
        $requestAddIp->setDate(new DateTime());
        $em->persist($requestAddIp);

        // $em->flush();

        return $this->render('home/index.html.twig', [
            'userIp' => $userIp,
        ]);
    }
}
