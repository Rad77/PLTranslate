<?php 

require_once("vendor/autoload.php");

use Gbs\Translation;

function getResultMessage($output, $expects)
{
	if ($output == $expects) {
		$result = "PASS";
	} else {
		$result = "FAIL";
	}
	
	return $result;
}


// Create a Pig Latin WordTranslator.
$wordTranslator = new Translation\PLWordTranslator();

// Set up and apply a custom PL dialect.
$dialect = new Translation\Dialect();
$dialect->separator = "";
$dialect->vowelSuffix = "way";
$dialect->consonantSuffix = "ay";

$wordTranslator->setDialect($dialect);

// Create a Translator using the PLWordTranslator.
$pigLatinTranslator = new Translation\Translator($wordTranslator);

// Run some tests.

// Test 1
$input = "This is a simple test of English to Pig Latin translation.";
$expects = "Isthay isway away implesay esttay ofway Englishway otay Igpay Atinlay anslationtray.";
$output = $pigLatinTranslator->translate($input);
$result = getResultMessage($output, $expects);

ECHO "\nTest 1: $result\n";
ECHO "\t$input\n";
ECHO "In Pig Latin:\n";
ECHO "\t$output\n";

// Test 2
$input = "Test that the word 'quote' is translated ok.";
$expects = "Esttay atthay ethay ordway 'otequay' isway anslatedtray okway.";
$output = $pigLatinTranslator->translate($input);
$result = getResultMessage($output, $expects);

ECHO "\nTest 2: $result\n";
ECHO "\t$input\n";
ECHO "In Pig Latin:\n";
ECHO "\t$output\n";

// Test 3
$input = "Test that the hyphenated words like 'in-laws' are translated ok.";
$expects = "Esttay atthay ethay enatedhyphay ordsway ikelay 'inway-awslay' areway anslatedtray okway.";
$output = $pigLatinTranslator->translate($input);
$result = getResultMessage($output, $expects);

ECHO "\nTest 3: $result\n";
ECHO "\t$input\n";
ECHO "In Pig Latin:\n";
ECHO "\t$output\n";

// Test 4
$input = "";
$expects = "";
$output = $pigLatinTranslator->translate($input);
$result = getResultMessage($output, $expects);

ECHO "\nTest 4: $result\n";
ECHO "\t$input\n";
ECHO "In Pig Latin:\n";
ECHO "\t$output\n";

// Test 5
$input = "a b c d e f g h i j k l m n o p q r s t u v w x y z";
$expects = "away bay cay day eway fay gay hay iway jay kay lay may nay oway pay qay ray say tay uway vay way xay yay zay";
$output = $pigLatinTranslator->translate($input);
$result = getResultMessage($output, $expects);

ECHO "\nTest 5: $result\n";
ECHO "\t$input\n";
ECHO "In Pig Latin:\n";
ECHO "\t$output\n";

// Test 6
$input = "     big...  \t\t ...gaps\n       and other ws\n";
$expects = "     igbay...  \t\t ...apsgay\n       andway otherway wsay\n";
$output = $pigLatinTranslator->translate($input);
$result = getResultMessage($output, $expects);

ECHO "\nTest 6: $result\n";
ECHO "\t$input\n";
ECHO "In Pig Latin:\n";
ECHO "\t$output\n";
