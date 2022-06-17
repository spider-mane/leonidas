<?php

namespace Leonidas\Contracts\Ui\Asset;

use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

interface InlineScriptBuilderInterface
{
    /**
     * @return $this
     */
    public function handle(string $handle);

    /**
     * @return $this
     */
    public function code(string $code);

    /**
     * @return $this
     */
    public function position(string $position);

    /**
     * @return $this
     */
    public function policy(?ServerRequestPolicyInterface $policy);

    public function done(): InlineScriptInterface;
}
