<?php

namespace WHTwig\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

use Parsedown as MarkdownConverter;

/**
 * @author Will Herzog <willherzog@gmail.com>
 */
class MarkdownExtension extends AbstractExtension
{
	protected readonly MarkdownConverter $markdownConverter;

	public function __construct(?MarkdownConverter $markdownConverter = null)
	{
		$this->markdownConverter = $markdownConverter ?? new MarkdownConverter();
	}

	/**
	 * @inheritDoc
	 */
	public function getFilters(): array
	{
		return [
			new TwigFilter('markdown', function(string $text, bool $enableLineBreaks = false): string
			{
				$this->markdownConverter->setBreaksEnabled($enableLineBreaks);

				return $this->markdownConverter->text($text);
			}, ['is_safe' => ['all']]),

			new TwigFilter('markdown_line_only', function(string $line, bool $enableLineBreaks = true): string {
				$this->markdownConverter->setBreaksEnabled($enableLineBreaks);

				return $this->markdownConverter->line($line);
			}, ['is_safe' => ['all']])
		];
	}
}
