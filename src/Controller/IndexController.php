<?php

namespace App\Controller;

use App\Entity\File;
use App\Service\FileHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
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
    public function index(Request $request)
    {
        $fileHandler = $this->kernel->getContainer()->get(FileHandler::class);
        $form = $this->createForm(FileType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $file = new File();
            $file->setStatus('input');
            $fileData = $form['fileName']->getData();
            $fileHandler->handle($fileData, $file);
        }

        return $this->render(
            'pages/index.html.twig',
            [
                'form' => $form->createView(),
                "files"=> $this->getDoctrine()->getRepository(File::class)->findAll(),
            ]);
    }

}
