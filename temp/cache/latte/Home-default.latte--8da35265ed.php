<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/daniel/projekty/quickstart/quickstart/app/UI/Home/default.latte */
final class Template_8da35265ed extends Latte\Runtime\Template
{
	public const Source = '/home/daniel/projekty/quickstart/quickstart/app/UI/Home/default.latte';

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
			foreach (array_intersect_key(['post' => '22'], $this->params) as $ʟ_v => $ʟ_l) {
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

		echo '<h1>Blog</h1>
<div class="pagination">
';
		if (!$paginator->isFirst()) /* line 6 */ {
			echo '		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('default', [1])) /* line 7 */;
			echo '">První</a>
		&nbsp;|&nbsp;
		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('default', [$paginator->page - 1])) /* line 9 */;
			echo '">Předchozí</a>
		&nbsp;|&nbsp;
';
		}
		echo '
	Stránka ';
		echo LR\Filters::escapeHtmlText($paginator->getPage()) /* line 13 */;
		echo ' z ';
		echo LR\Filters::escapeHtmlText($paginator->getPageCount()) /* line 13 */;
		echo '

';
		if (!$paginator->isLast()) /* line 15 */ {
			echo '		&nbsp;|&nbsp;
		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('default', [$paginator->getPage() + 1])) /* line 17 */;
			echo '">Další</a>
		&nbsp;|&nbsp;
		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('default', [$paginator->getPageCount()])) /* line 19 */;
			echo '">Poslední</a>
';
		}
		echo '</div>
';
		foreach ($posts as $post) /* line 22 */ {
			echo '	<div class="post">

		<h2><a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Post:show', [$post->id])) /* line 25 */;
			echo '">';
			echo LR\Filters::escapeHtmlText($post->title) /* line 25 */;
			echo '</a></h2>

		<img src="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 27 */;
			echo '/';
			echo LR\Filters::escapeHtmlAttr($post->image) /* line 27 */;
			echo '" alt="Obrázek k článku ';
			echo LR\Filters::escapeHtmlAttr($post->title) /* line 27 */;
			echo '">
		
		<div>';
			echo LR\Filters::escapeHtmlText(($this->filters->truncate)($post->content, 256)) /* line 29 */;
			echo '</div>

        <div class="date">';
			echo LR\Filters::escapeHtmlText(($this->filters->date)($post->created_at, 'F j, Y')) /* line 31 */;
			echo '</div>
	</div>
';

		}

		echo "\n";
	}
}
