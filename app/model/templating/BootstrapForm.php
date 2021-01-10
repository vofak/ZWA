<?php


namespace App\model\templating;


use Nette\Application\UI\Form;
use Nette\Forms\Controls\Checkbox;
use Nette\Forms\Controls\TextInput;

/**
 * Class BootstrapForm
 *
 * Extension of class Form that looks better using bootstrap
 *
 * @package App\model\templating
 */
class BootstrapForm extends Form
{
    /**
     * BootstrapForm constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->onRender[] = array($this, 'makeFormLookGood');
    }

    public function makeFormLookGood(Form $form)
    {
        $renderer = $form->getRenderer();
        $renderer->wrappers['controls']['container'] = null;
        $renderer->wrappers['pair']['container'] = 'div class="form-group row"';
        $renderer->wrappers['pair']['.error'] = 'has-danger';
        $renderer->wrappers['control']['container'] = 'div class=col-sm-9';
        $renderer->wrappers['label']['container'] = 'div class="col-sm-3 col-form-label"';
        $renderer->wrappers['control']['description'] = 'span class=form-text';
        $renderer->wrappers['control']['errorcontainer'] = 'span class=form-control-feedback';
        $renderer->wrappers['control']['.error'] = 'is-invalid';

        foreach ($form->getControls() as $control) {
            $type = $control->getOption('type');
            if ($type === 'button') {
                $control->getControlPrototype()->addClass(empty($usedPrimary) ? 'btn btn-primary' : 'btn btn-secondary');
                $usedPrimary = true;

            } elseif (in_array($type, ['text', 'textarea', 'select'], true)) {
                $control->getControlPrototype()->addClass('form-control');

            } elseif ($type === 'file') {
                $control->getControlPrototype()->addClass('form-control-file');

            } elseif (in_array($type, ['checkbox', 'radio'], true)) {
                if ($control instanceof Checkbox) {
                    $control->getLabelPrototype()->addClass('form-check-label');
                } else {
                    $control->getItemLabelPrototype()->addClass('form-check-label');
                }
                $control->getControlPrototype()->addClass('form-check-input');
                $control->getSeparatorPrototype()->setName('div')->addClass('form-check');
            }
        }
    }

    /**
     * Adds date input to the form
     *
     * @param string $name name
     * @param string|null $label label
     * @return TextInput date field
     */
    public function addDate(string $name, string $label = null)
    {
        return $this->addText($name, $label)
            ->setHtmlType("date");
    }

    public function setDefaults($data, bool $erase = false)
    {
        return parent::setDefaults($data, $erase);
    }

}