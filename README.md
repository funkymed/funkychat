#	FunkyChat Ajax/Php/Sql/Xml/Xsl version Beta 1
		by  Cyril Pereira <cyril.pereira@gmail.com>

	Prototype JavaScript framework, version 1.5.0
    	(c)by Sam Stephenson <sam@conio.net>

    Funkychat is release in Creative Commons licence

    EN http://creativecommons.org/licenses/by/2.0/fr/deed.en_GB
    FR http://creativecommons.org/licenses/by/2.0/fr/
    PT http://creativecommons.org/licenses/by/2.0/fr/deed.pt

##	Funkychat is a chat in Ajax/Php.

		- You can chat online with people,
		- Smilies allowed with shortkey like ':)'
		- Transform url directly without use the <a> tag
		- Save the conversation in Mysql or Xml.
		
##	Install :

###		SQL Mode (to choose this mode  : /php/config.php) :

			To install you need a MySQL database and PHP4 installed on your server (Apache)
			You need to create a table 'history' (see the file structure.sql)

			Edit the file  /php/config.php

			define ( "ARCHIVAGE"	, "SQL");
			define ( "BDD_HOST" 	, "localhost"   ); // Host
			define ( "BDD_LOGIN"	, "root"		); // Database UserName
			define ( "BDD_MDP"  	, "" 			); // Database Password
			define ( "BDD"			, "chat"		); // Database Name
			define ( "BDD_TABLE"	, "history" 	); // Table Database
			define ( "MAX_LINE"		, "40"			); // SQL only

			Upload the file online and that it.

###		XML mode (to choose this mode  : /php/config.php) :

			Edit the file  /php/config.php

			define ( "ARCHIVAGE"	, "XML");

			To install the chat, you need a server with Apache and PHP 4

			Upload the file online and that it.

###		Skin :

		Just edit this file : /css/css.css
