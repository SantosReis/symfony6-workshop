<?php

namespace App\Command;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

#[AsCommand(
    name: 'app:update-stock',
    description: 'Add a short description for your command',
)]
class UpdateStockCommand extends Command
{
    protected string $projectDir;
    public function __construct($projectDir)
    {
        $this->projectDir = $projectDir;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('markup', InputArgument::OPTIONAL, 'Percentage markup', 20)
            ->addArgument('process_date', InputArgument::OPTIONAL, 'Date of process', date_create()->format('Y-m-d'))
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // dd($this->projectDir);
        //Convert csv file content into iterable php
        $inputFile = $this->projectDir . '/public/supplier-inventory-files/2020-09-24.csv';

        $decoder = new Serializer([new ObjectNormalizer], [new CsvEncoder]);
        $rows = $decoder->decode(file_get_contents($inputFile), 'csv');

        dd($rows);

        //Loop over records
        //Update if matching records found in db
        //Create new records if matching records not found in the DB

        // $io = new SymfonyStyle($input, $output);
        // $arg1 = $input->getArgument('arg1');

        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

        // $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        // return Command::SUCCESS;
    }
}
