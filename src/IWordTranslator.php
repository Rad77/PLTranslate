<?php 
namespace Gbs\Translation;

interface IWordTranslator
{
	public function translate($word);
	public function setDialect($dialect);
}
