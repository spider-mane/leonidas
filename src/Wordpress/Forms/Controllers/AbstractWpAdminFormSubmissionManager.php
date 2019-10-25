<?php

namespace WebTheory\WordPress\Forms\Controllers;

use WebTheory\Saveyour\Controllers\AbstractFormSubmissionManager;
use WebTheory\WordPress\Modules\AdminNotice;

abstract class AbstractWpAdminFormSubmissionManager extends AbstractFormSubmissionManager
{
    /**
     *
     */
    protected $nonce = [];

    /**
     *
     */
    protected const TRANSIENT__RULE_VIOLATION = 'backalley.form.field.ruleViolation';

    /**
     *
     */
    protected function hook()
    {
        add_action('admin_notices', [$this, 'adminNoticeActionCallback'], null, 0);

        return $this;
    }

    /**
     *
     */
    public function setNonce(string $name, string $action)
    {
        $this->nonce['name'] = $name;
        $this->nonce['action'] = $action;

        return $this;
    }

    /**
     *
     */
    protected function finalizeRequest($request)
    {
        if (empty($alerts = $this->getAlerts())) {
            return;
        }

        $transient = static::TRANSIENT__RULE_VIOLATION;
        $exp = 300;

        if (false === $messages = get_transient($transient)) {
            set_transient($transient, $alerts, $exp);
        } else {
            set_transient($transient, $messages + $alerts, $exp);
        }

        return $this;
    }

    /**
     *
     */
    public function adminNoticeActionCallback()
    {
        $transient = static::TRANSIENT__RULE_VIOLATION;

        if (false !== $alerts = get_transient($transient)) {

            foreach ($alerts as $alert) {
                echo (new AdminNotice($alert))->setDismissible(false);
            }

            delete_transient($transient);
        }
    }

    /**
     *
     */
    protected function formHasValidNonce(): bool
    {
        $nonceName = $this->nonce['name'] ?? null;
        $nonceAction = $this->nonce['action'] ?? null;

        if (
            !isset($nonceName, $nonceAction, $_POST[$nonceName])
            || !wp_verify_nonce($_POST[$nonceName], $nonceAction)
        ) {
            return false;
        }

        return true;
    }
}
