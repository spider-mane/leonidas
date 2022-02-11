<?php

namespace Leonidas\Framework\Modules\Traits;

use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Leonidas\Library\Core\Auth\Nonce;
use Psr\Http\Message\ServerRequestInterface;

trait UsesNonceAsTokenTrait
{
    use AbstractModuleTraitTrait;

    protected function token(ServerRequestInterface $request): ?CsrfManagerInterface
    {
        $data = $this->nonceData($request);

        return new Nonce($data['name'], $data['name']);
    }

    protected function nonceData(ServerRequestInterface $request): array
    {
        return [
            'name' => $this->getExtension()->getPrefix() . '_' . $this->getPostType() . '_nonce',
            'action' => $this->getExtension()->getPrefix() . '_update_' . $this->getPostType(),
        ];
    }
}
