<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/daniel/projekty/quickstart/quickstart/app/UI/Mod/show.latte */
final class Template_1629afb139 extends Latte\Runtime\Template
{
	public const Source = '/home/daniel/projekty/quickstart/quickstart/app/UI/Mod/show.latte';

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
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Mod:default')) /* line 3 */;
		echo '">← back to mods list</a></p>

';
		$this->renderBlock('name', get_defined_vars()) /* line 5 */;
		echo '
<div class="mod">';
		echo LR\Filters::escapeHtmlText($mod->description) /* line 7 */;
		echo '</div>

<div class="date">';
		echo LR\Filters::escapeHtmlText(($this->filters->date)($mod->created_at, 'F j, Y')) /* line 9 */;
		echo '</div>';
	}


	/** n:block="name" on line 5 */
	public function blockName(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h1>';
		echo LR\Filters::escapeHtmlText($mod->name) /* line 5 */;
		echo '</h1>
';
	}
}
