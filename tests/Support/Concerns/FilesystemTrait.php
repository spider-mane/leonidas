<?php

namespace Tests\Support\Concerns;

use Symfony\Component\Filesystem\Filesystem;

trait FilesystemTrait
{
    protected Filesystem $filesystem;

    protected function initFilesystem(): void
    {
        $this->filesystem = new Filesystem();
    }
}
