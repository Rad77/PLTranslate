<?php 
namespace Gbs\Translation;

class Dialect
{
	public $separator;
	public $vowelSuffix;
	public $consonantSuffix;	
}

// This class handles all the "per word" processing needed for Pig Latin translation.
class PLWordTranslator implements iWordTranslator
{
	private $text;			// Contains the original text of the word.
	private $lowerCase;		// Contains the text of the word in lowercase.
	
	// Set up the regex patterns statically.  They are all constant values 
	// that only need to be initialised once.
	private static $vowels = 'aeiou';
	private static $otherConsononts = 'qu';		// Treat this as a consonant group.
	private static $regex = null;
	
	private $dialect = null;
	
	public function __construct()
	{	
		// Avoid re-initialising the static data multiple times.
		if (is_null(self::$regex)) {		
			self::$regex = new \stdClass();
			self::$regex->vowel = '/^(['.self::$vowels.']+)(.*)/';
			self::$regex->consonant = '/^([^'.self::$vowels.']*)(.*)/';
			self::$regex->otherConsononts = '/^('.self::$otherConsononts.'+)(.*)/';
		}	
		
		$defaultDialect = new Dialect();
		$defaultDialect->separator = "-";
		$defaultDialect->vowelSuffix = "ay";
		$defaultDialect->consonantSuffix = "ay";
		
		$this->dialect = $defaultDialect;
	}
	
	public function setDialect($dialect)
	{
		$this->dialect = $dialect;
	}
	
	// Return true if the word starts with a vowel.
	private function startsWithVowel()
	{
        return (preg_match(self::$regex->vowel, $this->lowerCase) == 1);
	}
	
	// Return true if the word starts with one of the "other" consonant groups.
	private function startsWithOtherConsonant()
	{
        return (preg_match(self::$regex->otherConsononts, $this->lowerCase) == 1);
	}	
	
	// Return true if the first letter of the word is a capital.
	private function isCapitalized()
	{
		return preg_match("/^[A-Z]/", $this->text);
	}
	
	// Return the translation of the word's text.
	public function translate($word)
	{
		try	{
			$this->text = $word;
			$word = strtolower($word);
			$this->lowerCase = $word;
			
			if ($this->startsWithVowel()) {
				$word .= $this->dialect->separator.$this->dialect->vowelSuffix;
			} elseif ($this->startsWithOtherConsonant()) {	
				$word = preg_replace(self::$regex->otherConsononts, "$2{$this->dialect->separator}$1{$this->dialect->consonantSuffix}", $word);
			} else {
				$word = preg_replace(self::$regex->consonant, "$2{$this->dialect->separator}$1{$this->dialect->consonantSuffix}", $word);
			}
			
			if ($this->isCapitalized())	{
				$word = ucfirst($word);
			}
		} catch (\Exception $exception) {
			throw new \Exception("Translation of word \"$word\" failed");
		}
		
		return $word;
	}
}