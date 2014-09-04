<?php


namespace Opg\Core\Model\Entity\CaseActor;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseItem\CaseItemInterface;
use Opg\Core\Model\Entity\Person\Person as BasePerson;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ReadOnly;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * Class NoneCaseContact
 * @package Opg\Core\Model\Entity\CaseActor
 */
class NonCaseContact extends BasePerson
{
    use ToArray;

    /**
     * @var ArrayCollection
     * @ReadOnly
     * @Exclude
     */
    protected $powerOfAttorneys = null;

    /**
     * @var ArrayCollection
     * @ReadOnly
     * @Exclude
     */
    protected $deputyships = null;

    public function __construct()
    {
        parent::__construct();
        $this->powerOfAttorneys = null;
        $this->deputyships = null;
    }

    /**
     * @param ArrayCollection $cases
     * @return \Opg\Core\Model\Entity\CaseItem\Lpa\Party\PartyInterface|void
     * @throws \LogicException
     */
    public function setCases(ArrayCollection $cases)
    {
        throw new \LogicException('Non case contacts cannot have cases assigned to them');
    }

    /**
     * @param CaseItemInterface $case
     * @return BasePerson|void
     * @throws \LogicException
     */
    public function addCase(CaseItemInterface $case)
    {
        throw new \LogicException('Non case contacts cannot have cases assigned to them');
    }

    /**
     * @return array|null
     */
    public function getCases()
    {
        return null;
    }
}
