<?php
// comment not returned to PHPEdit

function SimpleEcho()
{
  // SimpleEcho breakpoint marker
  echo "SimpleEcho=1\n";
}

function SimpleEchoBreakXdebug()
{
  // SimpleEchoBreakXdebug breakpoint marker
  xdebug_break();
  echo "SimpleEchoBreakXdebug=1\n";
}

function Signature()
{
	echo "PHPEdit Diagnostics script 3.6.6\n";
}

function CheckPHPVersion()
{
  echo "PHP_VERSION=\"" . PHP_VERSION. "\"\n";
  echo "VersionOk=\"" . version_compare(PHP_VERSION, '4.3'). "\"\n";
}

function GetFilePath()
{
  echo "__FILE__=\"" . __FILE__. "\"\n";
}

function CheckLoadedExtensions()
{
  function EchoExtensionLoaded($name)
  {
    echo "$name=\"" . extension_loaded($name). "\"\n";
  }

  EchoExtensionLoaded('xdebug');
  EchoExtensionLoaded('dbg');
}

function PhpinfoGeneral()
{
  ob_start();
  phpinfo(INFO_GENERAL);
  $result = str_replace('&nbsp;', ' ', ob_get_contents());
  ob_end_clean();
  echo "PhpInfoShowsXdebug=\"" . (strpos($result, 'with Xdebug') >= 0) . "\"\n";
}

function CheckPhpIni()
{
  function EchoSetting($name)
  {
    echo "$name=\"" . ini_get($name). "\"\n";
  }

  EchoSetting('xdebug.remote_enable');
  EchoSetting('xdebug.remote_connect_back');
  EchoSetting('xdebug.extended_info');
  EchoSetting('xdebug.profiler_enable');
  EchoSetting('xdebug.profiler_enable_trigger');
  EchoSetting('xdebug.profiler_output_dir');
  EchoSetting('xdebug.remote_host');
  EchoSetting('xdebug.remote_port');
  EchoSetting('xdebug.profiler_output_name');
  EchoSetting('debugger.enabled');
  EchoSetting('debugger.profiler_enabled');
  EchoSetting('debugger.JIT_enabled');
}

function AutoConfigure()
{
	echo "AUTO_REMOTE_ROOT=\"" . dirname(__FILE__) . "\"\n";
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		echo "AUTO_REMOTE_SYSTEM=\"Windows\"\n";
	} else {
		echo "AUTO_REMOTE_SYSTEM=\"Unix\"\n";
	}
	echo "AUTO_REMOTE_COMPUTERNAME=\"" . php_uname('n') . "\"\n";
	echo "AUTO_PROFILER_REMOTE_ROOT=\"" . ini_get('xdebug.profiler_output_dir') . "\"\n";
}

Signature();
switch ($_GET['action'])
{
  case 'checkPHPVersion':
    CheckPHPVersion();
    break;
  case 'getFilePath':
    GetFilePath();
    break;
  case 'checkLoadedExtensions':
    CheckLoadedExtensions();
    break;
  case 'phpinfoGeneral':
    PhpinfoGeneral();
    break;
  case 'checkPhpIni':
    CheckPhpIni();
    break;
  case 'simpleEchoBreakXdebug':
    SimpleEchoBreakXdebug();
    break;
  case 'simpleEcho':
    SimpleEcho();
    break;
  case 'test':
    echo 'Test';
    break;
  case 'autoConfigure':
    CheckPHPVersion();
  	AutoConfigure();
  	break;
  case 'getConfiguration':
    CheckPHPVersion();
    GetFilePath();
    CheckLoadedExtensions();
    PhpinfoGeneral();
    CheckPhpIni();
    SimpleEcho();
    SimpleEchoBreakXdebug();
    break;
}

?>