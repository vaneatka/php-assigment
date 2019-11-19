<?php

namespace App\Command;

use App\Service\FileHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\KernelInterface;

class ProcessFileCommand extends Command
{
    protected static $defaultName = 'app:process-file';

    private  $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription('File Process Command')
            ->addArgument('arg1', InputArgument::REQUIRED, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $handler = $this->kernel->getContainer()->get(FileHandler::class);
        $fileUrl = __DIR__.'/../../features/data/MOCK_DATA.json';
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if (file_exists($arg1)) {
            $file = new File($arg1);
            $handler->handle($file);

        } else {
            $io->error('Wrong file path');
        }

        return 0;
    }
}
