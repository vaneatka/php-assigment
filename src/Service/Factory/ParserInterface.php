<?php


namespace App\Service\Factory;


use Symfony\Component\HttpFoundation\File\File;

interface ParserInterface
{
    public function decode(FIle $contents): array;

    public function support(string $extension): bool;
}