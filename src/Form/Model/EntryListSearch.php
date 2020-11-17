<?php

namespace App\Form\Model;

class EntryListSearch
{
    /**
     * @var \DateTime
     */
    private $dateStart = null;

    /**
     * @var \DateTime
     */
    private $dateEnd = null;

    /**
     * @return \DateTime
     */
    public function getDateStart(): \DateTime
    {
        return $this->dateStart;
    }

    /**
     * @param \DateTime $dateStart
     * @return EntryListSearch
     */
    public function setDateStart(\DateTime $dateStart): EntryListSearch
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd(): \DateTime
    {
        return $this->dateEnd;
    }

    /**
     * @param \DateTime $dateEnd
     * @return EntryListSearch
     */
    public function setDateEnd(\DateTime $dateEnd): EntryListSearch
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }
}
