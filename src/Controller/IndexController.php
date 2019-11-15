<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Map;
use App\Message\ProcessFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\FileType;

class IndexController extends AbstractController
{


    /**
     * @Route("/", name="index")
     * @throws \Exception
     */
    public function index(MessageBusInterface $messageBus, Request $request)
    {

        $form = $this->createForm(FileType::class);

        $form->handleRequest($request);
        $file = new File();
        $map = new Map();
        $map->setFile($file);


        $em = $this->getDoctrine()->getManager();
        $em->persist($map);
        $em->flush();
//        dd($file);

        if($form->isSubmitted() && $form->isValid()){
            $file_data = $form['fileName']->getData();
            $message = new ProcessFile($file_data, $file );
            $messageBus->dispatch($message);
        }

//        $array = $parser->parse($directory.'MOCK_DATA.json');

        return $this->render('pages/index.html.twig', ['form' => $form->createView()]);
    }

    public function messageIndex(MessageBusInterface $messageBus)
    {

        return $this->render('pages/index.html.twig', ['name'=> 'asaaaa']);
    }
}
