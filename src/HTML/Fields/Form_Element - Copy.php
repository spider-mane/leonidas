<?php

/**
 *
 */

// namespace Backalley\Form;

final class Form_Element extends HTML_Element
{
    public $type;

    /**
     *
     */
    // public function __construct(mixed $element_type_or_element_data, $element_array)
    // {
    //     // $this->parse_args($element);
    // }

    /**
     * 
     */
    public function parse_args($element, $element_data = null)// : array
    {
        $this->form_element = $element['form_element'];

        $this->{$this->form_element}($element);
    }

    /**
     *
     */
    public function input($element)
    {
        // code here
    }

    /**
     *
     */
    public function select($element)
    {
        // code here
    }

    /**
     *
     */
    public function textarea($element)
    {
        // code here
    }

    /**
     *
     */
    public function checklist($element)
    {
        $elements = [
            'container' => [
                'tag' => 'div',
                'children' => 'ul'
            ],
            'ul' => [
                'tag' => 'ul',
                'children' => 'items'
            ],
            'items' => [
                'li' => [
                    'tag' => 'li',
                    'children' => ['checkbox', 'label'],
                    'instances' => []
                ],
                'checkbox' => [
                    'tag' => 'input',
                    'instances' => []
                ],
                'label' => [
                    'tag' => 'label',
                    'instances' => []
                ]
            ],
            // 'title' => [
            //     'tag' => 'span',
            // ]
        ];

        foreach ($elements as $el => &$values) {

            if (array_key_exists('attributes', $element[$el])) {
                $values['attributes'] = $this->parse_attributes($element[$el]['attributes']);
            }
        }


        foreach ($element['items'] as $item) {

            $checkbox_instances = &$elements['items']['checkbox']['instances'];
            $li_instances = &$elements['items']['li']['instances'];
            $label_instances = &$elements['items']['label']['instances'];

            $checkbox_attributes = array_merge($item['attributes'] ?? [], ['type' => 'checklist']);
            $li_attributes = $item['li']['attributes'] ?? [];
            $label_attributes = $item['label']['attributes'] ?? [];

            $checkbox_instances[] = [
                'attributes' => $this->parse_attributes($checkbox_attributes),
            ];

            $li_instances[] = [
                'attributes' => $this->parse_attributes($li_attributes),
            ];

            $label_instances[] = [
                'content' => $item['label']['content'],
                'attributes' => $this->parse_attributes($label_attributes),
            ];
        }

        // var_dump($elements);

        $node = $this->construct_element($elements);

        exit;
    }

    /**
     * 
     */
    public function radiolist($element)
    {
        // code here
    }

    /**
     * 
     */
    public function wp_terms_checklist($element)
    {
        // code here
    }

    /**
     * 
     */
    public function wp_terms_radiolist($element)
    {
        // code here
    }

    /**
     *
     */
    public function fieldset($element)
    {
        // code here
    }
}
