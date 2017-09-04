<?php 
namespace Gbs\Translator;

require_once("Translator.php");
require_once("WordTranslator.php");

/*
TODO:

- Add unit tests: https://phpunit.de/getting-started.html
- Swap tabs for spaces.
- Explain that faster more memory efficient would be to process the input serially, parsing the input string chunk-by-chunk
  and spitting out the translation.  For processing very large inputs from file this could load and process from an internal buffer
- Error handling.
- Needs to autoload the WordTranslator class?
*/
/*
// This class provides translation from English to Pig Latin.
class PigLatinTranslator extends Translator
{
	// Constructor can take an array of translation options (or none).
	public function __construct($options = null)
	{
// TODO: Set up options for translation.

		parent::__construct();
		$this->wordClass = "Gbs\Translator\WordTranslator";
		
	}

// TODO - get rid of this wrapper function?	
	// Return the supplied English text as a Pig Latin translation.
	public function translateEnglish($text)
	{	
		$pigLatinText = $this->translate($text);
		return $pigLatinText;
	}

}
*/
// Tests.
$englishText = "This is a simple test of English to Pig Latin translation. Also test that 'quote' is ok.";
$pigLatinTranslator = new Translator("Gbs\Translator\WordTranslator");
$pigLatinText = $pigLatinTranslator->translate($englishText);

ECHO "$englishText\n";
ECHO "In Pig Latin:\n";
ECHO "$pigLatinText\n";

