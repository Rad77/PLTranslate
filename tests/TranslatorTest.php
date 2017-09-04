<?php
require_once("src/Translator.php");
require_once("src/PLWordTranslator.php");

use PHPUnit\Framework\TestCase;
use Gbs\Translation;

/**
 * @covers Translator
 */
final class TranslatorTest extends TestCase
{    
	private function translate($input)
	{
		// Create a Pig Latin WordTranslator.
		$wordTranslator = new Translation\PLWordTranslator();
		
		// Set up and apply a PL dialect.
		$dialect = new Translation\Dialect();
		$dialect->separator = "";
		$dialect->vowelSuffix = "al";
		$dialect->consonantSuffix = "ay";
		
		$wordTranslator->setDialect($dialect);

		// Create a Translator using the PLWordTranslator.
		$pigLatinTranslator = new Translation\Translator($wordTranslator);

		// Translate the test data.
		$pigLatinText = $pigLatinTranslator->translate($input);
		
		return $pigLatinText;
	}

	public function testExpectTest1()
    {
		$input = "This is a simple test of English to Pig Latin translation.";
		$output = "Isthay isal aal implesay esttay ofal Englishal otay Igpay Atinlay anslationtray.";
        $this->expectOutputString($output);
		
		print $this->translate($input);
    }
	
	public function testExpectTest2()
    {
		$input = "Test that the word 'quote' is translated ok.";
		$output = "Esttay atthay ethay ordway 'otequay' isal anslatedtray okal.";
        $this->expectOutputString($output);
		
		print $this->translate($input);
    }
	
	public function testExpectTest3()
    {
		$input = "Test that the hyphenated words like 'in-laws' are translated ok.";
		$output = "Esttay atthay ethay enatedhyphay ordsway ikelay 'inal-awslay' areal anslatedtray okal.";
        $this->expectOutputString($output);
		
		print $this->translate($input);
    }
}

