<?php

declare(strict_types=1);

namespace ByTIC\Codeception\Page\AbstractTraits;

use ByTIC\Codeception\Helper\AcceptanceTrait;
use Codeception\Actor;

/**
 * Class FormTrait.
 */
trait FormTrait
{
    protected $forms = [];

    protected $formNameDefault = 'default';

    protected $formData = [];

    /**
     * @param null $name
     */
    public function checkForm($name = null)
    {
        $name = $this->initFormName($name);
        $form = $this->forms[$name];

        $this->getTester()->seeElement($form['path']);

        $fields = $form['fields'];
        foreach ($fields as $field => $params) {
            $this->getTester()->seeElement($params['path']);
        }
    }

    /**
     * @param null $name
     *
     * @return string|null
     */
    public function initFormName($name = null)
    {
        return $name ? $name : $this->getFormNameDefault();
    }

    /**
     * @return string
     */
    public function getFormNameDefault()
    {
        return $this->formNameDefault;
    }

    /**
     * @return AcceptanceTrait|Actor;
     */
    abstract protected function getTester();

    /**
     * @param array $params
     * @param null  $name
     */
    public function setFieldsAndsubmitForm($params = [], $name = null)
    {
        $params = array_merge($this->formData, $params);
        foreach ($params as $field => $value) {
            $this->setFieldValue($field, $value);
        }
        $this->submitForm($name);
    }

    /**
     * Sets a form field value based on field type.
     *
     * @param $field
     * @param $value
     *
     * @return mixed
     */
    public function setFieldValue($field, $value)
    {
        $type = $this->getFieldFormType($field);
        switch ($type) {
            case 'select':
                return $this->selectOptionForm($field, $value);
            case 'checkbox':
            case 'checkboxGroup':
                return $this->checkOptionForm($field);
            default:
                return $this->fillFieldForm($field, $value);
        }
    }

    /**
     * @param $field
     * @param null $form
     *
     * @return mixed
     */
    public function getFieldFormType($field, $form = null)
    {
        return $this->getFieldFormParam($field, 'type', $form);
    }

    /**
     * @param $field
     * @param $param
     * @param null $form
     *
     * @return mixed
     */
    public function getFieldFormParam($field, $param, $form = null)
    {
        $form = $this->initFormName($form);

        return $this->forms[$form]['fields'][$field][$param];
    }

    /**
     * @param $field
     * @param $value
     * @param null $form
     *
     * @return mixed|null
     */
    public function selectOptionForm($field, $value, $form = null)
    {
        $form = $this->initFormName($form);
        $path = $this->getFieldFormPath($field, $form);

        return $this->getTester()->selectOption($path, $value);
    }

    /**
     * @param $field
     * @param null $form
     *
     * @return mixed
     */
    public function getFieldFormPath($field, $form = null)
    {
        return $this->getFieldFormParam($field, 'path', $form);
    }

    /**
     * @param $field
     * @param null $form
     *
     * @return mixed|null
     */
    public function checkOptionForm($field, $form = null)
    {
        $form = $this->initFormName($form);
        $path = $this->getFieldFormPath($field, $form);

        return $this->getTester()->checkOption($path);
    }

    /**
     * @param $field
     * @param $value
     * @param null $form
     *
     * @return mixed|null
     */
    public function fillFieldForm($field, $value, $form = null)
    {
        $form = $this->initFormName($form);
        $path = $this->getFieldFormPath($field, $form);

        return $this->getTester()->fillField($path, $value);
    }

    /**
     * @param null  $name
     * @param array $params
     */
    public function submitForm($name = null, $params = [])
    {
        $name = $this->initFormName($name);
        $form = $this->forms[$name];
        $this->getTester()->submitForm($form['path'], $params);
    }

    /**
     * @param $name
     * @param $value
     */
    public function setFieldFormData($name, $value)
    {
        $this->formData[$name] = $value;
    }

    /**
     * @param null $name
     *
     * @return array
     */
    public function getFormData($name = null)
    {
        return $this->formData;
    }

    /**
     * sets a field value from data object.
     *
     * @param $name
     *
     * @return mixed
     */
    public function setFieldFromData($name)
    {
        $value = $this->getFieldFormData($name);

        return $this->setFieldValue($name, $value);
    }

    /**
     * @param $name
     *
     * @return null
     */
    public function getFieldFormData($name)
    {
        return $this->formData[$name] ?? null;
    }

    /**
     * @param $field
     * @param $count
     * @param null $form
     */
    public function selectOptionCountForm($field, $count, $form = null)
    {
        $form = $this->initFormName($form);
        $path = $this->getFieldFormPath($field, $form);

        $option = $this->getTester()->grabTextFrom($path.' option:nth-child('.$count.')');
        $this->selectOptionForm($field, $option);
    }

    /**
     * @param $path
     * @param null $name
     */
    protected function addForm($path, $name = null)
    {
        $name = $this->initFormName($name);
        $this->initForm($name);
        $this->forms[$name]['path'] = $path;
    }

    /**
     * @param null $name
     *
     * @return $this
     */
    protected function initForm($name = null)
    {
        $name = $this->initFormName($name);
        if (!isset($this->forms[$name]) || !is_array($this->forms[$name])) {
            $this->forms[$name] = [
                'path' => 'form',
                'fields' => [],
                'submit' => 'button[type=submit]',
            ];
        }

        return $this;
    }

    /**
     * @param $field
     * @param $params
     * @param null $name
     *
     * @return $this
     */
    protected function addInputForm($field, $params, $name = null)
    {
        return $this->addFieldForm($field, 'input', $params, $name);
    }

    /**
     * @param $field
     * @param $type
     * @param $params
     * @param null $name
     *
     * @return $this
     */
    protected function addFieldForm($field, $type, $params, $name = null)
    {
        $name = $this->initFormName($name);
        $this->initForm($name);

        $params = is_string($params) ? ['path' => $params] : $params;
        $params['type'] = $type;
        $this->forms[$name]['fields'][$field] = $params;

        return $this;
    }

    /**
     * @param $field
     * @param $params
     * @param null $name
     *
     * @return $this
     */
    protected function addSelectForm($field, $params, $name = null)
    {
        return $this->addFieldForm($field, 'select', $params, $name);
    }

    /**
     * @param $field
     * @param $params
     * @param null $name
     *
     * @return $this
     */
    protected function addRadioForm($field, $params, $name = null)
    {
        return $this->addFieldForm($field, 'radio', $params, $name);
    }

    /**
     * @param $field
     * @param $params
     * @param null $name
     *
     * @return $this
     */
    protected function addCheckboxForm($field, $params, $name = null)
    {
        return $this->addFieldForm($field, 'checkbox', $params, $name);
    }

    /**
     * @param $field
     * @param $params
     * @param null $name
     *
     * @return $this
     */
    protected function addCheckboxGroupForm($field, $params, $name = null)
    {
        return $this->addFieldForm($field, 'checkboxGroup', $params, $name);
    }

    /**
     * @param $field
     * @param $params
     * @param null $name
     *
     * @return $this
     */
    protected function addTextareaForm($field, $params, $name = null)
    {
        return $this->addFieldForm($field, 'textarea', $params, $name);
    }
}
