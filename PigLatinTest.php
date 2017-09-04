<?php 
require_once("src/Translator.php");
require_once("src/PLWordTranslator.php");

use Gbs\Translation;

/*
TODO:

- Add unit tests: https://phpunit.de/getting-started.html
- Add auto load
- Swap tabs for spaces.
- Explain that faster more memory efficient would be to process the input serially, parsing the input string chunk-by-chunk
  and spitting out the translation.  For processing very large inputs from file this could load and process from an internal buffer
- Error handling.

*/

// Tests.
$englishText = "This is a simple test of English to Pig Latin translation. Also test that 'quote' is ok.";

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

// Translate some test data.
$pigLatinText = $pigLatinTranslator->translate($englishText);

ECHO "$englishText\n";
ECHO "In Pig Latin:\n";
ECHO "$pigLatinText\n";

