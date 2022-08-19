<?php

namespace App\Controller;

use App\Entity\Ip;
use App\Repository\IpRepository;
use DateTime;
use DateTimeZone;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $em = $managerRegistry->getManager();

        $userIp = (string)$request->server->get('REMOTE_ADDR');

        $requestAddIp = new Ip();
        $requestAddIp->setIp($userIp);
        $requestAddIp->setDate(new DateTime());
        $em->persist($requestAddIp);

        // $em->flush();

        return $this->render('home/index.html.twig', [
            'userIp' => $userIp,
        ]);
    }

    /**
     * @Route("/ip-list", name="app_ip_list")
     */
    public function list(IpRepository $ipRepository): JsonResponse
    {
        try {
            throw new Exception('test');
            $ips = $ipRepository->findBy([], ['id' => 'DESC']);

            $ipList = array_map(function (Ip $ip) {
                /** @var DateTime $date */
                $date = $ip->getDate();

                return [
                    'ip' => $ip->getIp(),
                    'date' => $date->setTimezone(new DateTimeZone('Europe/Istanbul'))->format('d.m.Y H:i:s'),
                ];
            }, $ips);

            return $this->json(['status' => true, 'message' => 'OK', 'ip_list' => $ipList], Response::HTTP_OK);
        } catch (Exception $e) {
            $statusCode = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

            return $this->json(['status' => false, 'message' => $e->getMessage()], $statusCode);
        }
    }
}
