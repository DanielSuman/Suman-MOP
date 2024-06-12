<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: /home/daniel/projekty/quickstart/quickstart/app/UI/Front/@form.latte */
final class Template_9d30900acb extends Latte\Runtime\Template
{
	public const Source = '/home/daniel/projekty/quickstart/quickstart/app/UI/Front/@form.latte';

	public const Blocks = [
		['controls' => 'blockControls', 'control' => 'blockControl'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		if ($this->global->snippetDriver?->renderSnippets($this->blocks[self::LayerSnippet], $this->params)) {
			return;
		}

		$form = $this->global->formsStack[] = is_object($ʟ_tmp = $name) ? $ʟ_tmp : $this->global->uiControl[$ʟ_tmp] /* line 4 */;
		Nette\Bridges\FormsLatte\Runtime::initializeForm($form);
		echo '<form';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), [], false) /* line 4 */;
		echo '>
';
		ob_start(fn() => '');
		try {
			echo '	<ul class="alert alert-danger">';
			ob_start();
			try {
				echo "\n";
				foreach ($form->ownErrors as $error) /* line 7 */ {
					echo '		<li>';
					echo LR\Filters::escapeHtmlText($error) /* line 7 */;
					echo '</li>
';

				}

				echo '	';

			} finally {
				$ʟ_ifc[0] = rtrim(ob_get_flush()) === '';
			}
			echo '</ul>
';

		} finally {
			if ($ʟ_ifc[0] ?? null) {
				ob_end_clean();

			} else {
				echo ob_get_clean();
			}
		}
		echo "\n";
		foreach ($form->getGroups() as $group) /* line 10 */ {
			echo '	<fieldset>
';
			$this->renderBlock('controls', [$group->getControls()] + [], 'html') /* line 11 */;
			echo '	</fieldset>
';

		}

		echo "\n";
		$this->renderBlock('controls', [$form->getControls()] + [], 'html') /* line 14 */;
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(end($this->global->formsStack), false) /* line 4 */;
		echo '</form>
';
		array_pop($this->global->formsStack);
		echo '



';
	}


	public function prepare(): array
	{
		$name = $this->params[0] ?? $this->params['name'] ?? null;
		unset($ʟ_args);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['error' => '7', 'group' => '10', 'control' => '20', 'key' => '54', 'foo' => '54'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}


	/** {define controls array $controls} on line 18 */
	public function blockControls(array $ʟ_args): void
	{
		extract($this->params);
		$controls = $ʟ_args[0] ?? $ʟ_args['controls'] ?? null;
		unset($ʟ_args);

		foreach ($iterator = $ʟ_it = new Latte\Essential\CachingIterator($controls, $ʟ_it ?? null) as $control) /* line 20 */ {
			if (!$control->getOption('rendered') && $control->getOption('type') !== 'hidden') /* line 21 */ {
				echo '	<div';
				echo ($ʟ_tmp = array_filter(['mb-3', 'row', $control->required ? 'required' : null, $control->error ? 'is-invalid' : null])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "" /* line 22 */;
				echo '>

		<div class="col-sm-3 col-form-label">';
				echo ($ʟ_label = Nette\Bridges\FormsLatte\Runtime::item($control, $this->global)->getLabel()) /* line 25 */;
				echo '</div>

		<div class="col-sm-9">
';
				$this->renderBlock('control', [$control] + [], 'html') /* line 28 */;
				if ($control->getOption('type') === 'button') /* line 29 */ {
					while ($iterator->nextValue?->getOption('type') === 'button') /* line 30 */ {
						echo '					';
						echo Nette\Bridges\FormsLatte\Runtime::item($iterator->nextValue, $this->global)->getControl()->addAttributes(['class' => 'btn btn-secondary']) /* line 31 */;
						echo "\n";
						$iterator->next() /* line 32 */;
					}
				}
				echo "\n";
				ob_start(fn() => '');
				try {
					echo '			<span class=invalid-feedback>';
					ob_start();
					try {
						echo LR\Filters::escapeHtmlText($control->error) /* line 37 */;

					} finally {
						$ʟ_ifc[1] = rtrim(ob_get_flush()) === '';
					}
					echo '</span>
';

				} finally {
					if ($ʟ_ifc[1] ?? null) {
						ob_end_clean();

					} else {
						echo ob_get_clean();
					}
				}
				ob_start(fn() => '');
				try {
					echo '			<span class=form-text>';
					ob_start();
					try {
						echo LR\Filters::escapeHtmlText($control->getOption('description')) /* line 38 */;

					} finally {
						$ʟ_ifc[2] = rtrim(ob_get_flush()) === '';
					}
					echo '</span>
';

				} finally {
					if ($ʟ_ifc[2] ?? null) {
						ob_end_clean();

					} else {
						echo ob_get_clean();
					}
				}
				echo '		</div>
	</div>
';
			}

		}
		$iterator = $ʟ_it = $ʟ_it->getParent();
	}


	/** {define control Nette\Forms\Controls\BaseControl $control} on line 44 */
	public function blockControl(array $ʟ_args): void
	{
		extract($this->params);
		$control = $ʟ_args[0] ?? $ʟ_args['control'] ?? null;
		unset($ʟ_args);

		if (in_array($control->getOption('type'), ['text', 'select', 'textarea', 'datetime', 'file'], true)) /* line 46 */ {
			echo '		';
			echo Nette\Bridges\FormsLatte\Runtime::item($control, $this->global)->getControl()->addAttributes(['class' => 'form-control']) /* line 47 */;
			echo '

';
		} elseif ($control->getOption('type') === 'button') /* line 49 */ {
			echo '		';
			echo Nette\Bridges\FormsLatte\Runtime::item($control, $this->global)->getControl()->addAttributes(['class' => 'btn btn-primary']) /* line 50 */;
			echo '

';
		} elseif (in_array($control->getOption('type'), ['checkbox', 'radio'], true)) /* line 52 */ {
			$items = $control instanceof Nette\Forms\Controls\Checkbox ? [''] : $control->getItems() /* line 53 */;
			foreach ($items as $key => $foo) /* line 54 */ {
				echo '		<div class="form-check">
			';
				echo Nette\Bridges\FormsLatte\Runtime::item($control, $this->global)->getControlPart($key)->addAttributes(['class' => 'form-check-input']) /* line 55 */;
				echo ($ʟ_label = Nette\Bridges\FormsLatte\Runtime::item($control, $this->global)->getLabelPart($key))?->addAttributes(['class' => 'form-check-label']) /* line 55 */;
				echo '
		</div>
';

			}

			echo "\n";
		} elseif ($control->getOption('type') === 'color') /* line 58 */ {
			echo '		';
			echo Nette\Bridges\FormsLatte\Runtime::item($control, $this->global)->getControl()->addAttributes(['class' => 'form-control form-control-color']) /* line 59 */;
			echo '

';
		} else /* line 61 */ {
			echo '		';
			echo Nette\Bridges\FormsLatte\Runtime::item($control, $this->global)->getControl() /* line 62 */;
			echo "\n";
		}
	}
}
