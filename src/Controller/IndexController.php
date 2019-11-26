<?php

namespace App\Controller;

use App\Entity\File;
use App\Message\ProcessFile;
use App\Service\Factory\ParseFactory;
use App\Service\FileHandler;
use Prophecy\Argument;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\FileType;
use Ramsey\Uuid\Uuid;


class IndexController extends AbstractController
{
    private $kernel;
    /**
     * @var ParseFactory
     */
    private $parser;


    public function __construct(KernelInterface $kernel, ParseFactory $parser)
    {
        $this->kernel = $kernel;
        $this->parser = $parser;
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
            $file->setId(Uuid::uuid4()->toString())
                ->setStatus('input');
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
