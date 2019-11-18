<?php

namespace App\Controller;

use App\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    /**
     * @Route("/file/{id}", name="file")
     */
    public function index(File $file)
    {
        $collection = $file->getMaps()->getValues();
        $collection = array_map(function ($row){
            return json_encode($row->getContent());
        },$collection);
        return $this->render('file/index.html.twig', compact('collection', 'file'));
    }
}
