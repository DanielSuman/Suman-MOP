<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/daniel/projekty/quickstart/quickstart/app/UI/Admin/Home/default.latte */
final class Template_3742f73b70 extends Latte\Runtime\Template
{
	public const Source = '/home/daniel/projekty/quickstart/quickstart/app/UI/Admin/Home/default.latte';

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
			foreach (array_intersect_key(['post' => '27'], $this->params) as $ʟ_v => $ʟ_l) {
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

		echo '
<h1>Blog</h1>

<div class="pagination">
';
		if (!$paginator->isFirst()) /* line 10 */ {
			echo '		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('default', [1])) /* line 11 */;
			echo '">First</a>
		&nbsp;|&nbsp;
		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('default', [$paginator->page - 1])) /* line 13 */;
			echo '">Previous</a>
		&nbsp;|&nbsp;
';
		}
		echo '
	Page ';
		echo LR\Filters::escapeHtmlText($paginator->getPage()) /* line 17 */;
		echo ' of ';
		echo LR\Filters::escapeHtmlText($paginator->getPageCount()) /* line 17 */;
		echo '

';
		if (!$paginator->isLast()) /* line 19 */ {
			echo '		&nbsp;|&nbsp;
		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('default', [$paginator->getPage() + 1])) /* line 21 */;
			echo '">Next</a>
		&nbsp;|&nbsp;
		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('default', [$paginator->getPageCount()])) /* line 23 */;
			echo '">Last</a>
';
		}
		echo '</div>

';
		foreach ($posts as $post) /* line 27 */ {
			echo '	<div class="post">

		<h2><a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Post:show', [$post->id])) /* line 30 */;
			echo '">';
			echo LR\Filters::escapeHtmlText($post->title) /* line 30 */;
			echo '</a></h2>

		<img src="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 32 */;
			echo '/';
			echo LR\Filters::escapeHtmlAttr($post->image) /* line 32 */;
			echo '" alt="Obrázek k článku ';
			echo LR\Filters::escapeHtmlAttr($post->title) /* line 32 */;
			echo '">
		
		<div>';
			echo LR\Filters::escapeHtmlText(($this->filters->truncate)($post->content, 256)) /* line 34 */;
			echo '</div>

        <div class="date">';
			echo LR\Filters::escapeHtmlText(($this->filters->date)($post->created_at, 'F j, Y')) /* line 36 */;
			echo '</div>
	</div>
';

		}

		echo "\n";
	}
}
