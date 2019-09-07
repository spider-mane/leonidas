<?php

namespace Backalley\Wordpress\Forms\Controllers;

use Backalley\Form\Controllers\AbstractFormSubmissionManager;
use Backalley\Wordpress\Modules\AdminNotice;

class PostMetaBoxFormSubmissionManager extends AbstractFormSubmissionManager
{
    /**
     * @var WP_Post_Type
     */
    protected $postType;

    /**
     *
     */
    private $nonce = [];

    /**
     *
     */
    private const TRANSIENT_RULE_VIOLATION = 'backalley.form.field.ruleViolation';

    /**
     *
     */
    public function __construct(string $postType)
    {
        $this->postType = get_post_type_object($postType);
    }

    /**
     * Get the value of postType
     *
     * @return string
     */
    public function getPostType(): WP_Post_Type
    {
        return $this->postType;
    }

    /**
     * @param string $postType The post type to that is being saved
     */
    public function hook()
    {
        add_action("save_post_{$this->postType->name}", [$this, 'savePostActionCallback'], null, 3);
        add_action('admin_notices', [$this, 'adminNoticeActionCallback'], null, 0);

        return $this;
    }

    public function setNonce(string $name, string $action)
    {
        $this->nonce['name'] = $name;
        $this->nonce['action'] = $action;

        return $this;
    }

    /**
     *
     */
    public function savePostActionCallback($postId, $post, $update)
    {
        if ($update && $this->isSafeToRun($post)) {
            $this->handleRequest($post);
        }
    }

    /**
     *
     */
    protected function finalizeRequest($request)
    {
        if (!empty($alerts = $this->getAlerts())) {
            set_transient($this::TRANSIENT_RULE_VIOLATION, $alerts, 300);
        }
    }

    /**
     *
     */
    private function isSafeToRun($post): bool
    {
        $nonceName = $this->nonce['name'] ?? null;
        $nonceAction = $this->nonce['action'] ?? null;

        if (
            (!isset($nonceName, $nonceAction, $_POST[$nonceName])) // $this->nonce and nonce field does not exist
            || (!wp_verify_nonce($_POST[$nonceName], $nonceAction)) // nonce action does not match
            || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) // wp performing autosave
            || (!current_user_can('edit_post', $post->ID)) // current user does not have required permission
        ) {
            return false;
        }

        return true;
    }

    /**
     *
     */
    public function adminNoticeActionCallback()
    {
        $transient = $this::TRANSIENT_RULE_VIOLATION;

        if (false !== $alerts = get_transient($transient)) {

            foreach ($alerts as $alert) {
                echo (new AdminNotice($alert))->setDismissible(false);
            }

            delete_transient($transient);
        }
    }
}
