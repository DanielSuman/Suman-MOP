<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/daniel/projekty/quickstart/quickstart/app/UI/SIgn/out.latte */
final class Template_dd97442d82 extends Latte\Runtime\Template
{
	public const Source = '/home/daniel/projekty/quickstart/quickstart/app/UI/SIgn/out.latte';

	public const Blocks = [
		['content' => 'blockContent', 'title' => 'blockTitle'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		if ($this->global->snippetDriver?->renderSnippets($this->blocks[self::LayerSnippet], $this->params)) {
			return;
		}

		$this->renderBlock('content', get_defined_vars()) /* line 3 */;
	}


	/** {block content} on line 3 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		$this->renderBlock('title', get_defined_vars()) /* line 4 */;
		echo '
<p><a href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('in')) /* line 6 */;
		echo '">Sign in to another account</a></p>
';
	}


	/** n:block="title" on line 4 */
	public function blockTitle(array $ʟ_args): void
	{
		echo '<h1>You have been signed out</h1>
';
	}
}
