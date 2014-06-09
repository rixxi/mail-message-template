<?php

namespace Rixxi\Mail;

use Latte\Engine;
use Latte\Loaders\FileLoader;
use Latte\Loaders\StringLoader;
use Latte\ILoader as ILatteLoader;
use Nette;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\Mail\Message;


class MessageTemplateFactory
{

	/** @var ILatteFactory */
	private $latteFactory;


	public function __construct(ILatteFactory $latteFactory)
	{
		$this->latteFactory = $latteFactory;
	}


	/**
	 * @param string
	 * @param array
	 * @return Message
	 */
	public function createFromFile($file, $parameters = array())
	{
		return $this->createMessageFromTemplate(new FileLoader, $file, array(
			'_messageBasePath' => dirname($file),
		) + $parameters);
	}


	/**
	 * @param string
	 * @param array
	 * @return Message
	 */
	public function createFromString($contents, $parameters = array())
	{
		return $this->createMessageFromTemplate(new StringLoader, $contents, $parameters);
	}


	private function createMessageFromTemplate(ILatteLoader $loader, $name, $parameters)
	{
		$latte = $this->latteFactory->create();
		$latte->onCompile[] = function (Engine $latte) {
			MessageMacros::install($latte->getCompiler());
		};

		$latte
			->setLoader($loader)
			->renderToString($name, array(
					'_message' => $message = new Message
				) + $parameters);

		return $message;
	}

}