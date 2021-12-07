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
     * @var string
     */
    private $label = null;

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

    /**
     * @return string
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return EntryListSearch
     */
    public function setLabel(?string $label): EntryListSearch
    {
        $this->label = $label;
        return $this;
    }
}
