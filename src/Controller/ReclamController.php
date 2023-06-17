<?php

namespace App\Controller;
use App\Entity\User;
use App\Repository\ReclamRepository;

use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Id;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Mixed_;
use phpDocumentor\Reflection\Types\Null_;
use PhpParser\Node\Name;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reclam;
use App\Form\ReclamType;
use App\Form\ReclamUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Authentication\Provider\UserAuthenticationProvider;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Contracts\Translation\TranslatorInterface;


class ReclamController extends AbstractController
{


    /**
     * @Route("/reclam", name="reclam_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */

    public function newReclam(Request $request ,AuthenticationUtils $authenticationUtils,TranslatorInterface $translator ,UserRepository $repository):Response
    {
        $reclamation = new Reclam();

        if ($this->getUser()==null) {
            $form = $this->createForm(ReclamType::class, $reclamation);
            $form->handleRequest($request);

        }else{
            $form = $this->createForm(ReclamUserType::class, $reclamation);
            $form->handleRequest($request);
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($form->isSubmitted() && $form->isValid()) {

            if($this->getUser()==null){
                $m=getdate()['mon'];
                $d=getdate()['mday'];
                $y =getdate()['year'];
                $time=strtotime($y.$m.$d);
                $date=date_create($time);
                $reclamation->setDate($date);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($reclamation);
                $entityManager->flush();
                $msg=$translator->trans('Reclamation successful');
                $this->addFlash('success',$msg);

            }else{
                $m=getdate()['mon'];
                $d=getdate()['mday'];
                $y =getdate()['year'];
                $time=strtotime($y.$m.$d);
                $date=date_create($time);
                $reclamation->setDate($date);
                $entityManager = $this->getDoctrine()->getManager();
                $user=$entityManager->getRepository(User::class)
                    ->findOneBy(['email' => $this->getUser()->getUsername()]);
                $reclamation->setEmail($this->getUser()->getUsername());
                $reclamation->setName($user->getName());
                $reclamation->setPhone($user->getPhone());
                $entityManager->persist($reclamation);
                $entityManager->flush();
                $msg=$translator->trans('Reclamation successful');
                $this->addFlash('success',$msg);
            }


        }
        return $this->render('reclam/index.html.twig', ['form'=>$form->createView(),'last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/myreclam/{id}", name="reclam_del")
     *
     */

    public function deleteReclam(Request $request, Reclam $reclamation):Response{



        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reclamation);
        $entityManager->flush();


        return $this->redirectToRoute('reclam_index');

    }

    /**
     * @Route("/reclam/edit/{id}",name="reclam_edit")
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function upReclam(Reclam $reclam,Request $request):Response{
        $form = $this->createForm(ReclamType::class, $reclam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reclam_index');
        }

        return $this->render('reclam/update.html.twig', [
            'user' => $reclam,
            'form' => $form->createView(),
        ]);
    }







    /**
     * @Route("/myreclam", name="reclam_index", methods={"GET"})
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function myreclamIndex(Request $request,  PaginatorInterface $paginator): Response
    {

        $user=$this->getUser()->getUsername();
        $reclams = $this->getDoctrine()
            ->getRepository(Reclam::class)
            ->findBy(['email' => $user]);
        $reclamnb = $this->getDoctrine()
            ->getRepository(Reclam::class)
            ->findBy(['email' => $user]);
        // Paginate the results of the query
        $reclam= $this->getDoctrine()
            ->getRepository(Reclam::class)
            ->findOneBy(['email' => $user]);
        $reclams = $paginator->paginate(
        // Doctrine Query, not results
            $reclams,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            6
        );
        return $this->render('reclam/show.html.twig', [
            'reclams' => $reclams,
            'reclam'=>$reclam,
            'reclame'=>$reclamnb,
        ]);
    }

    /**
     * @Route("/myreclam/{id}", name="reclam_show", methods={"GET"})
     * @param Reclam $reclam
     * @return Response
     */
    public function myreclamShow(Reclam $reclam): Response
    {

        return $this->render('reclam/my_rec_show.html.twig', [
            'reclam' => $reclam,
        ]);
    }



}
