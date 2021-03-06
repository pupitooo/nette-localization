<?php

namespace Smartsupp\Localization;

use Nette;

class TranslatorFactory
{

	/** @var boolean */
	public $debugMode = false;

	/** @var array */
	public $alias = array();

	/** @var string Used as defaults */
	public $defaultLang = 'en';

	/** @var array Global sections, added to each translator */
	public $defaultSections = array();

	/** @var TranslatesLoader */
	private $loader;


	/**
	 * @param TranslatesLoader $loader
	 */
	public function __construct(TranslatesLoader $loader) {
		$this->loader = $loader;
	}


	/**
	 * Add language alias. If requested "$from" language, returned is translator with "$to" language.
	 * @param string $from
	 * @param string $to
	 */
	public function setAlias($from, $to) {
		$this->alias[$from] = $to;
	}


	/**
	 * @param string $lang
	 * @param array $sections
	 * @return Translator
	 */
	public function create($lang, array $sections = array()) {
		$translator = new Translator();
		$translator->debugMode = $this->debugMode;

		if(isset($this->alias[$lang])) {
			$lang = $this->alias[$lang];
		}

		$translates = array();
		foreach($this->defaultSections as $section) {
			$translates += $this->loader->loadTranslates($section, $lang, $this->getDefaultLang($section, $lang));
		}
		foreach($sections as $section) {
			$translates += $this->loader->loadTranslates($section, $lang, $this->getDefaultLang($section, $lang));
		}
		$translator->setTranslates($translates);

		return $translator;
	}


	/**
	 * Returns default language. Can be changed by user.
	 * @param string $section
	 * @param string $lang
	 * @return string
	 */
	protected function getDefaultLang($section, $lang) {
		return $this->defaultLang;
	}

}