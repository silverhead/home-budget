<?php

namespace App\Service;

abstract class ImportCsvServiceAbstract
{
    /**
     * @var int
     */
    private int $startLineToRead = 1;

    /**
     * @var int
     */
    private int $nbEndLineToIgnore = 0;

    /**
     * @var array
     */
    protected array $data;

    /**
     * @var array
     */
    protected array $errors = array();

    public function import(string $pathFile): bool
    {
        $importOK = true;
        if (!$this->readFile($pathFile)) {
            $importOK = false;
        }
        if (!$this->controlDataFile()) {
            $importOK = false;
        }
        if ($importOK) {
            $this->recordData();
        }

        return $importOK;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setStartLineToRead(int $startLine = 1)
    {
        $this->startLineToRead = $startLine;
    }

    public function setNbEndLinesToIgnore(int $nbEndLinesToIgnore = 0)
    {
        $this->nbEndLineToIgnore = $nbEndLinesToIgnore;
    }

    private function readFile(string $pathFile): bool
    {
        $readingOk = true;
        try {
            $fp = fopen($pathFile, 'r');
            $numLine = 0;

            $data = array();

            // Complete file reading
            while (($dataLine = fgetcsv($fp, 10000, ";")) !== false) {
                $data[] = $dataLine;
            }

            // check data line
            foreach ($data as $index => $dataLine) {
                $numLine++;

                // Ignore lines before the line that we want read
                if ($numLine < $this->startLineToRead){
                    continue;
                }

                if ($numLine == ((count($data)+1) - $this->nbEndLineToIgnore)){
                    continue;
                }

                if (null === $dataLine || !$dataLine) {
                    continue;
                }

                $num = count($dataLine);
                if ($num < $this->getMinColumnLength()) {
                    $this->addError(array('import.error.min_nb_column_require', $numLine));
                    $readingOk = false;
                    continue;
                }

                $this->data[] = $this->getDataLine($dataLine, $numLine);

            }
            fclose($fp);
        } catch (\Exception $e) {
            throw $e;
        }

        return $readingOk;
    }

    protected function addError($codeMessage)
    {
        $this->errors[] = $codeMessage;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    abstract protected function controlDataFile(): bool;

    abstract protected function getMinColumnLength(): int;

    abstract protected function getDataLine(array $dataLine, int $numLine);

    abstract protected function recordData();

}
