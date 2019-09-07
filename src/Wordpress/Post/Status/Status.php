<?php

namespace Backalley\Wordpress\Post\Status;

use Backalley\Html\Html;

class Status
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $options;

    /**
     *
     */
    public function __construct(string $name, $options = [])
    {
        $this->name = $name;
        $this->setOptions($options);
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of options
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Set the value of options
     *
     * @param array $options
     *
     * @return self
     */
    public function setOptions(array $options)
    {
        $tag = Html::tag('span', '(%s)', ['class' => 'count']);
        $title = ucfirst($this->name);

        $this->options = $options + [
            'label' => _x($title, 'post'),
            'public' => true,
            'exclude_from_search' => false,
            'show_in_admin_all_list' => true,
            'show_in_admin_status_list' => true,
            'post_type' => array('post', 'movie'),
            'publish_text' => __('Apply Changes'),
            'label_count' => _n_noop("{$title} {$tag}", "{$title} {$tag}"),
        ];

        return $this;
    }

    /**
     *
     */
    public function editOption($option, $value)
    {
        $this->options[$option] = $value;
    }

    /**
     *
     */
    public function getOptionValue($option)
    {
        return $this->options[$option];
    }

    /**
     *
     */
    public function register()
    {
        return register_post_status($this->name, $this->options);
    }
}
