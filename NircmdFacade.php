<?php

declare ( strict_types = 1 );

namespace Nouvu\Windows;

use Error;
use Psr\Log\LoggerInterface;

final class Nircmd
{
	public function __construct ( 
		private string $nircmd = 'nircmd.exe', 
		private ?LoggerInterface $logger = null
	) 
	{
		if ( strtoupper ( substr ( \PHP_OS, 0, 3 ) ) !== 'WIN' )
		{
			throw new Error( 'This feature only works on the Windows operating system.' );
		}
	}
	
	private function addQuotes( string | int | float ...$add ): string
	{
		return '"' . implode ( '" "', array_filter ( $add, fn( $v ): bool => ! is_null ( $v ) ) ) . '"';
	}
	
	private function execute( string $name, string | int | float ...$arguments ): array
	{
		$output = [];
		
		$string = rtrim ( "{$this -> nircmd} {$name} " . implode ( ' ', $arguments ) );
		
		exec ( $string, $output );
		
		$this -> logger ?-> info( $string, $output );
		
		return $output;
	}
	
	public function abortshutdown(): void
	{
		$this -> execute( __FUNCTION__ );
	}
	
	public function beep( int $frequency, int $duration ): void
	{
		$this -> execute( __FUNCTION__, $frequency, $duration );
	}
	
	public function cdrom( string $action, string $drive = '' ): void
	{
		if ( in_array ( $action, [ 'open', 'close' ] ) )
		{
			$this -> execute( __FUNCTION__, $action, ( $drive ? rtrim ( $drive, ':' ) . ':' : '' ) );
			
			return;
		}
		
		throw new Error( "The [action] parameter can be 'open' or 'close'." );
	}
	
	public function changeappvolume( string $process, float | int $volume, string | int $device = '' ): void
	{
		$this -> execute( __FUNCTION__, $process, $volume, $device );
	}
	
	public function changebrightness( int $level, int $mode = 3 ): void
	{
		if ( 1 > $mode && $mode > 3 )
		{
			throw new Error( "The [mode] parameter can be 1, 2, or 3." );
		}
		
		$this -> execute( __FUNCTION__, $level, $mode );
	}
	
	public function changesysvolume( int $volume, string $component = 'master', string | int $device = '' ): void
	{
		$this -> execute( __FUNCTION__, $volume, $this -> addQuotes( $component ), $device );
	}
	
	public function changesysvolume2( int $left, int $right, string $component = 'master', string | int $device = '' ): void
	{
		$this -> execute( __FUNCTION__, $left, $right, $this -> addQuotes( $component ), $device );
	}
	
	public function clipboard( string $action, string | int | float $parameter = null ): void
	{
		$this -> execute( __FUNCTION__, $action, $this -> addQuotes( $parameter ) );
	}
	
