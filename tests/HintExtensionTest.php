<?php

namespace Ueberdosis\CommonMark\Tests;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use PHPUnit\Framework\TestCase;
use Ueberdosis\CommonMark\HintExtension;

class HintExtensionTest extends TestCase
{
    /** @test */
    public function markdown_hints_are_rendered()
    {
        // Configure the Environment with all the CommonMark parsers/renderers
        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());

        // Add this extension
        $environment->addExtension(new HintExtension());

        // Instantiate the converter engine and start converting some Markdown!
        $converter = new MarkdownConverter($environment);
        $markdown = <<<MARKDOWN
:::important Warning!
This is how the **Markdown** looks.
:::
MARKDOWN;

        $this->assertEquals((string) $converter->convertToHtml($markdown), <<<HTML
<div class="hint not-prose important">
<span class="hint-title">Warning!</span>
<div class="hint-content">This is how the <strong>Markdown</strong> looks.</div>
</div>

HTML);
    }

    /** @test */
    public function markdown_hints_after_headings_are_rendered()
    {
        // Configure the Environment with all the CommonMark parsers/renderers
        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());

        // Add this extension
        $environment->addExtension(new HintExtension());

        // Instantiate the converter engine and start converting some Markdown!
        $converter = new MarkdownConverter($environment);
        $markdown = <<<MARKDOWN
# Test

:::important Warning!
This is how the **Markdown** looks.
:::
MARKDOWN;

        $this->assertEquals((string) $converter->convertToHtml($markdown), <<<HTML
<h1>Test</h1>
<div class="hint not-prose important">
<span class="hint-title">Warning!</span>
<div class="hint-content">This is how the <strong>Markdown</strong> looks.</div>
</div>

HTML);
    }

    /** @test */
    public function paragraphs_after_hints_are_rendered()
    {
        // Configure the Environment with all the CommonMark parsers/renderers
        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());

        // Add this extension
        $environment->addExtension(new HintExtension());

        // Instantiate the converter engine and start converting some Markdown!
        $converter = new MarkdownConverter($environment);
        $markdown = <<<MARKDOWN
:::important Warning!
This is how the **Markdown** looks.
:::

Test
MARKDOWN;

        $this->assertEquals((string) $converter->convertToHtml($markdown), <<<HTML
<div class="hint not-prose important">
<span class="hint-title">Warning!</span>
<div class="hint-content">This is how the <strong>Markdown</strong> looks.</div>
</div>
<p>Test</p>

HTML);
    }
}
