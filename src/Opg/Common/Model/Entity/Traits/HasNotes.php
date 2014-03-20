<?php
namespace Opg\Common\Model\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\Note\Note as NoteEntity;

// Companion trait to the HasNotesInterface
trait HasNotes {

    // Note that this trait does not define "protected $notes;"
    // This is because each class which implements HasNotesInterface requires it's
    // own doctrine annotation to define the join table.
    // You will also need to initialise $notes to be an empty ArrayCollection in your constructor.
    // See the Person or CaseItem objects for examples.


    /**
     * @return ArrayCollection|null
     */
    public function getNotes() {
        return $this->notes;
    }

    /**
     * @param  ArrayCollection $notes
     * @return ArrayCollection|null
     */
    public function setNotes(ArrayCollection $notes) {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @param NoteEntity $note
     * @return $this
     */
    public function addNote(NoteEntity $note) {
        if (is_null($this->notes)) {
            $this->notes = new ArrayCollection();
        }

        if(!$this->notes->contains($note)) {
            $this->notes->add($note);
        }

        return $this;
    }

    /**
     * @param ArrayCollection $notes
     * @return $this
     */
    public function addNotes(ArrayCollection $notes) {
        foreach ($notes as $note) {
            $this->addNote($note);
        }

        return $this;
    }
}
