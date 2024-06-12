<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/daniel/projekty/quickstart/quickstart/app/UI/Admin/Mod/default.latte */
final class Template_e4498afb9b extends Latte\Runtime\Template
{
	public const Source = '/home/daniel/projekty/quickstart/quickstart/app/UI/Admin/Mod/default.latte';

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
			foreach (array_intersect_key(['mod' => '26'], $this->params) as $ʟ_v => $ʟ_l) {
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

';
		if ($user->isLoggedIn()) /* line 6 */ {
			echo '<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('ModEdit:create')) /* line 6 */;
			echo '">Upload New Mod</a>
';
		}
		echo '
<div class="pagination">
';
		if (!$paginator->isFirst()) /* line 9 */ {
			echo '		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('default', [1])) /* line 10 */;
			echo '">First</a>
		&nbsp;|&nbsp;
		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('default', [$paginator->page - 1])) /* line 12 */;
			echo '">Previous</a>
		&nbsp;|&nbsp;
';
		}
		echo '
	Page ';
		echo LR\Filters::escapeHtmlText($paginator->getPage()) /* line 16 */;
		echo ' of ';
		echo LR\Filters::escapeHtmlText($paginator->getPageCount()) /* line 16 */;
		echo '

';
		if (!$paginator->isLast()) /* line 18 */ {
			echo '		&nbsp;|&nbsp;
		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('default', [$paginator->getPage() + 1])) /* line 20 */;
			echo '">Next</a>
		&nbsp;|&nbsp;
		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('default', [$paginator->getPageCount()])) /* line 22 */;
			echo '">Last</a>
';
		}
		echo '</div>

';
		foreach ($mods as $mod) /* line 26 */ {
			echo '	<div class="mod">

		<h2><a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Mod:show', [$mod->id])) /* line 29 */;
			echo '">';
			echo LR\Filters::escapeHtmlText($mod->name) /* line 29 */;
			echo '</a></h2>

';
			if ($mod->image) /* line 31 */ {
				echo '    		<img src="';
				echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 32 */;
				echo '/';
				echo LR\Filters::escapeHtmlAttr($mod->image) /* line 32 */;
				echo '" alt="Thumbnail">
';
			}
			echo '
		<div>';
			echo LR\Filters::escapeHtmlText(($this->filters->truncate)($mod->description, 256)) /* line 35 */;
			echo '</div>

        <div class="date">';
			echo LR\Filters::escapeHtmlText(($this->filters->date)($mod->created_at, 'F j, Y')) /* line 37 */;
			echo '</div>
	</div>
';

		}
	}
}
