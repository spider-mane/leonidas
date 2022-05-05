<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\Post\AttachmentPostEntityManagerInterface;

class AttachmentPostEntityManager extends PostEntityManager implements AttachmentPostEntityManagerInterface
{
    public function update(int $id, array $data): void
    {
        $viewData = $data['view_data']
            ?? $data['meta_input']['_wp_attachment_metadata']
            ?? [];

        parent::update($id, $data);

        if ($viewData) {
            wp_update_attachment_metadata($id, $viewData);
        }
    }

    protected function normalizeDataForEntry(array $data, int $id = 0): array
    {
        unset(
            $data['view_data'],
            $data['meta_input']['_wp_attachment_metadata']
        );

        return parent::normalizeDataForEntry($data, $id);
    }
}
