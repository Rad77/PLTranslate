<?php 
namespace Gbs\Translation;

use Gbs\Translation;

// TODO: Put this in a bootstrap file?
/*
// Override the error handling, so that that we can catch everything.
if(!function_exists("generalErrorHandler")) {
	function generalErrorHandler($errorNumber, $errorString, $errorFile, $errorLine) 
	{
		throw new ErrorException($errorString, $errorNumber, 0, $errorFile, $errorLine);
	}
	set_error_handler("generalErrorHandler", E_ALL);
}
*/

class Translator
{	
	private $wordTranslator;
	private $sourceText;
	
	public function __construct($wordTranslator)
	{
// ToDO: enforce the IWordTranslator interface on this object somehow.		
		$this->wordTranslator = $wordTranslator;
	}
	
	// Translate and return the source text.
	public function translate($text)
	{
		try {
			$this->sourceText = $text;
			$inputWords = $this->getWords();
			$outputWords = [];	
		
			foreach ($inputWords as $wordText) {	
				$outputWords[] = $this->wordTranslator->translate($wordText);
			}
		} catch (\Exception $exception) {
			throw new \Exception("Translation failed");			
		}
		
		return $this->reconstructText($outputWords, $inputWords);
	}
	
	// Returns the original string with the words replaced by their translations.
	private function reconstructText($outputWords, $inputWords)
	{
		try	{
			$outputText = $this->sourceText;
			
			$startPos = 0;
			
			// Replace each word in the original string with the translated equivalent.
			for ($i = 0; $i < count($inputWords); $i++) {
				$startPos = $this->replaceFirstMatch($startPos, $inputWords[$i], $outputWords[$i], $outputText);	
				
				// Move the start point past the newly replaced word, so that there is no chance of replacing 
				// the wrong instance of the target string.
				$startPos += strlen($outputWords[$i]);
			}
		} catch (\Exception $exception) {
			throw new \Exception("Construction of translated text failed");			
		}
		
		return $outputText;
	}
	
	// Replace the first match (only) of the 'from' string in the supplied text with the 'to' string.
	// Start searching at startPos and return the position after the replaced word 
	// (which will become the next startPos)
	private function replaceFirstMatch($startPos, $from, $to, &$text)
	{	
		try	{
			$pos = strpos($text, $from, $startPos);
			
			assert($pos !== false); 	// This should never fail.
			
			$text = substr_replace($text, $to, $pos, strlen($from));
		}
		catch (\Exception $exception) {
			throw new \Exception("Replacement of word \"$from\" with \"$to\" failed");			
		}
		
		return $pos;
	}
	
	// Return an array containing all the words from the input string, in order or appearance.
	// (No attempt is made to de-dup, as this would make re-assembly more difficult)
	private function getWords()
	{
		$cleanText = $this->preProcess($this->sourceText);
		$words = preg_split('/\s+/', $cleanText, -1, PREG_SPLIT_NO_EMPTY);
		return $words;
	}
	
	// Remove anything tricky from the input text, specifically punctuation. 
	// This makes the translation process simpler.
	private function preProcess($text)
	{
		$text = preg_replace("/\pP+/", " ", $text);				// Replace punctuation with spaces.
		return $text;
	}

}