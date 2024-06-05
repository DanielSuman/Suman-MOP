<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/daniel/projekty/quickstart/quickstart/app/UI/Mod/default.latte */
final class Template_00c8f58795 extends Latte\Runtime\Template
{
	public const Source = '/home/daniel/projekty/quickstart/quickstart/app/UI/Mod/default.latte';

	public const Blocks = [
		['content' => 'blockContent'],
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


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['mod' => '24'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}


	/** {block content} on line 3 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h1>Mods</h1>

<div class="pagination">
';
		if (!$paginator->isFirst()) /* line 7 */ {
			echo '		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('default', [1])) /* line 8 */;
			echo '">First</a>
		&nbsp;|&nbsp;
		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('default', [$paginator->page - 1])) /* line 10 */;
			echo '">Previous</a>
		&nbsp;|&nbsp;
';
		}
		echo '
	Page ';
		echo LR\Filters::escapeHtmlText($paginator->getPage()) /* line 14 */;
		echo ' of ';
		echo LR\Filters::escapeHtmlText($paginator->getPageCount()) /* line 14 */;
		echo '

';
		if (!$paginator->isLast()) /* line 16 */ {
			echo '		&nbsp;|&nbsp;
		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('default', [$paginator->getPage() + 1])) /* line 18 */;
			echo '">Next</a>
		&nbsp;|&nbsp;
		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('default', [$paginator->getPageCount()])) /* line 20 */;
			echo '">Last</a>
';
		}
		echo '</div>

';
		foreach ($mods as $mod) /* line 24 */ {
			echo '	<div class="mod">

		<h2><a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Mod:show', [$mod->id])) /* line 27 */;
			echo '">';
			echo LR\Filters::escapeHtmlText($mod->name) /* line 27 */;
			echo '</a></h2>

';
			if ($mod->image) /* line 29 */ {
				echo '    		<img src="';
				echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 30 */;
				echo '/';
				echo LR\Filters::escapeHtmlAttr($mod->image) /* line 30 */;
				echo '" alt="Thumbnail">
';
			}
			echo '
		<div>';
			echo LR\Filters::escapeHtmlText(($this->filters->truncate)($mod->description, 256)) /* line 33 */;
			echo '</div>

        <div class="date">';
			echo LR\Filters::escapeHtmlText(($this->filters->date)($mod->created_at, 'F j, Y')) /* line 35 */;
			echo '</div>
	</div>
';

		}
	}
}
