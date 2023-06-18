<?php

namespace Tests\Suites\Unit\Console;

use DirectoryIterator;
use Tests\Support\Concerns\FilesystemTrait;
use Tests\Support\UnitTestCase;

class MakeModelCommandTest extends UnitTestCase
{
    use FilesystemTrait;

    protected function setUp(): void
    {
        parent::setUp();

        $this->initFilesystem();
    }

    protected function getTestDirname(): string
    {
        return $this->getAbspath('/.playground/model');
    }

    protected function setupTestDir(): array
    {
        $playground = $this->getTestDirname();

        if ($this->filesystem->exists($playground)) {
            foreach (new DirectoryIterator($playground) as $file) {
                if (!$file->isFile()) {
                    continue;
                }

                $isInterface = str_ends_with($file->getBasename(), 'Interface.php');
                $isRegistrar = $file->getBasename() === 'RegisterModelServices.php';

                if (!($isInterface || $isRegistrar)) {
                    $this->filesystem->remove($file->getPathname());
                }

                if ($isInterface) {
                    require $file->getPathname();
                }
            }
        } else {
            $this->filesystem->mkdir($playground);
        }

        $registrar = 'RegisterModelServices.php';

        $this->filesystem->copy(
            $this->getAbspath("/src/Framework/Bootstrap/{$registrar}"),
            "{$playground}/{$registrar}"
        );

        foreach (['Contracts', 'Library'] as $namespace) {
            $this->filesystem->remove(
                $this->getAbspath('/src/' . $namespace . '/System/Model/Test')
            );
        }

        return [
            'interfaces' => $playground,
            'classes' => $playground,
            'abstracts' => $playground,
            'facades' => $playground,
        ];
    }

    protected function clearTestDir(): void
    {
        $playground = $this->getTestDirname();

        if ($this->filesystem->exists($playground)) {
            $this->filesystem->remove($playground);
        }
    }
}
