<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Map;
use App\Message\ProcessFile;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(MessageBusInterface $messageBus, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(FileType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $file = new File();
            $file->setStatus('pending')
                ->setCreatedAt(new \DateTime());
            $entityManager->persist($file);
            $entityManager->flush();
            $fileId = $file->getId();
            $file_data = $form['fileName']->getData();
            $message = new ProcessFile($file_data, $fileId);
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
