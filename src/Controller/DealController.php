<?php

namespace App\Controller;

use App\Entity\Deal;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DealController extends AbstractController
{
    /**
     * @Route("/deal", name="deal")
     */
    public function index(): Response
    {
        $deals=$this->getDoctrine()->getRepository(Deal::class)->findAll();
        foreach ($deals as $i){
            $i->setRate(round($i->getRate()));
        }

        return $this->render('deal/index.html.twig', [
            'deals' => $deals,
        ]);
    }
}
