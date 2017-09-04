<?php 
namespace Gbs\Translator;

// This class handles all the "per word" processing needed for translation.
class Word
{
	private $text;			// Contains the original text of the word.
	private $lowerCase;		// Contains the text of the word in lowercase.
	
	// Set up the regex patterns statically.  They are all constant values 
	// that only need to be initialised once.
	private static $vowels = 'aeiou';
	private static $otherConsononts = 'qu';		// Treat this as a consonant group.
	private static $regex = null;

	public function __construct($word)
	{
		$this->text = $word;
		$this->lowerCase = strtolower($word);
	
		// Avoid re-initialising the static data for every word.
		if (is_null(self::$regex))
		{		
			self::$regex = new \stdClass();
			self::$regex->vowel = '/^(['.self::$vowels.']+)(.*)/';
			self::$regex->consonant = '/^([^'.self::$vowels.']*)(.*)/';
			self::$regex->otherConsononts = '/^('.self::$otherConsononts.'+)(.*)/';
		}
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
	public function translate()
	{
		$word = $this->lowerCase;
		
		if ($this->startsWithVowel())
		{
			$word .= "-ay";
		}
		elseif ($this->startsWithOtherConsonant())
		{	
			$word = preg_replace(self::$regex->otherConsononts, "$2-$1ay", $word);
		}
		else
		{
			$word = preg_replace(self::$regex->consonant, "$2-$1ay", $word);
		}
		
		if ($this->isCapitalized())
		{
			$word = ucfirst($word);
		}
		
		return $word;
	}
}