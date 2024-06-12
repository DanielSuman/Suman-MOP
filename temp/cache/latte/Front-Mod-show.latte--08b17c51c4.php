<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/daniel/projekty/quickstart/quickstart/app/UI/Front/Mod/show.latte */
final class Template_08b17c51c4 extends Latte\Runtime\Template
{
	public const Source = '/home/daniel/projekty/quickstart/quickstart/app/UI/Front/Mod/show.latte';

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
		echo "\n";
		if ($mod->image) /* line 7 */ {
			echo '    <img src="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 8 */;
			echo '/';
			echo LR\Filters::escapeHtmlAttr($mod->image) /* line 8 */;
			echo '" alt="Thumbnail">
';
		}
		echo '
<div class="mod">';
		echo LR\Filters::escapeHtmlText($mod->description) /* line 11 */;
		echo '</div>

';
		if ($mod->vidprev) /* line 13 */ {
			echo '    <h2>Preview video:</h2>
    <iframe width="560" height="315" src="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($mod->vidprev)) /* line 15 */;
			echo '" frameborder="0" allowfullscreen></iframe>
';
		}
		echo '

<div class="date">Created on ';
		echo LR\Filters::escapeHtmlText(($this->filters->date)($mod->created_at, 'D. F j, Y')) /* line 19 */;
		echo '</div>



';
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
