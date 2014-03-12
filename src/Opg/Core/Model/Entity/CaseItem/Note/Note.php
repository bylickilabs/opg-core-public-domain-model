<?php
namespace Opg\Core\Model\Entity\CaseItem\Note;

use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use Opg\Core\Model\Entity\Person\Person;
use Opg\Core\Model\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use \Zend\InputFilter\InputFilter;
use \Zend\InputFilter\Factory as InputFactory;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;

/**
 * @ORM\Entity
 * @ORM\Table(name = "notes")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @package Opg Core
 * @author  Chris Moreton <chris@netsensia.com>
 *
 */
class Note implements EntityInterface, \IteratorAggregate
{
    use \Opg\Common\Model\Entity\Traits\Time;
    use \Opg\Common\Model\Entity\Traits\InputFilter;
    use \Opg\Common\Model\Entity\Traits\IteratorAggregate;
    use ToArray;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true}) @ORM\GeneratedValue(strategy = "AUTO") @ORM\Id
     * @var int $id
     */
    private $id;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true}, nullable = true)
     * @var int $sourceId
     */
    private $sourceId;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string $sourceTable
     */
    private $sourceTable;

    /**
     * @ORM\Column(type = "string", nullable = false)
     * @Type("string")
     * @var string $type
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity = "Opg\Core\Model\Entity\User\User")
     * @var User $user
     */
    private $createdByUser;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string status
     */
    private $status;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string description
     */
    private $description;

    /**
     * @ORM\Column(type = "string", nullable = false)
     * @Type("string")
     * @var string name
     */
    private $name;
    
    /**
     * Non persistable entity, used for validation of create
     * @var CaseItem case
     */
    protected $case;
    
    /**
     * Non persistable entity, used for validation of create
     * @var Person person
     */
    protected $person;

    /**
     * @return Note $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function __construct()
    {
        $this->setCreatedTime(date('Y-m-d H:i:s'));
    }

    /**
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User $createdByUser
     */
    public function getCreatedByUser()
    {
        return $this->createdByUser;
    }

    /**
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $id
     *
     * @return Note
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param User $createdByUser
     *
     * @return Note
     */
    public function setCreatedByUser(User $createdByUser)
    {
        $this->createdByUser = $createdByUser;

        return $this;
    }

    /**
     * @param string $status
     *
     * @return Note
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return Note
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return Note
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param int $sourceId
     *
     * @return Note
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = (int)$sourceId;

        return $this;
    }

    /**
     * @return int
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * @param string $sourceTable
     *
     * @return Note
     */
    public function setSourceTable($sourceTable)
    {
        $this->sourceTable = (string)$sourceTable;

        return $this;
    }

    /**
     * @return string
     */
    public function getSourceTable()
    {
        return $this->sourceTable;
    }

    /**
     * @param \Opg\Core\Model\Entity\CaseItem\CaseItem $case
     */
    public function setCase($case)
    {
        $this->case = $case;
    }

    /**
     * @return \Opg\Core\Model\Entity\CaseItem\CaseItem
     */
    public function getCase()
    {
        return $this->case;
    }

    /**
     * @param \Opg\Core\Model\Entity\Person\Person $person
     */
    public function setPerson($person)
    {
        $this->person = $person;
    }

    /**
     * @return \Opg\Core\Model\Entity\Person\Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param array $data
     *
     * @return Note
     */
    public function exchangeArray(array $data)
    {
        empty($data['id']) ? : $this->setId($data['id']);
        empty($data['type']) ? : $this->setType($data['type']);

        if (!empty($data['user'])) {
            $createdByUser = new User();
            $createdByUser->exchangeArray($data['user']);

            $this->setCreatedByUser($createdByUser);
        }

        empty($data['status']) ? : $this->setStatus($data['status']);
        empty($data['description']) ? : $this->setDescription($data['description']);
        empty($data['name']) ? : $this->setName($data['name']);
        empty($data['createdTime']) ? : $this->setCreatedTime($data['createdTime']);

        return $this;
    }

    /**
     * @throws \Opg\Common\Exception\UnusedException
     * @return InputFilter
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
            
            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'name',
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
                                    'min'      => 1,
                                    'max'      => 1000,
                                )
                            )
                        )
                    )
                )
            );
            
            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'type',
                        'required'   => true,
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name'    => 'InArray',
                                'options' => array(
                                    'haystack' => array(
                                        'Application processing',
                                        'Appointment of new attorney',
                                        'Call',
                                        'Cancellation',
                                        'Confirmation',
                                        'Change of address',
                                        'Court amendment',
                                        'Disclaimer',
                                        'Document capture',
                                        'Email',
                                        'Investigation',
                                        'Imperfect application',
                                        'Letter',
                                        'LPA application received',
                                        'Objections',
                                        'Office copy',
                                        'Registration',
                                        'Rejected application',
                                        'Revocation'
                                    )
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
}
