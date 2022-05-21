<?php

namespace Leonidas\Framework\Form;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\Field\FormFieldInterface;
use WebTheory\Saveyour\Controller\Builder\FormFieldControllerBuilder;

trait UsesFormFieldDataTrait
{
    protected function formFields(ServerRequestInterface $request): array
    {
        $fields = $this->fields($request);
        $data = $this->data($request);
        $formatting = $this->formatting($request);

        foreach ($fields as $key => &$field) {
            $controller = (FormFieldControllerBuilder::for($field->getName()))
                ->formField($field)
                ->dataManager($data[$key] ?? null)
                ->formatter($formatting[$key] ?? null)
                ->get();

            $field = $this->getFormFieldData($controller->compose($request));
        }

        return $fields;
    }

    /**
     * @return string|array|FormFieldInterface
     */
    protected function getFormFieldData(FormFieldInterface $field)
    {
        return [
            'id' => $field->getId(),
            'name' => $field->getName(),
            'value' => $field->getValue(),
            'disabled' => $field->isDisabled(),
            'readonly' => $field->isReadOnly(),
            'required' => $field->isRequired(),
        ];
    }

    /**
     * @return array<string,FormFieldInterface>
     */
    abstract protected function fields(ServerRequestInterface $request): array;
}
