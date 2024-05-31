<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/daniel/projekty/quickstart/quickstart/app/UI/Game/show.latte */
final class Template_e4bd3e90a4 extends Latte\Runtime\Template
{
	public const Source = '/home/daniel/projekty/quickstart/quickstart/app/UI/Game/show.latte';

	public const Blocks = [
		['content' => 'blockContent', 'name' => 'blockName'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		if ($this->global->snippetDriver?->renderSnippets($this->blocks[self::LayerSnippet], $this->params)) {
			return;
		}

		$this->renderBlock('content', get_defined_vars()) /* line 1 */;
	}


	/** {block content} on line 1 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '
<p><a href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Game:default')) /* line 3 */;
		echo '">← back to games list</a></p>

';
		$this->renderBlock('name', get_defined_vars()) /* line 5 */;
		echo '
<div class="game">';
		echo LR\Filters::escapeHtmlText($game->description) /* line 7 */;
		echo '</div>

<div class="date">';
		echo LR\Filters::escapeHtmlText(($this->filters->date)($game->created_at, 'F j, Y')) /* line 9 */;
		echo '</div>';
	}


	/** n:block="name" on line 5 */
	public function blockName(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h1>';
		echo LR\Filters::escapeHtmlText($game->name) /* line 5 */;
		echo '</h1>
';
	}
}
