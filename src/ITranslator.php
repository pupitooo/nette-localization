<?php

namespace Smartsupp\Localization;

interface ITranslator extends \Nette\Localization\ITranslator
{

	function setTranslates(array $dictionary);

	function getTranslates();

}