<?php

namespace App\Controller;

use App\Entity\File;
use App\Message\ProcessFile;
use App\Service\Parser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\FileType;


class IndexController extends AbstractController
{
    private $kernel;


    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }


    /**
     * @Route("/", name="index")
     * @throws \Exception
     */
    public function index(MessageBusInterface $messageBus, Request $request, EntityManagerInterface $entityManager)
    {
        $stateMachine = $this->kernel->getContainer()->get('state_machine.file_process');

        $parser = $this->kernel->getContainer()->get(Parser::class);

        $form = $this->createForm(FileType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $file = new File();
            $file->setStatus('pending')
                ->setCreatedAt(new \DateTime());
            $entityManager->persist($file);
            $entityManager->flush();
            $file_data = $form['fileName']->getData();
            $message = new ProcessFile($parser->parsedData($file_data), $file->getId());
            $messageBus->dispatch($message);
        }

        return $this->render('pages/index.html.twig', ['form' => $form->createView(),
            "files"=> $this->showFiles()]);
    }

    public function showFiles(){

        return $this->getDoctrine()->getRepository(File::class)->findAll();
    }
}
