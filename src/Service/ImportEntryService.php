<?php

namespace App\Service;

use App\Entity\Account;
use App\Entity\Entry;
use Doctrine\ORM\EntityManagerInterface;

class ImportEntryService extends ImportCsvServiceAbstract
{
    /**
     * @var array
     */
    private $entriesList = array();

    /**
     * @var Account
     */
    private $account;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    private $categories;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->categories = $this->entityManager->getRepository('App:Category')->findAll();
    }

    public function setAccount(Account $account)
    {
        $this->account = $account;
    }

    protected function getMinColumnLength(): int
    {
        return 6;
    }

    protected function getDataLine(array $dataLine, int $numLine)
    {
        $entry = new Entry();

        $date = \DateTime::createFromFormat('d/m/y', $dataLine[0]);
        if (!$date){
            $date = \DateTime::createFromFormat('d/m/Y', $dataLine[0]);
        }

        $entry
            ->setDate($date)
            ->setOperationNumber($dataLine[1])
            ->setLabel($dataLine[2])
            ->setAccount($this->account)
            ->setDebit(floatval(str_replace(",",".",$dataLine[3])))
            ->setCredit(floatval(str_replace(",",".",$dataLine[4])))
            ->setDescription($dataLine[5])
            ;

        foreach ($this->categories as $category) {
            if ($category->checkEntryForCategory($entry)){
                $entry->addCategory($category);
            }
        }

        $this->entriesList[$numLine] = $entry;
    }

    protected function recordData()
    {
        foreach($this->entriesList as $entry){
            $this->entityManager->persist($entry);
            $this->entityManager->flush();
        }
    }

    protected function controlDataFile(): bool
    {
        return true; // not control for the moment
    }
}
