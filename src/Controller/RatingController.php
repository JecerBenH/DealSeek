<?php

namespace App\Controller;

use App\Entity\Deal;
use App\Entity\Rating;
use App\Entity\User;
use App\Form\RateType;

use App\Repository\RatingRepository;
use Brokoskokoli\StarRatingBundle\Form\StarRatingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/rating")
 * @param Request $request
 * @return Response
 */
class RatingController extends AbstractController
{
    /**
     * @Route("/{id}", name="rating")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function rateIndex(Request $request,int $id): Response
    {
        $user=$this->getUser()->getUsername();
        $rating= new Rating();
        $form = $this->createForm(RateType::class, $rating);
        $form->handleRequest($request);
        $rnb=$this->getDoctrine()->getRepository(Rating::class)->findBy([
            'iddeal'=>$id
        ]);
        $count=count($rnb);
        $deal = $this->getDoctrine()->getRepository(Deal::class)->find($id);
        if ($form->isSubmitted() && $form->isValid()) {
            $rating->setIddeal($id);
            $rating->setIdu($user);
            $em=$this->getDoctrine()->getManager();

            $all=0;
            foreach ($rnb as $itemdeal){
                $all=$all+$itemdeal->getValue();
            }

            $new=$rating->getValue();
            $deal->setRate(($new+$all)/($count+1));
            $em->persist($deal);
            $em->persist($rating);
            $em->flush();

            return $this->redirectToRoute('deal');
        }
        $deal->setRate(round($deal->getRate()));
        return $this->render('rating/index.html.twig', [
            'deal' => $deal,
            'form' => $form->createView(),
            'count'=>$count
        ]);
    }


    /**
     * @Route(name="rating_add")
     * @param int $idd
     * @param int $rate
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function rateAdd( int $idd, int $rate){
        $em = $this->getDoctrine()->getManager();
        $deal=$em->getRepository(Deal::class)->find($idd);
        $nbr=$em->getRepository(Rating::class)->findBy(['idd'=>$idd]);
        $o=count($nbr)+1;
        $newrate=$deal->getRate()+$rate/$o;
        $deal->setRate($newrate);
        $em->persist($deal);
        $em->flush();
        return $this->redirectToRoute('reclam_index');







    }
}
