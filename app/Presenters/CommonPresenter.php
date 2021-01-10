<?php

declare(strict_types=1);


namespace App\Presenters;

use Contributte\Translation\Translator;
use Nette\Application\UI\Presenter;

/**
 * Class CommonPresenter
 *
 * Abstract persenter with some common methods for most of my presenters
 *
 * @package App\Presenters
 */
abstract class CommonPresenter extends Presenter
{
    /**
     * @inject
     * @var Translator
     */
    public Translator $translator;

    protected function startup()
    {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect("Login:");
        }
    }

    /**
     * Replaces empty strings with null values
     *
     * @param array $values input array
     * @return array output array
     */
    protected function replaceEmptyWithNull(array $values): array
    {
        $ret = array();
        foreach ($values as $col => $val) {
            if ($val == '') {
                $ret[$col] = null;
            } else {
                $ret[$col] = $val;
            }
        }
        return $ret;
    }
}