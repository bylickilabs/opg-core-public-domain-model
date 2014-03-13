<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\InputFilter;

use Opg\Core\Model\Entity\CaseItem\Lpa\Validator\HowAttorneysAct;
use Opg\Core\Model\Entity\CaseItem\Lpa\Validator\PaymentMethod;
use Opg\Core\Model\Entity\PowerOfAttorney\Validator\Applicants;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class LpaFilter extends InputFilter
{
    /**
     * @var \Zend\InputFilter\Factory
     */
    private $inputFactory;

    public function __construct()
    {
        $this->inputFactory = new InputFactory();

        $this->setValidators();
    }

    private function setValidators()
    {
        $this->setStatusValidator();
        $this->setDonorValidator();
        $this->setCorrespondentValidator();
        $this->setApplicantsValidator();
        $this->setAttorneysValidator();
        $this->setCertificateProvidersValidator();
        $this->setNotifiedPersonsValidator();
        $this->setPaymentMethodValidator();
        $this->setHowAttorneysActValidator();
        $this->setHowReplacementAttorneysActValidator();
        $this->setCaseTypeValidator();
        $this->setCaseSubtypeValidator();
    }

    private function setStatusValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'status',
                    'required'   => true,
                    'filters'    => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    //'Perfect', 'Imperfect', 'Registered'
                    'validators' => array(
                        array(
                            'name'    => 'InArray',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'haystack' => array('Perfect', 'Imperfect', 'Registered'),
                                'strict'   => \Zend\Validator\InArray::COMPARE_STRICT
                            ),
                        )
                    )
                )
            )
        );
    }

    private function setCaseTypeValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'caseType',
                    'required'   => true,
                    'filters'    => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 2,
                                'max'      => 24,
                            ),
                        )
                    )
                )
            )
        );
    }

    private function setCaseSubtypeValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'caseSubtype',
                    'required'   => true,
                    'filters'    => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 2,
                                'max'      => 24,
                            ),
                        )
                    )
                )
            )
        );
    }

    private function setDonorValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'donor',
                    'required'   => true,
                    'validators' => array(
                        array(
                            'name'    => 'NotEmpty'
                        )
                    )
                )
            )
        );
    }

    private function setCorrespondentValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'correspondent',
                    'required'   => false,
                    'validators' => array(
                        array(
                            'name'    => 'IsInstanceOf',
                            'options' => array(
                                'className' => 'Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent',
                            ),
                        )
                    )
                )
            )
        );
    }

    /**
     * @todo re-implement validator, test this logic works
     * @return boolean
     */
    private function setApplicantsValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'applicants',
                    'required'   => false,
                    'validators' => array(
                        new Applicants()
                    )
                )
            )
        );
    }

    /**
     * @return boolean
     */
    private function setAttorneysValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'attorneys',
                    'required'   => false,
                    'validators' => array(
                        array(
                            'name'    => 'IsInstanceOf',
                            'options' => array(
                                'className' => 'Doctrine\Common\Collections\ArrayCollection',
                            ),
                        ),
                    ),
                )
            )
        );
    }


    /**
     * @return boolean
     */
    private function setCertificateProvidersValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'certificateProviders',
                    'required'   => false,
                    'validators' => array(
                        array(
                            'name'    => 'IsInstanceOf',
                            'options' => array(
                                'className' => 'Doctrine\Common\Collections\ArrayCollection',
                            ),
                        )
                    )
                )
            )
        );
    }

    /**
     * @return boolean
     */
    private function setNotifiedPersonsValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'notifiedPersons',
                    'required'   => false,
                    'validators' => array(
                        array(
                            'name'    => 'IsInstanceOf',
                            'options' => array(
                                'className' => 'Doctrine\Common\Collections\ArrayCollection',
                            ),
                        )
                    )
                )
            )
        );
    }

    private function setPaymentMethodValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'paymentMethod',
                    'required'   => false,
                    'filters'    => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        new PaymentMethod(),
                    )
                )
            )
        );
    }

    private function setHowAttorneysActValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'howAttorneysAct',
                    'required'   => false,
                    'filters'    => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        new HowAttorneysAct(),
                    )
                )
            )
        );
    }

    private function setHowReplacementAttorneysActValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'howReplacementAttorneysAct',
                    'required'   => false,
                    'filters'    => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        new HowAttorneysAct(),
                    )
                )
            )
        );
    }
}
