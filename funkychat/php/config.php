<?	
	include "functions.php";
	define ( "TIME_OUT" 	, 2   			); // Timeout Utilisateur
	define ( "BDD_HOST" 	, "localhost"   ); // Host
	define ( "BDD_LOGIN"	, ""			); // Database UserName
	define ( "BDD_MDP"  	, "" 			); // Database Password
	define ( "BDD"			, ""			); 	// Database Name
	define ( "BDD_TABLE"	, "history" 	); // Table Database
	define ( "MAX_LINE"		, "16"			); // SQL only
	define ( "ARCHIVAGE"	, "XML"			); // XML or SQL
	define ( "DIRECTORY"	, "../archives/"); // Archives directory
	
	if (ARCHIVAGE=="SQL"){
		$bdd=mysql_connect(BDD_HOST,BDD_LOGIN,BDD_MDP) or die("Impossible de se connecter à la base de données");
		@mysql_select_db(BDD) or die("Impossible de se connecter à la base de données");
	}
	
?>