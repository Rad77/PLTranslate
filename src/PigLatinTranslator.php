<?php 

namespace Gbs\Translator;

require_once("Word.php");

// ToDo: Should I split out a generic translator and then subclass the Pig Latin version.
// Limitations: During translation I'm chucking out the whitespace and all other formatting (such as capitalisation)
// in order to keep the translation code minimal and concentrate on the overall "shape" rather than the 
// implementation detail.

/*
TODO:

- Inherit from base translator

- Add unit tests: https://phpunit.de/getting-started.html
- Swap tabs for spaces.
- Explain that faster more memory efficient would be to process the input serially, parsing the input string chunk-by-chunk
  and spitting out the translation.  For processing very large inputs from file this could load and process from an internal buffer
- Error handling.

*/


class Translator
{
}

// This class provides translation from English to Pig Latin.
class PigLatinTranslator extends Translator
{
	private $englishText = "";
	private $pigLatinText = "";
	
	
	// Constructor can take an array of translation options (or none).
	public function __construct($options = null)
	{
		// Set up options.
TODO:
	
	}

// TODO - get rid of this wrapper function?	
	// Return the supplied English text as a Pig Latin translation.
	public function translateEnglish($text)
	{	
		$this->englishText = $text;
		$this->translate();
		return $this->pigLatinText;
	}
	
	// Translate the English text and store the Pig Latin output.
	private function translate()
	{
		$englishWords = $this->getWords();
		$pigLatinWords = [];	
		
		foreach($englishWords as $wordText)
		{
			$word = new Word($wordText);
			$pigLatinWords[] = $word->translate();
		}
		
		$this->pigLatinText = $this->reconstructText($pigLatinWords, $englishWords);
	}
	
	// Remove anything tricky from the input text, specifically punctuation. 
	// This makes the translation process simpler.
	private function preProcess($text)
	{
		$text = preg_replace("/\pP+/", " ", $text);				// Replace punctuation with spaces.
		return $text;
	}

	// Returns the original string with the words replaced by their translations.
	private function reconstructText($pigLatinWords, $englishWords)
	{
		$pigLatinText = $this->englishText;
		
		$startPos = 0;
		
		// Replace the English words in the original string with the PL equivalent.
		for($i = 0; $i < count($englishWords); $i++)
		{
			$startPos = $this->replaceFirstMatch($startPos, $englishWords[$i], $pigLatinWords[$i], $pigLatinText);	
			
			// Move the start point past the newly replaced word, so that there is no chance of replacing 
			// the wrong instance of the target string.
			$startPos += strlen($pigLatinWords[$i]);
		}
		
		return $pigLatinText;
	}
	
	// Replace the first match (only) of the 'from' string in the supplied text with the 'to' string.
	// Start searching at startPos and return the position after the replaced word 
	// (which will become the next startPos)
	function replaceFirstMatch($startPos, $from, $to, &$text)
	{	
		$pos = strpos($text, $from, $startPos);
		
		// This test should never fail.
		if ($pos !== false) 
		{
			$text = substr_replace($text, $to, $pos, strlen($from));
		}
		
		return $pos;
	}
	
	// Return an array containing all the words from the input string, in order or appearance.
	// (No attempt is made to de-dup, as this would make re-assembly more difficult)
	private function getWords()
	{
		$cleanText = $this->preProcess($this->englishText);
		$words = preg_split('/\s+/', $cleanText, -1, PREG_SPLIT_NO_EMPTY);
		return $words;
	}

}

// Tests.
$englishText = "This is a simple test of English to Pig Latin translation. Also test that 'quote' is ok.";
$pigLatinTranslator = new PigLatinTranslator();
$pigLatinText = $pigLatinTranslator->translateEnglish($englishText);

ECHO "$englishText\n";
ECHO "In Pig Latin:\n";
ECHO "$pigLatinText\n";

