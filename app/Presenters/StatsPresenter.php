<?php


namespace App\Presenters;


use App\model\facade\member\MemberFacade;
use Nette\Utils\Json;

/**
 * Class StatsPresenter
 * @package App\Presenters
 */
class StatsPresenter extends CommonPresenter
{
    /**
     * @inject
     * @var MemberFacade
     */
    public MemberFacade $memberFacade;

    public function renderDefault() {
        $this->template->rankDataOTO =  $this->memberFacade->getActiveMembersRankData();
        $this->template->facultyDataOTO = $this->memberFacade->getActiveMembersFacultyData();
        $this->template->wgDataOTO = $this->memberFacade->getActiveMembersWorkingGroupData();
        $this->template->genderDataOTO = $this->memberFacade->getActiveMembersGenderData();
    }

}