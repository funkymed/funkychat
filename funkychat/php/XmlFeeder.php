<?php
function xmlEnTableau($fichier) {
   // fonction principale appelée par le script utilisateur
   $texte = xmlEnTexte($fichier);
   if ($texte) {
       list($xml_struct, $xml_index) = lireXML($texte);
       if (controleXmlOK($xml_struct, $xml_index))
           return xmlStructEnTableau($xml_struct);
       else return null;
   }
   else return null;
}
   
function xmlEnTexte($fichier_xml) {
   // supprime les espaces autour des tags
   // et transforme le fichier en un texte sans retour à la ligne
   $lignes = file($fichier_xml);
   $texte = "";
   foreach ($lignes as $ligne) $texte .= trim($ligne);
   return $texte;
}

function lireXML($texte) {
   // lit le code XML et le convertit en 2 tableaux $valeurs et $index
   $p = xml_parser_create();
   xml_parser_set_option($p, XML_OPTION_CASE_FOLDING, false);
   xml_parse_into_struct($p, $texte, $valeurs, $index);
   xml_parser_free($p);
   return array($valeurs, $index);
}

function controleXmlOK($valeurs, $index) {
   // contrôle la validité du fichier XML
   foreach ($index as $balises) {
       $ouvert = 0;
       foreach ($balises as $balise) {
           $type = $valeurs[$balise]["type"];
           if ($type =="open") $ouvert++;
           elseif ($type == "close") $ouvert--;
       }
       if ($ouvert == 0) return true;
   }
   return false;
}

function xmlStructEnTableau($xml_struct) {
   // boucle sur les éléments de $xml_struct (1er tableau généré par la fonction xml_parse_into_struct())
   // pour transformer ce tableau en un tableau utilisable pour PHP
   $pile = new PileXml();
 
   $tableau = array();
   $nom_tab = "\$tableau";
   $cpt=1;

   for ($i=0;$i<sizeof($xml_struct);$i++) {
       if ($i == 0) $pile->empiler($nom_tab, $xml_struct[0]["tag"]);
       elseif ($pile->estVide()) break;
       else {
           $xml_elt = $xml_struct[$i];
           switch ($xml_elt["type"]) {
               case "open" :
                   $nom_tab = $pile->sommetValeur();
						if ($xml_elt["tag"]=="User" || $xml_elt["tag"]=="item") {
							$nom_tab .= "[\"" . $xml_elt["tag"]."$cpt" . "\"]";
							$cpt++;
						}
						else
                       $nom_tab .= "[\"" . $xml_elt["tag"] . "\"]";

                   eval($nom_tab . "=array();");
                   $pile->empiler($nom_tab, $xml_elt["tag"]);
                   break;
               case "complete" :
               case "cdata" :  
                   $nom_tab = $pile->sommetValeur();
                   $xml_tag = $xml_elt["tag"];
                   $fils = $nom_tab . "[\"$xml_tag\"]";

					if (isset($xml_elt["value"])){
						if (strstr($xml_elt["value"],'_xx')!==false){
							if ($_SESSION['langue']=="fr") 
								$xml_elt["value"]=str_replace('_xx','',$xml_elt["value"]);
							else 
								$xml_elt["value"]=str_replace('_xx','_'.$_SESSION['langue'],$xml_elt["value"]);
						}
						eval($fils . "=\"" . htmlspecialchars($xml_elt["value"]) . "\";");}
					else eval($fils . "=\"" ."" . "\";");
                   break;
               case "close" :
                   if ($pile->sommetComparerBalise($xml_elt["tag"])) $nom_tab = $pile->depiler();
                   else break;
           }
       }
   }

   if ($pile->estVide() && ($i == sizeof($xml_struct))) {
	$tableau["maxelements"]=$cpt-1;
	return $tableau;}
   else return null;
}


// classe PileXml servant à la fonction xmlStructEnTableau

class PileXml {
   var $elements;
   
   function PileXml() {
       $this->elements = array();
   }
   
   // méthodes publiques

   function empiler($valeur, $balise) {
       $obj = new ElementPile($valeur, $balise);
       array_push($this->elements, $obj);
   }

   function depiler() {
       if ($this->estVide()) return null;
       else {
           $obj = array_pop($this->elements);
           return $obj;
       }
   }
   
   function sommetValeur() {
       return $this->elements[$this->sommet()]->valeur;
   }
   
   function incrementerFils() {
       if ($this->estVide()) return null;
       else return $this->elements[$this->sommet()]->nb_fils++;
   }

   function sommetComparerBalise($nom_tag) {
       return $this->elements[$this->sommet()]->balise == $nom_tag;
   }

   function estVide() {
       if (sizeof($this->elements)) return false;
       else return true;
   }

   // méthode privée
   
   function sommet() {
       return sizeof($this->elements) - 1;
   }
   
}

// classe des éléments de la pile

class ElementPile {
   var $valeur;
   var $balise;
   var $nb_fils;

   function ElementPile($valeur, $balise) {
       $this->valeur = $valeur;
       $this->balise = $balise;
       $this->nb_fils = 0;
   }
}
?>