	public function clonefiletime( string $filename, string $wildcard ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $filename, $wildcard ) );
	}
	
	public function closeprocess( string $process ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $process ) );
	}
	
	public function cmdshortcut( string $folder, string $title, string $command ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $folder, $title ), $command );
	}
	
	public function cmdshortcutkey( string $folder, string $title, string $key, string $command ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $folder, $title, $key ), $command );
	}
	
	public function cmdwait( int $wait, string $command ): void
	{
		$this -> execute( __FUNCTION__, $wait, $command );
	}
	
	public function consolewrite( string $text ): void
	{
		$this -> execute( __FUNCTION__, $text );
	}
	
	public function convertimage( string $filename, string $to ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $filename, $to ) );
	}
	
	public function convertimages( string $wildcard, string $extension ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $wildcard ), $extension );
	}
	
	public function debugwrite( string $text ): void
	{
		$this -> execute( __FUNCTION__, $text );
	}
	
	public function dlg( string $process, string $title, string $action, string | int | float ...$parameters ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $process, $title ), $action, $this -> addQuotes( ...$parameters ) );
	}
	
	public function dlgany( string $process, string $title, string $action, string | int | float ...$parameters ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $process, $title ), $action, $this -> addQuotes( ...$parameters ) );
	}
	
	public function elevate( string $program, string $parameters ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $program, $parameters ) );
	}
	
	public function elevatecmd( string $cmd ): void
	{
		$this -> execute( __FUNCTION__, $cmd );
	}
	
	public function emptybin( string $drive = '' ): void
	{
		$this -> execute( __FUNCTION__, ( $drive ? rtrim ( $drive, ':' ) . ':' : '' ) );
	}
	
	public function exec( string $flag, string $app, string $command = '' ): void
	{
		if ( in_array ( $flag, [ 'show', 'hide', 'min', 'max' ] ) )
		{
			$this -> execute( __FUNCTION__, $flag, $this -> addQuotes( $app ), $command );
			
			return;
		}
		
		throw new Error( "The [flag] parameter can be show/hide/min/max." );
	}
	
	public function exec2( string $flag, string $folder, string $app, string $command = '' ): void
	{
		if ( in_array ( $flag, [ 'show', 'hide', 'min', 'max' ] ) )
		{
			$this -> execute( __FUNCTION__, $flag, $this -> addQuotes( $folder, $app ), $command );
			
			return;
		}
		
		throw new Error( "The [flag] parameter can be show/hide/min/max." );
	}
	
	public function execmd( string $cmd ): void
	{
		$this -> execute( __FUNCTION__, $cmd );
	}
	
	public function exitwin( string $type, string $option = '' ): void
	{
		$this -> execute( __FUNCTION__, $type, $option );
	}
	
	public function filldelete( string $delete ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $delete ) );
	}
	
	public function gac( string $action, string $parameter ): void
	{
		$this -> execute( __FUNCTION__, $action, $this -> addQuotes( $parameter ) );
	}
	
	public function hibernate( string $force = '' ): void
	{
		$this -> execute( __FUNCTION__, $force );
	}
	
	public function inetdial( string $name): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $name ) );
	}
	
	public function infobox( string $message, string $title ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $message, $title ) );
	}
	
	public function inidelsec( string $filename, string $section ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $filename, $section ) );
	}
	
	public function inidelval( string $filename, string $section, string $key ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $filename, $section, $key ) );
	}
	
	public function inisetval( string $filename, string $section, string $key, string | int | float $value ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $filename, $section, $key, $value ) );
	}
	
	public function initshutdown( string $message, int $time, string $reboot ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $message ), $time, $reboot );
	}
	
	public function killprocess( string $process ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $process ) );
	}
	
	public function lockws(): void
	{
		$this -> execute( __FUNCTION__ );
	}
	
	public function loop( int $count, int $milliseconds, string $command ): void
	{
		$this -> execute( __FUNCTION__, $count, $milliseconds, $command );
	}
	
	public function mediaplay( int $time, string $file ): void
	{
		$this -> execute( __FUNCTION__, $time, $this -> addQuotes( $file ) );
	}
	
	public function memdump( string $process, string $file, int $bytes, int $address, int $to, string $option = '' ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $process, $file, $bytes, $address, $to ), $option );
	}
	
	public function monitor( string $action ): void
	{
		if ( in_array ( $action, [ 'async_off', 'async_on', 'async_low', 'on', 'off', 'low' ] ) )
		{
			$this -> execute( __FUNCTION__, $action );
			
			return;
		}
		
		throw new Error( "The [action] parameter may contain the following values: on/off/low or async_on/async_off/async_low." );
	}
	
	public function movecursor( int $x, int $y ): void
	{
		$this -> execute( __FUNCTION__, $x, $y );
	}
	
	public function multiremote( string $cmd ): void
	{
		$this -> execute( __FUNCTION__, $cmd );
	}
	
	public function muteappvolume( string $process, int $mode, string | int $device = '' ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $process ), $mode, $device );
	}
	
	public function mutesubunitvolume( string $device, string $name, int $mode ): void
	{
		if ( 0 > $mode && $mode > 2 )
		{
			throw new Error( "The [mode] parameter can be 0, 1, or 2." );
		}
		
		$this -> execute( __FUNCTION__, $this -> addQuotes( $device, $name ), $mode );
	}
	
	public function mutesysvolume( int $action, string $component, string | int $device = '' ): void
	{
		$this -> execute( __FUNCTION__, $action, $this -> addQuotes( $component ), $device );
	}
	
	public function paramsfile( string $file, string $delimiters, string $char, string $command ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $file, $delimiters, $char ), $command );
	}
	
	public function qbox( string $message, string $title, string $program ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $message, $title, $program ) );
	}
	
	public function qboxcom( string $message, string $title, string $command ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $message, $title ), $command );
	}
	
	public function qboxcomtop( string $message, string $title, string $command ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $message, $title ), $command );
	}
	
	public function qboxtop( string $message, string $title, string $program ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $message, $title, $program ) );
	}
	
	public function rasdial( string $name, string $file = null, string $number = null ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $name, $file, $number ) );
	}
	
	public function rasdialdlg( string $name, string $file = null, string $number = null ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $name, $file, $number ) );
	}
	
	public function rashangup( string $name ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $name ) );
	}
	
	public function regdelkey( string $key ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $key ) );
	}
	
	public function regdelval( string $key, string $value ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $key, $value ) );
	}
	
	public function regedit( string $key, string $name ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $key, $name ) );
	}
	
	public function regsetval( string $type, string $key, string $name, string $value ): void
	{
		if ( in_array ( $type, [ 'sz', 'expand_sz', 'dword', 'binary' ] ) )
		{
			$this -> execute( __FUNCTION__, $this -> addQuotes( $type, $key, $name, $value ) );
			
			return;
		}
		
		throw new Error( "The [type] parameter can be sz, expand_sz, dword or binary." );
	}
	
	public function regsvr( string $type, string $file, string $log = null ): void
	{
		if ( in_array ( $type, [ 'reg', 'unreg' ] ) )
		{
			$this -> execute( __FUNCTION__, $type, $this -> addQuotes( $file, $log ) );
			
			return;
		}
		
		throw new Error( "The [type] parameter can be reg or unreg." );
	}
	
	public function remote( string $copy, string $computer, string $command ): void
	{
		$this -> execute( __FUNCTION__, $copy, $computer, $command );
	}
	
	public function restartexplorer(): void
	{
		$this -> execute( __FUNCTION__ );
	}
	
	public function returnval(): array
	{
		return $this -> execute( __FUNCTION__ );
	}
	
	public function runas( string $login, string $password, string $command ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $login, $password ), $command );
	}
	
	public function savescreenshot( string $filename, int $x, int $y, int $w, int $h ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $filename ), $x, $y, $w, $h );
	}
	
	public function savescreenshotfull( string $filename ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $filename ) );
	}
	
	public function savescreenshotwin( string $filename ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $filename ) );
	}
	
	public function screensaver(): void
	{
		$this -> execute( __FUNCTION__ );
	}
	
	public function screensavertimeout( int $timeout ): void
	{
		$this -> execute( __FUNCTION__, $timeout );
	}
	
	public function script( string $filename ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $filename ) );
	}
	
	public function sendkey( string | int $key, string $action ): void
	{
		if ( in_array ( $action, [ 'press', 'up', 'down' ] ) )
		{
			$this -> execute( __FUNCTION__, $key, $action );
			
			return;
		}
		
		throw new Error( "The [action] parameter can be reg or unreg." );
	}
	
	public function sendkeypress( string | int ...$keys ): void
	{
		$this -> execute( __FUNCTION__, ...$keys );
	}
	
	public function sendmouse( string $name, string | int $x, string | int $y = null ): void
	{
		$this -> execute( __FUNCTION__, $name, $x, $y );
	}
	
	public function service( string ...$args ): void
	{
		$list = [ 'start', 'stop', 'pause', 'continue', 'restart', 'auto', 'manual', 'disabled', 'boot', 'system' ];
		
		$func = fn( string $a ): bool => in_array ( $a, $list );
		
		$bool = match ( func_num_args () )
		{
			2 => $func( $args[0] ),
			3 => $func( $args[1] ),
			default => throw new Error( 'Invalid number of incoming parameters.' )
		};
		
		if ( $bool )
		{
			$this -> execute( __FUNCTION__, ...$args );
			
			return;
		}
		
		throw new Error( sprintf ( 'The [action] parameter can be %s.', implode ( ', ', $list ) ) );
	}
	
	public function setappvolume( string $process, int | float $level, string $name ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $process, $level, $name ) );
	}
	
	public function setbrightness( int $level, int $mode = 3 ): void
	{
		$this -> execute( __FUNCTION__, ...func_get_args() );
	}
	
	public function setconsolecolor( int $forecolor, int $backcolor ): void
	{
		$this -> execute( __FUNCTION__, ...func_get_args() );
	}
	
	public function setconsolemode( int $mode ): void
	{
		$this -> execute( __FUNCTION__, $mode );
	}
	
	public function setcursor( int $x, int $y ): void
	{
		$this -> execute( __FUNCTION__, ...func_get_args() );
	}
	
	public function setcursorwin( int $x, int $y ): void
	{
		$this -> execute( __FUNCTION__, ...func_get_args() );
	}
	
	public function setdefaultsounddevice( string $name, int $role = 0 ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $name ), $role );
	}
	
	public function setdialuplogon( string ...$args ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( ...$args ) );
	}
	
	public function setdisplay( string | int ...$args ): void
	{
		$this -> execute( __FUNCTION__, ...$args );
	}
	
	public function setfilefoldertime( string ...$args ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( ...$args ) );
	}
	
	public function setfiletime( string ...$args ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( ...$args ) );
	}
	
	public function setprimarydisplay( string $monitor ): void
	{
		$this -> execute( __FUNCTION__, $monitor );
	}
	
	public function setprocessaffinity( string $process, int ...$cores ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $process ), ...$cores );
	}
	
	public function setprocesspriority( string $process, string $priority ): void
	{
		if ( in_array ( $priority, [ 'normal', 'low', 'belownormal', 'abovenormal', 'high', 'realtime' ] ) )
		{
			$this -> execute( __FUNCTION__, $this -> addQuotes( $process ), $priority );
			
			return;
		}
		
		throw new Error( "In the [priority] parameter, you can specify one of the following values: normal, low, belownormal, abovenormal, high, realtime." );
	}
	
	public function setsubunitvolumedb( string $device, string $subunit, int $decibel ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $device, $subunit ), $decibel );
	}
	
	public function setsysvolume( int $volume, string $component = 'master', int $device = null ): void
	{
		$this -> execute( __FUNCTION__, $volume, $this -> addQuotes( $component ), $device );
	}
	
	public function setsysvolume2( int $left, int $right, string $component = 'master', int $device = null ): void
	{
		$this -> execute( __FUNCTION__, $left, $right, $this -> addQuotes( $component ), $device );
	}
	
	public function setvolume( int ...$args ): void
	{
		$this -> execute( __FUNCTION__, ...$args );
	}
	
	public function shellcopy( string $filename, string $destination, string ...$flags ): void
	{
		$list = [ 'yestoall', 'noerrorui', 'silent', 'nosecattr' ];
		
		if ( func_num_args() == 0 || empty ( array_diff ( $flags, $list ) ) )
		{
			$this -> execute( __FUNCTION__, $this -> addQuotes( $filename, $destination ), ...$flags );
			
			return;
		}
		
		throw new Error( 'In the Flags section, you can specify one or more of the following values: ' . implode ( ', ', $flags ) );
	}
	
	public function shellrefresh(): void
	{
		$this -> execute( __FUNCTION__ );
	}
	
	public function shexec( string $operation, string $filename ): void
	{
		if ( in_array ( $operation, [ 'open', 'print' ] ) )
		{
			$this -> execute( __FUNCTION__, $this -> addQuotes( ...func_get_args() ) );
			
			return;
		}
		
		throw new Error( 'The [operation] parameter can be "open" or "print".' );
	}
	
	public function shortcut( string | int ...$args ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( ...$args ) );
	}
	
	public function showsounddevices(): void
	{
		$this -> execute( __FUNCTION__ );
	}
	
	public function speak( string $type, string $fileText, int $rate = null, int $volume = null, string $filename = null, string $format = null ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( ...func_get_args() ) );
	}
	
	public function standby( string $force = null ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $force ) );
	}
	
	public function stdbeep(): void
	{
		$this -> execute( __FUNCTION__ );
	}
	
	public function sysrefresh( string $type = null ): void
	{
		if ( in_array ( $type, [ 'environment', 'policy', 'intl', null ], true ) )
		{
			$this -> execute( __FUNCTION__, $this -> addQuotes( $type ) );
			
			return;
		}
		
		throw new Error( 'You can specify one of the following values: environment, policy or intl.' );
	}
	
	public function trayballoon( string $title, string $text, string $icon, int $timeout ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $title, $text, $icon ), $timeout );
	}
	
	public function urlshortcut( string $url, string $folder, string $title ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( ...func_get_args() ) );
	}
	
	public function wait( int $milliseconds ): void
	{
		$this -> execute( __FUNCTION__, $milliseconds );
	}
	
	public function waitprocess( string $process, string $command ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( $process ), $command );
	}
	
	public function win( string | int ...$args ): void
	{
		$this -> execute( __FUNCTION__, $this -> addQuotes( ...$args ) );
	}
}