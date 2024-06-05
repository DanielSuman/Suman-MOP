<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/daniel/projekty/quickstart/quickstart/app/UI/@layout.latte */
final class Template_9af097fb56 extends Latte\Runtime\Template
{
	public const Source = '/home/daniel/projekty/quickstart/quickstart/app/UI/@layout.latte';

	public const Blocks = [
		['scripts' => 'blockScripts'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		if ($this->global->snippetDriver?->renderSnippets($this->blocks[self::LayerSnippet], $this->params)) {
			return;
		}

		echo '<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 6 */;
		echo '/css/style.css">
	<title>';
		if ($this->hasBlock('title')) /* line 7 */ {
			$this->renderBlock('title', [], function ($s, $type) {
				$ʟ_fi = new LR\FilterInfo($type);
				return LR\Filters::convertTo($ʟ_fi, 'html', $this->filters->filterContent('stripHtml', $ʟ_fi, $s));
			}) /* line 7 */;
			echo ' | ';
		}
		echo 'Nette Web</title>
</head>

<body>
';
		foreach ($flashes as $flash) /* line 11 */ {
			echo '	<div';
			echo ($ʟ_tmp = array_filter(['flash', $flash->type])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "" /* line 11 */;
			echo '>';
			echo LR\Filters::escapeHtmlText($flash->message) /* line 11 */;
			echo '</div>
';

		}

		echo '
	<ul class="navig">
';
		if ($user->isLoggedIn()) /* line 14 */ {
			echo '			<li>Logged in as <strong>';
			echo LR\Filters::escapeHtmlText($user->getIdentity()->nickname) /* line 15 */;
			echo '</strong> | <a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Sign:out')) /* line 15 */;
			echo '">Sign-out</a></li>
';
		} else /* line 16 */ {
			echo '			<li>No registered user detected | <a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Sign:in')) /* line 17 */;
			echo '">Sign-In</a> | <a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Sign:up')) /* line 17 */;
			echo '">Sign-Up</a></li>
';
		}
		echo '		<li><a href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Home:')) /* line 19 */;
		echo '">Articles</a></li>
		<li><a href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Game:')) /* line 20 */;
		echo '">Games</a></li>
		<li><a href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Mod:')) /* line 21 */;
		echo '">Mods</a></li>
	</ul>

	
';
		$this->renderBlock('content', [], 'html') /* line 25 */;
		echo "\n";
		$this->renderBlock('scripts', get_defined_vars()) /* line 27 */;
		echo '</body>
</html>
';
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['flash' => '11'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}


	/** {block scripts} on line 27 */
	public function blockScripts(array $ʟ_args): void
	{
		echo '	<script src="https://unpkg.com/nette-forms@3/src/assets/netteForms.js"></script>
';
	}
}
