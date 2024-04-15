<?php

namespace App\Command;

use App\Entity\StockItem;
use Doctrine\ORM\EntityManagerInterface;
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
    protected $entityManager;
    public function __construct($projectDir, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->projectDir = $projectDir;
        $this->entityManager = $entityManager;
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
        $processDate = $input->getArgument('process_date');

        $markup = ($input->getArgument('markup') / 100) + 1;

        //Convert csv file content into iterable php
        $supplierProducts = $this->getCsvRowsAsArrays($processDate);
        // dd($supplierProducts);

        $stockItemRepo = $this->entityManager->getRepository(StockItem::class);

        $existingCount = 0;
        $newCount = 0;

        //Loop over records
        foreach ($supplierProducts as $supplierProduct){
            
            //Update IF matching records found in DB
            if($existingStockItem = $stockItemRepo->findOneBy(['itemNumber' => $supplierProduct['item_number']])){
                $this->updateStockItem($existingStockItem, $supplierProduct, $markup);

                $existingCount++;
                continue;
            }

            //Create new records if matching records not found in the DB
            $this->createNewStockItem($supplierProduct, $markup);
            $newCount++;
        }

        $this->entityManager->flush();

        $io = new SymfonyStyle($input, $output);
        $io->success("$existingCount existing item have been updated. $newCount items have been added.");

        return Command::SUCCESS;
    }

    public function createNewStockItem($supplierProduct, $markup){
        $newStockItem = new StockItem();
        $newStockItem->setItemNumber($supplierProduct['item_number']);
        $newStockItem->setItemName($supplierProduct['item_name']);
        $newStockItem->setItemDescription($supplierProduct['description']);
        $newStockItem->setSupplierCost($supplierProduct['cost']);
        $newStockItem->setPrice($supplierProduct['cost'] * $markup);
        $this->entityManager->persist($newStockItem);
    }

    public function updateStockItem($existingStockItem, $supplierProduct, $markup)
    {
        // $existingStockItem = new StockItem();
        $existingStockItem->setSupplierCost($supplierProduct['cost']);
        $existingStockItem->setSupplierCost($supplierProduct['cost'] * $markup);
        $this->entityManager->persist($existingStockItem);
    }

    public function getCsvRowsAsArrays($processDate)
    {
        $inputFile = $this->projectDir . '/public/supplier-inventory-files/' . $processDate . '.csv';
        $decoder = new Serializer([new ObjectNormalizer], [new CsvEncoder]);
        return $decoder->decode(file_get_contents($inputFile), 'csv');
    }
}
