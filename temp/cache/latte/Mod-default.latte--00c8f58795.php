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
			foreach (array_intersect_key(['mod' => '6'], $this->params) as $ʟ_v => $ʟ_l) {
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
		foreach ($mods as $mod) /* line 6 */ {
			echo '	<div class="mod">

		<h2><a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Mod:show', [$mod->id])) /* line 9 */;
			echo '">';
			echo LR\Filters::escapeHtmlText($mod->name) /* line 9 */;
			echo '</a></h2>

		<div>';
			echo LR\Filters::escapeHtmlText(($this->filters->truncate)($mod->description, 256)) /* line 11 */;
			echo '</div>

        <div class="date">';
			echo LR\Filters::escapeHtmlText(($this->filters->date)($mod->created_at, 'F j, Y')) /* line 13 */;
			echo '</div>
	</div>
';

		}
	}
}
