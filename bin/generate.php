<?php

(@include_once __DIR__ . '/../vendor/autoload.php') || @include_once __DIR__ . '/../../../autoload.php';

use Avro\Generator\ProtocolGenerator;

$options = getopt ( "i:o:p:s:h", array("input:", "output:", "prefix:", "stringType:", "help") );

$error = false;
$error = ( !isset($options["i"]) && !isset($options["input"]) );
$error = ( !isset($options["o"]) && !isset($options["output"]) );

if ($error || isset($options["h"]) || isset($options["help"]))
  help();

if ( !isset($options["p"]) && !isset($options["prefix"]) )
  $namespace_prefix = null;
else 
  $namespace_prefix = (!isset($options["p"])) ? $options["prefix"] : $options["p"];
  
$input_dir = (!isset($options["i"])) ? $options["input"] : $options["i"];
$output_dir = (!isset($options["o"])) ? $options["output"] : $options["o"];
$string_type = (!isset($options["s"]))
                  ? (isset($options["stringType"]) ? $options["stringType"] : false)
                  : $options["s"];
$string_type = ($string_type == "java") ? true : false;

$generator  = new ProtocolGenerator();
$result = $generator->generates($input_dir, $output_dir, $namespace_prefix, $string_type);

function help() {
  echo "Generate protocol classes from avro protocol file (avpr extension)\n";
  echo "--input (-i) : Use -i or --input to specify the folder containing your avro protocol\n";
  echo "--output (-o) : Use -o or --output to specify the folder where the protocol classes will be written\n";
  echo "--prefix (-p) : Use -p or --prefix to specify a namespace prefix for the protocol classes\n";
  echo "--stringType (-s) : Use -s or --stringType java when you use the requestor with a java implementation using String instead of CharSequence\n";
  die();
}
