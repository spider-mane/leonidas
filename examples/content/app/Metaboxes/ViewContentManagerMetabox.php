<?php

namespace Example\Content\Metaboxes;

use Faker\Factory;
use Faker\Generator;
use Leonidas\Content\Elements\CopyInputRow;
use Leonidas\Content\Elements\ViewContentManager;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxComponentInterface;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxLayoutInterface;
use Leonidas\Contracts\Content\CopyInterface;
use Leonidas\Contracts\Content\HeadingInterface;
use Leonidas\Framework\Capsule\Abstracts\MetaboxCapsule;
use Leonidas\Library\Admin\Component\Metabox\Layout\SegmentedLayout;
use Leonidas\Plugin\Module\Abstracts\LeonidasServices;
use Psr\Http\Message\ServerRequestInterface;
use WP_Screen;
use WebContent\Copy\Contracts\PictureInterface;
use WebContent\Copy\Contracts\VideoInterface;
use WebContent\Copy\Contracts\ViewContentInterface;
use WebContent\Copy\Models\Action;
use WebContent\Copy\Models\Copy;
use WebContent\Copy\Models\Heading;
use WebContent\Copy\Models\Paragraph;
use WebContent\Copy\Models\Picture;
use WebContent\Copy\Models\Section;
use WebContent\Copy\Models\Statement;
use WebContent\Copy\Models\Subheading;
use WebContent\Copy\Models\Video;
use WebContent\Copy\Models\ViewContent;
use WebContent\Copy\Models\VisualMedia;
use WebTheory\Saveyour\Contracts\Report\FormProcessReportInterface;
use WebTheory\Saveyour\Controller\Builder\FormFieldControllerBuilder;
use WebTheory\Saveyour\Processor\FormSubmissionCallback;
use WebTheory\Saveyour\Report\ProcessedInputReport;

class ViewContentManagerMetabox extends MetaboxCapsule
{
    use LeonidasServices;

    public function id(): string
    {
        return $this->slug('view');
    }

    public function title(): string
    {
        return 'Page Content Editor';
    }

    public function screen(): string|array|WP_Screen
    {
        return [];
    }

    public function layout(ServerRequestInterface $request): MetaboxLayoutInterface
    {
        return new ViewContentManager($this->viewContent($request), [
            'input-root' => $this->inputKey(),
        ]);
    }

    protected function inputKey(): string
    {
        return $this->slug('view-data');
    }

    protected function fieldId(): string
    {
        return 'leonidas-view-content-editor';
    }

    protected function viewContent(ServerRequestInterface $request): ViewContentInterface
    {
        $fake = Factory::create();
        $rand = fn(...$values) => $values[array_rand($values)];
        $fill = fn($cb, $min, $max) => array_map(
            $cb,
            array_fill(0, random_int($min, $max), 0)
        );

        $pictures = get_posts([
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'post_mime_type' => 'image',
        ]);

        $videos = get_posts([
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'post_mime_type' => 'video',
        ]);

        $getPicture = function () use ($pictures): PictureInterface {
            $attachment = $pictures[array_rand($pictures)];

            // dd($attachment);
            $id = $attachment->ID;

            return new Picture(
                $attachment->post_mime_type,
                $id = $attachment->ID,
                wp_get_attachment_image_url($id, 'full'),
                wp_get_attachment_image_srcset($id, 'full'),
                get_post_meta($id, '_wp_attachment_image_alt', true),
            );
        };

        $getVideo = function () use ($videos): VideoInterface {
            $attachment = $videos[array_rand($videos)];

            return new Video(
                $attachment->post_mime_type,
                $id = $attachment->ID,
                wp_get_attachment_url($id),
                wp_get_attachment_image_srcset($id),
            );
        };

        $kicker = fn() => new Statement(ucwords($fake->words(2, true)));
        $heading = fn() => new Statement(ucwords($fake->words(6, true)));
        $subheading = fn() => new Statement(ucfirst($fake->words(8, true)));
        $body = fn() => new Paragraph($fake->sentences(3, true));
        $action = fn() => new Action(ucwords($fake->word()), $fake->slug(2));
        $picture = fn() => new VisualMedia('picture', $getPicture());
        $video = fn() => new VisualMedia('video', $getVideo());

        $copy = fn() => new Copy(
            $kicker(),
            $heading(),
            $subheading(),
            $body(),
            $action(),
            $rand($picture(), $video(), null)
        );

        $section = fn() => new Section(
            ucwords($fake->words(3, true)),
            $fake->sentences(3, true),
            $fake->slug(3),
            $copy(),
            $fill($copy, 2, 4)
        );

        return new ViewContent($copy(), $fill($section, 4, 6));
    }

    protected function formProcessors(ServerRequestInterface $request): array
    {
        return [
            new FormSubmissionCallback(
                'view-data',
                [$this->inputKey()],
                $this->processForm(...)
            )
        ];
    }

    /**
     * @param ServerRequestInterface $request
     * @param array<string, ProcessedInputReport> $results
     */
    protected function processForm(ServerRequestInterface $request, array $results): ?FormProcessReportInterface
    {
        dd($request->getParsedBody());
        $data = $results[$this->inputKey()]->sanitizedInputValue();

        dd($data);

        return null;
    }

    protected function formFields(ServerRequestInterface $request): array
    {
        return [
            FormFieldControllerBuilder::for($this->inputKey())->get()
        ];
    }

    protected function alerts(): array
    {
        return [
            //
        ];
    }
}
