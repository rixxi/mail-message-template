<?php

namespace Rixxi\Mail\DI;

use Nette;


class MessageTemplateExtension extends Nette\DI\CompilerExtension
{

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('messageTemplateFactory'))
			->setClass('Rixxi\Mail\MessageTemplateFactory');
	}

}
