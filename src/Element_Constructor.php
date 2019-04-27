<?php

/**
 * 
 */

class Element_Constructor extends HTML_Element
{
    /**
     * 
     */
    public function populate_static_element_attributes()
    {
        foreach ($this->element_array as $element => &$values) {

            if (isset($this->args[$element]['attributes'])) {
                // $values['attributes'] = $this->args[$element]['attributes'];
                $values['attributes'] = $this->parse_attributes($this->args[$element]['attributes']);
            }
        }
    }

    /**
     * Reconstructs an array that meets the specifications of the HTML_Element API into one that is parsable by $this->construct_element()
     * 
     * @param array $element_array
     */
    public function parse_element_array($element_array)
    {
        foreach ($element_array as $element) {
            if (!array_key_exists('tag', $element)) {
                $parse = true;
                break;
            }
        }

        if (!isset($parse)) {
            return $element_array;
        }

        foreach ($element_array as $current_element => $definition) { // begin $element_array loop
            if (!array_key_exists('children', $definition)) {
                continue;
            }

            $element_array[$current_element]['children'] = is_array($definition['children']) ? $definition['children'] : [$definition['children']];
            $children = $element_array[$current_element]['children'];

            // loop through array of $current_element children
            foreach ($children as $blueprint_node) {

                // don't iterate through children that already exist in proper linear context
                if (array_key_exists('tag', $element_array[$blueprint_node])) {
                    continue;
                }

                // begin loop through each item in the blueprint node array
                foreach ($element_array[$blueprint_node] as $child_blueprint => $node_map) {
                    if (!array_key_exists('instances', $node_map)) {
                        throw new Error('you know you fucked up right?');
                    }


                    // convert children attribute to array if it exists and is
                    // not already an array
                    if (array_key_exists('children', $node_map)) {
                        $node_map['children'] = is_array($node_map['children']) ? $node_map['children'] : [$node_map['children']];
                    }

                    
                    // loop through array of instances and convert them to the a
                    // structure parsable into html markup using values from $node_map
                    foreach ($node_map['instances'] as $instance => $children_definition) {
                        
                        // get children specified in blueprint
                        $instance_children = $node_map['children'] ?? [];

                        // create the element definition
                        $new_child = [
                            'tag' => $node_map['tag'],
                            'content' => $children_definition['content'] ?? '',
                            'attributes' => $children_definition['attributes'] ?? null,
                        ];

                        /**
                         * new elements are to be namespaced begining with the
                         * root name followed by the blueprint node name and
                         * ending with the its index in the instances array
                         * 
                         * as a result children can be predicted as the name
                         * will be the same save for the blueprint node name
                         */
                        foreach ($instance_children as $instance_child_blueprint) {
                            $new_child['children'][] = "{$blueprint_node}-{$instance_child_blueprint}-{$instance}";
                        }

                        // create an array of new children to add top level
                        // elements to the 'children' property of $current_element
                        $lost_children["{$blueprint_node}-{$child_blueprint}-{$instance}"] = $new_child;

                        // insert new child into root level of $element_array
                        $element_array["{$blueprint_node}-{$child_blueprint}-{$instance}"] = $new_child;
                    }

                } // end loop through each item in the blueprint node array


                /**
                 * for every new element created, check to see if it is
                 * referenced as a child of any of the other new elements
                 * 
                 * if it is not listed as a child of any other new element,
                 * append it by key to $current_element['children']
                 * 
                 * note: $real child is only declared in order to have
                 * access to the key $pointer
                 */
                foreach ($lost_children as $pointer => $genetics) {

                    // look for parent amongst siblings
                    foreach ($lost_children as $maybe_child => $family_values) {
                        if (array_key_exists('children', $family_values)) {

                            // move to the next iteration if the element is referenced as a child of any other element
                            if (in_array($pointer, $family_values['children'])) {
                                continue;
                            }

                            // add any new elements that make it this far to $current_element['children'] only if
                            // they have not already been added (because it will add them again!)
                            // die(var_dump($element_array[$current_element]['children']));

                            if (!in_array($maybe_child, $element_array[$current_element]['children'])) {
                                $element_array[$current_element]['children'][] = $maybe_child;
                            }
                        }
                    }
                }

                // remove blueprint node name from $current_element['children']
                $blueprint_node_index = array_search($blueprint_node, $element_array[$current_element]['children']);
                unset($element_array[$current_element]['children'][$blueprint_node_index]);

                // remove blueprint from element_arry
                unset($element_array[$blueprint_node]);

            } // end $current_element['children'] loop

        } // end $element_array loop

        return $this->parse_element_array($element_array);
    }
}
