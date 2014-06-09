<?php

namespace Rixxi\Mail;

use Latte;
use Latte\Compiler;
use Latte\MacroNode;
use Latte\PhpWriter;


class MessageMacros extends Latte\Macros\MacroSet
{

	public static function install(Compiler $compiler)
	{
		$me = new static($compiler);
		$me->addMacro('subject', array($me, 'macroSubjectBegin'), array($me, 'macroSubjectEnd'));
		$me->addMacro('body', array($me, 'macroBodyBegin'), array($me, 'macroBodyEnd'));
	}


	public function macroSubjectBegin(MacroNode $node, PhpWriter $writer)
	{
		return 'ob_start();';
	}


	public function macroSubjectEnd(MacroNode $node, PhpWriter $writer)
	{
		return '$_message->setSubject(ob_get_clean());';
	}


	public function macroBodyBegin(MacroNode $node, PhpWriter $writer)
	{
		$node->data->html = $node->tokenizer->fetchWord() === 'html';
		return 'ob_start();';
	}


	public function macroBodyEnd(MacroNode $node, PhpWriter $writer)
	{
		return $node->data->html ? '$_message->setHtmlBody(ob_get_clean(), isset($_messageBasePath) ? $_messageBasePath : NULL);' :  '$_message->setBody(ob_get_clean());';
	}

}
