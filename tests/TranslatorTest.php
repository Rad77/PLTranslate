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
		$dialect->vowelSuffix = "way";
		$dialect->consonantSuffix = "ay";
		
		$wordTranslator->setDialect($dialect);

		// Create a Translator using the PLWordTranslator.
		$pigLatinTranslator = new Translation\Translator($wordTranslator);

		// Translate the test data.
		$pigLatinText = $pigLatinTranslator->translate($input);
		
		return $pigLatinText;
	}

	// Test simple translation.
	public function testExpectTest1()
    {
		$input = "This is a simple test of English to Pig Latin translation.";
		$output = "Isthay isway away implesay esttay ofway Englishway otay Igpay Atinlay anslationtray.";
        $this->expectOutputString($output);
		
		print $this->translate($input);
    }
	
	// Test 'qu' consonant group.
	public function testExpectTest2()
    {
		$input = "Test that the word 'quote' is translated ok.";
		$output = "Esttay atthay ethay ordway 'otequay' isway anslatedtray okway.";
        $this->expectOutputString($output);
		
		print $this->translate($input);
    }
	
	// Test hyphenated words.
	public function testExpectTest3()
    {
		$input = "Test that the hyphenated words like 'in-laws' are translated ok.";
		$output = "Esttay atthay ethay enatedhyphay ordsway ikelay 'inway-awslay' areway anslatedtray okway.";	
        $this->expectOutputString($output);
		
		print $this->translate($input);
    }
	
	// Test empty input string.
	public function testExpectTest4()
    {
		$input = "";
		$output = "";
        $this->expectOutputString($output);
		
		print $this->translate($input);
    }
	
	// Test difficult/nonsense input string.
	public function testExpectTest5()
    {
		$input = "a b c d e f g h i j k l m n o p q r s t u v w x y z";
		$output = "away bay cay day eway fay gay hay iway jay kay lay may nay oway pay qay ray say tay uway vay way xay yay zay";
        $this->expectOutputString($output);
		
		print $this->translate($input);
    }
	
	// Test extended whitespace input string.
	public function testExpectTest6()
    {
		$input = "     big...  \t\t ...gaps\n       and other ws\n";
		$output = "     igbay...  \t\t ...apsgay\n       andway otherway wsay\n";
        $this->expectOutputString($output);
		
		print $this->translate($input);
    }
		
}

