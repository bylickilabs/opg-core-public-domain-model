<?php


namespace Opg\Core\Model\Entity\CaseActor;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * @ORM\Entity
 */
class NotifiedAttorney extends Attorney
{
    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Accessor(getter="getEpaNotifiedAttorneyNoticeGivenDateString",setter="setEpaNotifiedAttorneyNoticeGivenDateString")
     * @Type("string")
     * @Groups("api-task-list")
     */
    protected $noticeGivenDate;
    
    /**
     * @param \DateTime $noticeGivenDate
     *
     * @return $this
     */
    public function setEpaNotifiedAttorneyNoticeGivenDate(\DateTime $noticeGivenDate = null)
    {
        if (is_null($noticeGivenDate)) {
            $noticeGivenDate = new \DateTime();
        }
        $this->noticeGivenDate = $noticeGivenDate;

        return $this;
    }

    /**
     * @param string $noticeGivenDate
     *
     * @return Epa
     */
    public function setEpaNotifiedAttorneyNoticeGivenDateString($noticeGivenDate)
    {
        if (!empty($noticeGivenDate)) {
            $noticeGivenDate = OPGDateFormat::createDateTime($noticeGivenDate);
            $this->setEpaNotifiedAttorneyNoticeGivenDate($noticeGivenDate);
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEpaNotifiedAttorneyNoticeGivenDate()
    {
        return $this->noticeGivenDate;
    }

    /**
     * @return string
     */
    public function getEpaNotifiedAttorneyNoticeGivenDateString()
    {
        if (!empty($this->noticeGivenDate)) {
            return $this->noticeGivenDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }
}
