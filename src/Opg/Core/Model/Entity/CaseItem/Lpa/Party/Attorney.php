<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\RelationshipToDonor;
use Zend\InputFilter\InputFilterInterface;
use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\Company;
use Opg\Common\Model\Entity\Traits\ToArray;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Validator\Callback;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * @ORM\Entity
 *
 * @package Opg Core
 *
 */
class Attorney extends AttorneyAbstract implements  PartyInterface, HasRelationshipToDonor
{
    use ToArray {
        toArray as traitToArray;
    }
    use ExchangeArray;
    use RelationshipToDonor;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     */
    protected $occupation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getLpaPartCSignatureDateString",setter="setLpaPartCSignatureDateString")
     */
    protected $lpaPartCSignatureDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getLpa002SignatureDateString",setter="setLpa002SignatureDateString")
     */
    protected $lpa002SignatureDate;

    /**
     * @ORM\Column(type = "integer", nullable = true)
     * @var int
     * @Type("integer")
     */
    protected $isAttorneyApplyingToRegister = self::OPTION_NOT_SET;

    /**
     * @return string $occupation
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * @param string $occupation
     * @return Attorney
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;
        return $this;
    }

    /**
     * @return void|InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = parent::getInputFilter();

            $factory = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'powerOfAttorneys',
                        'required'   => true,
                        'validators' => array(
                            array(
                                'name'    => 'Callback',
                                'options' => array(
                                    'messages' => array(
                                        //@Todo figure out why the default is_empty message is displaying
                                        Callback::INVALID_VALUE    => 'This person needs an attached case',
                                        Callback::INVALID_CALLBACK => "An error occurred in the validation"
                                    ),
                                    'callback' => function () {
                                            return $this->hasAttachedCase();
                                        }
                                )
                            )
                        )
                    )
                )
            );

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @param bool $exposeClassname
     *
     * @return array
     */
    public function toArray($exposeClassname = TRUE) {
        return $this->traitToArray($exposeClassname);
    }

    /**
     * @param \DateTime $lpa002SignatureDate
     * @return Attorney
     */
    public function setLpa002SignatureDate(\DateTime $lpa002SignatureDate = null)
    {
        if (is_null($lpa002SignatureDate)) {
            $lpa002SignatureDate = new \DateTime();
        }
        $this->lpa002SignatureDate = $lpa002SignatureDate;
        return $this;
    }

    /**
     * @param string $lpa002SignatureDate
     * @return Attorney
     */
    public function setLpa002SignatureDateString($lpa002SignatureDate)
    {
        if (empty($lpa002SignatureDate)) {
            $lpa002SignatureDate = null;
        }
        return $this->setLpa002SignatureDate(new \DateTime($lpa002SignatureDate));
    }

    /**
     * @return \DateTime $lpa002SignatureDate
     */
    public function getLpa002SignatureDate()
    {
        return $this->lpa002SignatureDate;
    }

    /**
     * @return string
     */
    public function getLpa002SignatureDateString()
    {
        if (!empty($this->lpa002SignatureDate)) {
            return $this->lpa002SignatureDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @param \DateTime $lpaPartCSignatureDate
     * @return Attorney
     */
    public function setLpaPartCSignatureDate(\DateTime $lpaPartCSignatureDate = null)
    {
        if (is_null($lpaPartCSignatureDate)) {
            $lpaPartCSignatureDate = new \DateTime();
        }
        $this->lpaPartCSignatureDate = $lpaPartCSignatureDate;
        return $this;
    }

    /**
     * @param string $lpaPartCSignatureDate
     * @return Lpa
     */
    public function setLpaPartCSignatureDateString($lpaPartCSignatureDate)
    {
        if (empty($lpaPartCSignatureDate)) {
            $lpaPartCSignatureDate = null;
        }
        return $this->setLpaPartCSignatureDate(new \DateTime($lpaPartCSignatureDate));
    }

    /**
     * @return \DateTime
     */
    public function getLpaPartCSignatureDate()
    {
        return $this->lpaPartCSignatureDate;
    }

    /**
     * @return string
     */
    public function getLpaPartCSignatureDateString()
    {
        if (!empty($this->lpaPartCSignatureDate)) {
            return $this->lpaPartCSignatureDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @param int $isAttorneyApplyingToRegister
     * @return Attorney
     */
    public function setIsAttorneyApplyingToRegister($isAttorneyApplyingToRegister = self::OPTION_FALSE)
    {
        $this->isAttorneyApplyingToRegister = $isAttorneyApplyingToRegister;
        return $this;
    }

    /**
     * @return int
     */
    public function getIsAttorneyApplyingToRegister()
    {
        return $this->isAttorneyApplyingToRegister;
    }


}
