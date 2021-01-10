<?php

declare(strict_types=1);


namespace App\Presenters;

use App\model\dal\metadata\BoardMetadata;
use App\model\facade\board\BoardFacade;
use App\model\templating\BootstrapForm;
use Nette\Application\BadRequestException;
use Nette\Utils\DateTime;

/**
 * Class BoardPresenter
 * @package App\Presenters
 */
class BoardPresenter extends CommonPresenter
{
    /**
     * @inject
     * @var BoardFacade
     */
    public BoardFacade $boardFacade;

    # DETAIL

    public function actionCurrentDetail()
    {
        $boardId = $this->boardFacade->getCurrentBoardId();
        if (!$boardId) {
            throw new BadRequestException("There is no current board", 404);
        }
        $this->redirect("Board:detail", $boardId);
    }

    public function renderDetail(int $boardId)
    {
        $this->template->boardDetailOTO = $this->boardFacade->getBoardDetail($boardId);
    }

    public function renderList()
    {
        $this->template->boardDetailOTO = $this->boardFacade->getBoardsForView();
    }

    # EDIT

    protected function createComponentBoardForm()
    {
        $boardEditFormOTO = $this->boardFacade->getBoardEditForm();

        $form = new BootstrapForm();
        $form->setTranslator($this->translator);

        $form->addGroup("messages.board.about");
        $form->addHidden(BoardMetadata::$boardId);
        $form->addInteger(BoardMetadata::$number, "messages.board.boardNumber")
            ->setRequired();
        $form->addText(BoardMetadata::$name, "messages.board.name")
            ->setRequired();
        $form->addDate(BoardMetadata::$startDate, "messages.board.startDate")
            ->setRequired();
        $form->addDate(BoardMetadata::$endDate, "messages.board.endDate")
            ->setRequired();

        $form->addGroup("messages.board.positions");
        $positionsContainer = $form->addContainer("boardMembers");
        foreach ($boardEditFormOTO->getBoardPositions() as $boardPositionId => $boardPositionName) {
            $positionsContainer->addSelect(strval($boardPositionId), $boardPositionName, $boardEditFormOTO->getMemberOptions())
                ->setRequired(false);
        }

        $form->addSubmit('submit', 'messages.common.submit');

        $form->onValidate[] = [$this, 'validateMemberEditForm'];

        return $form;
    }

    public function validateMemberEditForm($form) {
        $values = $form->getValues();
        if (!$this->boardFacade->isFeasibleBoardPeriod(intval($values[BoardMetadata::$boardId]), DateTime::createFromFormat('Y-m-d', $values[BoardMetadata::$startDate]), DateTime::createFromFormat('Y-m-d', $values[BoardMetadata::$endDate])))
        {
            $form->addError("There is already a board that collides with the period of the new period");
        }
    }

    public function actionEdit(int $boardId)
    {
        $boardArray = $this->boardFacade->getBoardForForm($boardId);
        $this['boardForm']->setDefaults($boardArray);
        $this['boardForm'][BoardMetadata::$startDate]->setDefaultValue($boardArray[BoardMetadata::$startDate]->format("Y-m-d"));
        $this['boardForm'][BoardMetadata::$endDate]->setDefaultValue($boardArray[BoardMetadata::$endDate]->format("Y-m-d"));
        $this['boardForm']->onSuccess[] = array($this, 'handleEditBoardFormSubmit');
    }

    public function handleEditBoardFormSubmit($form, array $values)
    {
        $replacedValues = $this->replaceEmptyWithNull($values);
        $replacedValues[BoardMetadata::$boardId] = intval($replacedValues[BoardMetadata::$boardId]);
        $boardId = $this->boardFacade->updateBoard($replacedValues);

        $this->flashMessage($this->translator->translate("messages.common.editSuccess"), 'success');
        $this->redirect('Board:detail', $boardId);
    }

    // CREATE
    public function actionCreate()
    {
        $this['boardForm']->onSuccess[] = array($this, 'handleCreateBoardFormSubmit');
    }

    public function handleCreateBoardFormSubmit($form, array $values)
    {
        $replacedValues = $this->replaceEmptyWithNull($values);
        $boardId = $this->boardFacade->addBoard($replacedValues);

        $this->flashMessage($this->translator->translate("messages.common.createSuccess"), 'success');
        $this->redirect('Board:detail', $boardId);
    }

    // SIGNALS

    public function handleDeleteBoard(int $boardId) {
        $this->boardFacade->deleteBoard($boardId);
        $this->flashMessage($this->translator->translate('messages.common.deleteSuccess'), 'success');
        $this->redirect('Board:currentDetail');
    }
}