<?php

declare(strict_types=1);


namespace App\Presenters;

use App\model\common\PermissionLevel;
use App\model\dal\metadata\MemberMetadata;
use App\model\facade\member\MemberFacade;
use App\model\templating\BootstrapForm;
use Nette\Application\UI\Form;

/**
 * Class MemberPresenter
 * @package App\Presenters
 */
class MemberPresenter extends CommonPresenter
{
    /**
     * @inject
     * @var MemberFacade
     */
    public MemberFacade $memberFacade;

    public function renderDetail(int $memberId)
    {
        $this->template->memberDetailOTO = $this->memberFacade->getMemberDetail($memberId);
    }

    public function renderList()
    {
        $this->template->memberBrowseViewOTO = $this->memberFacade->getMemberBrowseView();
    }

    /**
     * Form - edit member
     */
    protected function createComponentMemberForm()
    {
        $memberEditFormOTO = $this->memberFacade->getMemberEditForm();

        $form = new BootstrapForm();
        $form->setTranslator($this->translator);

        $form->addGroup('messages.member.basicInfo');

        $form->addHidden(MemberMetadata::$memberId);
        $form->addText(MemberMetadata::$firstName, 'messages.member.name')
            ->setRequired('messages.member.nameRequired');
        $form->addText(MemberMetadata::$lastName, 'messages.member.surname')
            ->setRequired('messages.member.surnameRequired');
        $form->addEmail(MemberMetadata::$email, 'messages.member.email')
            ->setRequired('messages.member.emailRequired');
        $form->addDate(MemberMetadata::$birthday, "messages.member.birthday")
            ->setNullable();


        $form->addRadioList(MemberMetadata::$gender, 'messages.member.gender', $memberEditFormOTO->getGenderOptions())
            ->setRequired('messages.member.genderRequired');

        $form->addDate(MemberMetadata::$joinedDate, "messages.member.joinedDate")
            ->setNullable();

        $permissionLevel = $memberEditFormOTO->getEditSensitivePermissionLevel();
        if ($permissionLevel != PermissionLevel::hidden) {
            $form->addGroup('messages.member.membership');

            $form->addSelect(MemberMetadata::$rankId, 'messages.member.rank', $memberEditFormOTO->getRankOptions())
                ->setDisabled($permissionLevel == PermissionLevel::disabled);
            $form->addSelect(MemberMetadata::$role, 'messages.member.role', $memberEditFormOTO->getRoleOptions())
                ->setDisabled($permissionLevel == PermissionLevel::disabled);

            $form->addSelect(MemberMetadata::$angelId, 'messages.member.angel', $memberEditFormOTO->getAngelOptions())
                ->setDisabled($permissionLevel == PermissionLevel::disabled);
            $form->addSelect(MemberMetadata::$workingGroupId, 'messages.member.workingGroup', $memberEditFormOTO->getWgOptions())
                ->setDisabled($permissionLevel == PermissionLevel::disabled);
        }

        $form->addGroup('messages.member.other');

        $form->addSelect(MemberMetadata::$languageId, 'messages.member.language', $memberEditFormOTO->getLanguageOptions());
        $form->addText(MemberMetadata::$phoneNumber, 'messages.member.phoneNumber')->addFilter(function ($value) {
            $value = str_replace(' ', '', $value);
            if (strlen($value) == 9) {
                $value = "+420" . $value;
            }
            return $value;
        });
        $form->addText(MemberMetadata::$nickname, 'messages.member.nickname')
            ->setNullable();
        $form->addText(MemberMetadata::$shirtSize, 'messages.member.shirtSize')->setNullable();
        $form->addSelect(MemberMetadata::$facultyId, "messages.member.faculty", $memberEditFormOTO->getFacultyOptions());
        $form->addTextArea(MemberMetadata::$facebook, 'messages.member.facebook')
            ->setNullable()
            ->addCondition($form::FILLED)->addRule(Form::URL);
        $form->AddText(MemberMetadata::$trello, "messages.member.trello")
            ->setNullable();

        $form->addSubmit('submit', 'messages.common.submit');

        $form->onValidate[] = [$this, 'validateMemberEditForm'];

        return $form;
    }

    public function validateMemberEditForm($form) {
        $values = $form->getValues();
        if (!$this->memberFacade->isFeasibleEmail(intval($values[MemberMetadata::$memberId]), $values[MemberMetadata::$email]))
        {
            $form->addError("The email is already taken");
        }
    }

    public function handleEditMemberFormSubmit($form, array $values)
    {
        $replacedValues = $this->replaceEmptyWithNull($values);
        $replacedValues[MemberMetadata::$memberId] = intval($replacedValues[MemberMetadata::$memberId]);
        $memberId = $this->memberFacade->updateMember($replacedValues);

        $this->flashMessage($this->translator->translate("messages.common.editSuccess"), 'success');
        $this->redirect('Member:Detail', $memberId);
    }

    public function handleCreateMemberFormSubmit($form, array $values)
    {
        $replacedValues = $this->replaceEmptyWithNull($values);
        $memberId = $this->memberFacade->addMember($replacedValues);

        $this->flashMessage($this->translator->translate("messages.common.createSuccess"), 'success');
        $this->redirect('Member:detail', $memberId);
    }

    public function actionEdit(int $memberId)
    {
        $memberArray = $this->memberFacade->getMemberForForm($memberId);
        $this['memberForm']->setDefaults($memberArray);
        $this['memberForm'][MemberMetadata::$joinedDate]->setDefaultValue($memberArray[MemberMetadata::$joinedDate] ? $memberArray[MemberMetadata::$joinedDate]->format("Y-m-d") : null);
        $this['memberForm'][MemberMetadata::$birthday]->setDefaultValue($memberArray[MemberMetadata::$birthday] ? $memberArray[MemberMetadata::$birthday]->format("Y-m-d") : null);
        $this['memberForm']->onSuccess[] = array($this, 'handleEditMemberFormSubmit');
    }

    public function actionCreate()
    {
        $this['memberForm']->onSuccess[] = array($this, 'handleCreateMemberFormSubmit');
    }

    public function handleDeleteMember(int $memberId)
    {
        $this->memberFacade->deleteMember($memberId);
        $this->flashMessage($this->translator->translate('messages.common.deleteSuccess'), 'success');
        $this->redirect('Member:list');
    }

}