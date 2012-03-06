<?php

namespace
{
$string = 'tasse';
$name = 'café';
$str = 'Ceci est une $string avec mon $name dedans.<br />';
echo $str;
eval( "\$str = \"$str\";" );
echo $str;

// Errors to exceptions.
function exception_error_handler($level, $message, $file, $line, $context) 
{
	printf('%s: %s in %s line %d', $level, $message, $file, $line);
    throw new \ErrorException(sprintf('%s: %s in %s line %d', $level, $message, $file, $line), 0, $level, $file, $line);
    return false;
}
set_error_handler('exception_error_handler', E_ALL);
}

namespace A\C
{
	class A
	{
		function plop()
		{
			return 3;
		}
	}
}

namespace A\B
{
	class A
	{
		function plop()
		{
			return 2;
		}
	}
}

namespace
{
//$a = eval("return 1;");
//echo $a;
//eval("echo 1");
echo 0;
$a = eval("namespace A { class A { function plop(){ return 1;}}; return new A(); }");
//$a = eval("namespace A { class A { function plop(){ return 1;}} }");
//eval("class A.A { function plop(){ return 1;}}");

//echo 1;
//$a = new A\A();
echo 2;
echo $a->plop();
echo 3;
}

?>