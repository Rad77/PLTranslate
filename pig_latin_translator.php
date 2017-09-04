<?php 

//namespace Translator;

// ToDo: Should I split out a generic translator and then subclass the Pig Latin version.
// Limitations: During translation I'm chucking out the whitespace and all other formatting (such as capitalisation)
// in order to keep the translation code minimal and concentrate on the overall "shape" rather than the 
// implementation detail.


// This class provides translation from English to Pig Latin.
class PigLatinTranslator
{
	private $englishText = "";
	private $pigLatinText = "";
	
	private $consonantRegex;
	private $vowelRegex;

	// Constructor can take an array of translation options (or none).
	public function __construct($options = null)
	{
		// Set up options.
TODO:
		
		// Set up regex.
		$vowels = 'aeiou';
		$exception = 'qu';		// Treat this as a consonant group.
		
		$this->vowelRegex = '/^(['.$vowels.']+)(.*)/';
		$this->consonantRegex = '/^([^'.$vowels.']*)(.*)/';
		$this->exceptionRegex = '/^('.$exception.'+)(.*)/';
	}

// TODO - get rid of this wrapper function?	
	// Return the supplied English text as a Pig Latin translation.
	public function translateEnglish($text)
	{	
		$this->englishText = $this->preProcess($text);
		$this->translate();
		return $this->pigLatinText;
	}

	// Remove anything tricky from the input text, specifically uppercase characters and punctuation.  
	// The only reason that this is required is to side-step the shortcomings of the translation process itself.
	private function preProcess($text)
	{
		$text = strtolower($text);
		$text = preg_replace("/\pP+/", " ", $text);				// Replace punctuation with spaces.
//		$text = str_replace(" +", "_", $text);					// Replace multiple spaces with single.
		return $text;
	}
	
	private function translate()
	{
		$englishWords = $this->getWords();
		$pigLatinWords = [];	
		
		foreach($englishWords as $word)
		{
			$pigLatinWords[] = $this->translateWord($word);
		}
		
		$this->pigLatinText = implode(" ",$pigLatinWords);
	}

	private function getwords()
	{
		$words = preg_split('/\s+/', $this->englishText, -1, PREG_SPLIT_NO_EMPTY);
		return $words;
	}
	
// TODO: Split off the word functions into another class.
	private function translateWord($word)
	{
		if ($this->startsWithVowel($word))
		{
			$word .= "-ay";
		}
		elseif ($this->startsWithException($word))
		{	
			$word = preg_replace($this->exceptionRegex, "$2-$1ay", $word);
		}
		else
		{
			$word = preg_replace($this->consonantRegex, "$2-$1ay", $word);
		}
		return $word;
	}
	
	private function startsWithVowel($word)
	{
        return (preg_match($this->vowelRegex, $word) == 1);
	}
		
	private function startsWithException($word)
	{
        return (preg_match($this->exceptionRegex, $word) == 1);
	}
	
}

// Tests.
$englishText = "This is a simple test of English to Pig Latin translation. Also test that 'quote' is ok.";
$pigLatinTranslator = new PigLatinTranslator();
$pigLatinText = $pigLatinTranslator->translateEnglish($englishText);

$words = preg_split('/\s+/', $englishText, -1, PREG_SPLIT_NO_EMPTY);

print_r($words);
ECHO "$englishText\n";
ECHO "In Pig Latin:\n";
ECHO "$pigLatinText\n";
