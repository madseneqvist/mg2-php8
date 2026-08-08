<?php
/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                     //
//                                    MG2 LANGAUGE FILE:                               //
//                                  http://www.minigal.dk                              //
//                                                                                     //
//                                         German                                      //
//                                                                                     //
//                               TRANSLATED BY: insaneDeich                            //
//                               EMAIL: support@minigal.dk                             //
//                                                                                     //
//                               LAST UPDATED: 11. May 2007                            //
//                                                                                     //
//         You are welcome to translate this file into your own language, but          //
//         be sure to check the Addon directory if your langauge is already            //
//         supported (http://addons.minigal.dk)                                        //
//                                                                                     //
//         Submit translated/updated language files to support@minigal.dk              //
//                                                                                     //
//         HOW TO TRANSLATE THIS FILE:                                                 //
//         Only edit the text to the right of the equal signs. Translate               //
//         this text to the language of your choice.                                   //
//         It is recommended to keep the letter cases intact in the                    //
//         finished translation. This will look the best.                              //
//                                                                                     //
/////////////////////////////////////////////////////////////////////////////////////////

// CHARSET INFORMATION AND LANGUAGE
$mg2->charset		= "utf-8";
$mg2->activelang	= "de";		// kh_mod 0.1.0 b3, ergänzt

//GALLERY LANGUAGE STRINGS
$mg2->lang['specialchars']								= "äöüßÄÖÜ";					// kh_mod 0.1.0 b3, ergänzt
$mg2->lang['wronglogin']								= "Falsches Passwort!";		// kh_mod 0.1.0 b3, ergänzt
$mg2->lang['gallery']									= "Galerie";
$mg2->lang['of']											= "von";
$mg2->lang['first']										= "Erstes";
$mg2->lang['prev']										= "Vorheriges";
$mg2->lang['next']										= "Nächstes";
$mg2->lang['last']										= "Letztes";
$mg2->lang['thumbs']										= "Thumbs";
$mg2->lang['exif_info']									= "Exif Informationen";		// kh_mod 0.2.0, geändert
$mg2->lang['model']										= "Modell";
$mg2->lang['shutter']									= "Belichtungszeit";			// kh_mod 0.1.0 rc1, geändert
$mg2->lang['viewslideshow']							= "Starte Diashow";
$mg2->lang['stopslideshow']							= "Stoppe Diashow";
$mg2->lang['aperture']									= "Blende";
$mg2->lang['flash']										= "Blitz";
$mg2->lang['focallength']								= "Brennweite";
$mg2->lang['mm']											= "mm";
$mg2->lang['exposurecomp']								= "Belichtungskorrektur";	// kh_mod 0.2.0, geändert
$mg2->lang['original']									= "Original";
$mg2->lang['metering']									= "Abmessung";
$mg2->lang['iso']											= "ISO";
$mg2->lang['seconds']									= "s";
$mg2->lang['page']										= "Seite";
$mg2->lang['all']											= "Alle";
$mg2->lang['fullsize']									= "Volle Größe";
$mg2->lang['name']										= "Name";
$mg2->lang['email']										= "e-Mail";
$mg2->lang['addcomment']								= "Kommentar hinzufügen";
$mg2->lang['commentadded']								= "Kommentar hinzugefügt";
$mg2->lang['commenterror']								= "FEHLER: Kommentar konnte nicht hinzugefügt werden!";	// kh_mod 0.1.0, ergänzt
$mg2->lang['commentexists']							= "HINWEIS: Kommentar existiert bereits!";					// kh_mod 0.1.0, geändert
$mg2->lang['commentmissing']							= "FEHLER: Nicht alle Felder korrekt ausgefüllt!";
$mg2->lang['emailerror']								= "FEHLER: eMail-Adresse ist fehlerhaft!";					// kh_mod 0.1.0, ergänzt
$mg2->lang['enterpassword']							= "Geben Sie das Passwort ein";
$mg2->lang['thissection']								= "Dieser Abschnitt ist passwortgeschützt";
// neu ab kh_mod 0.2.0
$mg2->lang['filenotreadable']							= "FEHLER: Datei nicht lesbar!";

// ADMIN LANGUAGE STRINGS
$mg2->lang['months']										= array('Jan','Feb','Mär','Apr','Mai','Jun','Jul','Aug','Sep','Okt','Nov','Dez'); // kh_mod 0.1.0 b3, ergänzt
$mg2->lang['root']										= "Root";
$mg2->lang['thumb']										= "Thumb";
$mg2->lang['dateadded']									= "Anzeigen ab";						// kh_mod 0.1.0, geändert
$mg2->lang['upload']										= "Lade Dateien hoch";
$mg2->lang['sourcefolder']								= "Quell-Ordner";						// kh_mod 0.1.0, ergänzt
$mg2->lang['import']										= "Importiere Dateien nach";
$mg2->lang['newfolder']									= "Neuer Ordner";
$mg2->lang['viewgallery']								= "Betrachte Galerie";
$mg2->lang['setup']										= "Einstellungen allgemein";		// kh_mod 0.1.0, geändert
$mg2->lang['logoff']										= "Abmelden";
$mg2->lang['menutxt_upload']							= "Hochladen";
$mg2->lang['menutxt_import']							= "Importieren";
$mg2->lang['menutxt_newfolder']						= "Neuer Ordner";
$mg2->lang['menutxt_viewgallery']					= "Betrachte Galerie";
$mg2->lang['menutxt_setup']							= "Einstellungen";
$mg2->lang['menutxt_logoff']							= "Abmelden";
$mg2->lang['delete']										= "Löschen";
$mg2->lang['cancel']										= "Abbrechen";
$mg2->lang['ok']											= "OK";
$mg2->lang['deletefolder']								= "Lösche Ordner";
$mg2->lang['navigation']								= "Navigation";
$mg2->lang['images']										= "Bild(er)";
$mg2->lang['filename']									= "Dateiname";
$mg2->lang['title']										= "Titel";
$mg2->lang['position']									= "Position";							// kh_mod 0.1.0, ergänzt
$mg2->lang['setpositions']								= "Bilderpositionen neu setzen";	// kh_mod 0.1.0, ergänzt
$mg2->lang['publish']									= "Anzeigen ab";						// kh_mod 0.1.0, ergänzt
$mg2->lang['notpublished']								= "Anzeige erst ab";					// kh_mod 0.1.0, ergänzt
$mg2->lang['nodisplay']								   = "Keine Anzeige";					// kh_mod 0.1.0, ergänzt
$mg2->lang['calendar']									= "Kalender";							// kh_mod 0.1.0, ergänzt
$mg2->lang['description']								= "Beschreibung";
$mg2->lang['setasthumb']								= "Setze als Ordnerthumb";
$mg2->lang['editfolder']								= "Bearbeitete Ordner";
$mg2->lang['editimage']									= "Bearbeite Bild";
$mg2->lang['nofolderselected']						= "Kein Ordner ausgewählt";
$mg2->lang['foldername']								= "Ordnername";
$mg2->lang['samefolders']								= "Erlaube gleiche Ordnernamen";	// kh_mod 0.1.0, ergänzt
$mg2->lang['newpassword']								= "Neues Passwort";
$mg2->lang['deletepassword']							= "Lösche Passwort";
$mg2->lang['introtext']									= "Einleitungstext";
$mg2->lang['introwidth']								= "Breite Einleitungstext (0 = inaktiv)";// kh_mod 0.1.0, ergänzt
$mg2->lang['moveto']										= "Verschiebe nach";
$mg2->lang['iID']											= "ID";
$mg2->lang['filesize']									= "Dateigröße";
$mg2->lang['width']										= "Breite";
$mg2->lang['height']										= "Höhe";
$mg2->lang['date']										= "Datum";
$mg2->lang['ascending']									= "Aufsteigend";
$mg2->lang['descending']								= "Absteigend";
$mg2->lang['newfolder']									= "Neuer Ordner";
$mg2->lang['password']									= "Passwort";
$mg2->lang['sortby']										= "Sortiere nach";
$mg2->lang['direction']									= "Anordnung";
$mg2->lang['sortfolder']								= "<sup>*</sup>Sortierung für Ordner erfolgt nach<br />&nbsp;&nbsp;dem Ordnernamen";	// kh_mod 0.1.0, ergänzt
$mg2->lang['gallerytitle']								= "Galerieüberschrift";
$mg2->lang['adminemail']								= "Administrator eMail";
$mg2->lang['language']									= "Sprache";
$mg2->lang['skin']										= "Skin (Galerie)";
$mg2->lang['dateformat']								= "Datumsformat";
$mg2->lang['foldericons']								= "Ordnericons <b>ohne</b> Thumbnails anzeigen";				// kh_mod 0.1.0, geändert
$mg2->lang['displayfile']								= "Dateinamen unter Thumbnails anzeigen";							// kh_mod 0.1.0, ergänzt
$mg2->lang['foldersort']								= "Alle Ordner sortieren nach";										// kh_mod 0.1.0, ergänzt
$mg2->lang['foldersetup']								= "Ordnereinstellung";													// kh_mod 0.1.0, ergänzt
$mg2->lang['allowcomments']							= "Kommentare anzeigen";												// kh_mod 0.1.0, geändert
$mg2->lang['jsvalidate']								= "Verifizieren per JavaScript";										// kh_mod 0.1.0, ergänzt
$mg2->lang['navtype']									= "Navigationstyp";														// kh_mod 0.1.0, ergänzt
$mg2->lang['copyright']									= "Urheberrechtshinweis";
$mg2->lang['passwordchange']							= "Ändere Passwort (3 x leer = keine Änderung)";
$mg2->lang['oldpasswordsetup']						= "Derzeitiges Passwort (Admin)";									// kh_mod 0.1.0, geändert
$mg2->lang['newpasswordsetup']						= "Neues Passwort (leer = benutzte gegenwärtiges)";			// kh_mod 0.1.0, geändert
$mg2->lang['newpasswordsetupconfirm']				= "Neues Passwort";
$mg2->lang['advanced']									= "Erweiterte Einstellungen";
$mg2->lang['indexfile']									= "Galerie Indexdatei";
$mg2->lang['imagefolder']								= "Bilderordner";															// kh_mod 0.1.0, ergänzt
$mg2->lang['allowedextensions']						= "Erlaubte Dateierweiterungen";										// kh_mod 0.1.0, geändert
$mg2->lang['imgwidth']									= "maximale Bildgröße (0 = inaktiv)";								// kh_mod 0.1.0, geändert
$mg2->lang['thumbquality']								= "Thumbnail Qualität in %";											// kh_mod 0.1.0, geändert
$mg2->lang['thumbwidth']								= "Thumbnail max. Breite in Pixel";									// kh_mod 0.1.0, ergänzt
$mg2->lang['thumbheight']								= "Thumbnail max. Höhe in Pixel";									// kh_mod 0.1.0, ergänzt
$mg2->lang['uploadimport']								= "Vergessen Sie nicht ihre Bilder nach dem Hochladen auch zu importieren!";
$mg2->lang['image']										= "Bild";
$mg2->lang['edit']										= "Editieren";
$mg2->lang['editcurrentfolder']						= "Editiere aktuellen Ordner";
$mg2->lang['deletecurrentfolder']					= "Lösche aktuellen Ordner";
$mg2->lang['by']											= "von";
$mg2->lang['loginagain']								= "Neu anmelden";
$mg2->lang['securitylogoff']							= "Sicherheitsabmeldung";
$mg2->lang['autologoff']								= "Sie wurden automatisch nach $mg2->accesstime Minuten Inaktivität abgemeldet.";	// kh_mod 0.1.0, geändert
$mg2->lang['logoff']										= "Abmelden";
$mg2->lang['forsecurity']								= "Aus Sicherheitsgründen wird empfohlen dieses Browserfenster zu schliessen!";
$mg2->lang['upgradenote']								= "<b><a href=\"http://www.minigal.dk/download.php\" target=\"blank\">Diese Installation ist X Tage alt. Klicken sie hier um eine neuere Version zu installieren!</a></b>";
$mg2->lang['updatesuccess']							= "Update erfolgreich";
$mg2->lang['iDB_error']									= "FEHLER: Konnte Bild-Datenbank nicht aktualisieren!";		// kh_mod 0.1.0, ergänzt
$mg2->lang['fDB_error']									= "FEHLER: Konnte Ordner-Datenbank nicht aktualisieren!";	// kh_mod 0.1.0, ergänzt
$mg2->lang['nopictureid']								= "FEHLER: Bild-ID ".$_REQUEST['iID']." nicht gefunden!";		// kh_mod 0.1.0, ergänzt
$mg2->lang['renamefailure']							= "FEHLER: Dateiname enthält verbotene Zeichen!";
$mg2->lang['filenotdeleted']							= "FEHLER: Konnte Datei nicht löschen!";					// kh_mod 0.1.0, ergänzt
$mg2->lang['filenotfound']								= "FEHLER: Datei nicht gefunden!";									// kh_mod 0.1.0, geändert
$mg2->lang['filenotselected']							= "FEHLER: Keine Datei ausgewählt!";								// kh_mod 0.1.0, ergänzt
$mg2->lang['nofilestoimport']							= "Keine Dateien zum Importieren!";									// kh_mod 0.1.0, geändert
$mg2->lang['alreadyexists']							= "bereits vorhandene Datei(en) nicht hochgeladen!";				// kh_mod 0.1.0, ergänzt
$mg2->lang['nofolderid']								= "FEHLER: Ordner-ID nicht gefunden!";								// kh_mod 0.1.0, ergänzt
$mg2->lang['foldernotempty']							= "FEHLER: Ordner nicht leer!";
$mg2->lang['folderdeleted']							= "Ordner gelöscht";
$mg2->lang['foldernotdeleted']						= "FEHLER: Konnte Ordner nicht löschen!";					// kh_mod 0.1.0, ergänzt
$mg2->lang['folderupdated']							= "Ordner aktualisiert";
$mg2->lang['foldererror']								= "FEHLER: Aktulisierung nicht gespeichert!";					// kh_mod 0.1.0, ergänzt
$mg2->lang['foldercreated']							= "Ordner erstellt";
$mg2->lang['settingssaved']							= "Einstellungen gespeichert";
$mg2->lang['nopwdmatch']								= "Einstellungen gespeichert<br /><br />FEHLER: Passwortabweichung! - Neues Passwort wurde nicht gespeichert!";
$mg2->lang['nothumbsize']								= "FEHLER: Größe der Thumbnails zu klein! - Neue Größe wurde nicht gespeichert!";		// kh_mod 0.1.0, ergänzt
$mg2->lang['file']										= "Datei";
$mg2->lang['files']										= "Dateien";
$mg2->lang['forbidden']									= "ungültige";														// kh_mod 0.1.0, ergänzt
$mg2->lang['filedeleted']								= "Datei gelöscht";
$mg2->lang['filesdeleted']								= "Dateien gelöscht";													// kh_mod 0.1.0, geändert
$mg2->lang['filesimported']							= "Datei(en) importiert";
$mg2->lang['filesuploaded']							= "Datei(en) hochgeladen";
$mg2->lang['filesrenamed']								= "Datei(en) automatisch umbenannt!";								// kh_mod 0.1.0, ergänzt
$mg2->lang['filesmovedto']								= "Datei(en) verschoben nach";
$mg2->lang['folder']										= "Ordner";
$mg2->lang['folders']									= "Ordner";
$mg2->lang['rebuild']									= "Erneuern";
$mg2->lang['rebuildimages']							= "Thumbnails neu erzeugen";											// kh_mod 0.1.0, geändert
$mg2->lang['rebuildsuccess']							= "Thumbnail neu generiert für";										// kh_mod 0.1.0, geändert
$mg2->lang['rebuilderror']								= "FEHLER: Thumbnail konnte nicht generiert werden!";			// kh_mod 0.1.0, ergänzt
$mg2->lang['rebuildempty']								= "Keine Thumbnails erzeugt, der Ordner ist leer!";			// kh_mod 0.1.0, ergänzt
$mg2->lang['donate']										= "MG2 ist kostenlose Software unter GPL-Lizenz. Sollten Sie diese Software nützlich finden, so spenden Sie bitte an den Autor, indem Sie auf den untenstehenden Link klicken.";	// kh_mod 0.1.0, geändert
$mg2->lang['therefrom']									= "davon";																	// kh_mod 0.1.0, add
$mg2->lang['from']										= "Von";
$mg2->lang['by']											= "von";
$mg2->lang['buttonmove']								= "Verschiebe";
$mg2->lang['buttondelete']								= "Lösche";
$mg2->lang['deleteconfirm']							= "Ausgewählte Dateien löschen?";
$mg2->lang['moveconfirm']								= "Ausgwählte Bilder verschieben?";									// kh_mod 0.1.0, ergänzt
$mg2->lang['commentnotread']							= "FEHLER: Kommentardatei nicht lesbar!";							// kh_mod 0.1.0, ergänzt
$mg2->lang['nocommentid']								= "FEHLER: Kommentar-ID nicht gefunden!";							// kh_mod 0.1.0, ergänzt
$mg2->lang['commentnotselected']						= "FEHLER: Kein Kommentar ausgewählt!";							// kh_mod 0.1.0, ergänzt
$mg2->lang['commentconfirm']							= "Ausgewählte Kommentare löschen?";								// kh_mod 0.1.0, ergänzt
$mg2->lang['commentsdeleted']							= "Kommentar(e) gelöscht von";										// kh_mod 0.1.0, geändert
$mg2->lang['commentupdated']							= "Kommentar aktualisiert von";										// kh_mod 0.1.0, ergänzt
$mg2->lang['comment']									= "Kommentar";
$mg2->lang['comments']									= "Kommentare";
$mg2->lang['layout']										= "Layout";																	// kh_mod 0.1.0, ergänzt
$mg2->lang['imagecolumns']								= "Bilderspalten";
$mg2->lang['imagerows']									= "Bilderzeilen";
$mg2->lang['viewfolder']								= "Betrachte Ordner";
$mg2->lang['viewimage']									= "Betrachte Bild";
$mg2->lang['viewgallery']								= "Betrachte Galerie";
$mg2->lang['rotateright']								= "Drehe Bild um 90° nach rechts";									// kh_mod 0.1.0, geändert
$mg2->lang['rotateleft']								= "Drehe Bild um 90° nach links";									// kh_mod 0.1.0, geändert
$mg2->lang['imagerotated']								= "Bild gedreht um";														// kh_mod 0.1.0, geändert
$mg2->lang['imagenotrotated']							= "FEHLER: Konnte Bild nicht drehen!";								// kh_mod 0.1.0, ergänzt
$mg2->lang['gifnotrotated']							= "FEHLER: GIF-Dateien können wegen Einschränkungen in der GD-Bibliothek nicht gedreht werden!";
$mg2->lang['help']										= "Hilfe";

// kh_mod 0.1.0, ergänzt
$mg2->lang['text']										= "Text";
$mg2->lang['icons']										= "Icons";
$mg2->lang['actions']									= "Aktionen";
$mg2->lang['uncheckall']								= "Alle abwählen";
$mg2->lang['checkall']									= "Alle auswählen";
$mg2->lang['backupcomplete']							= "Datenbank Backup vollständig";
$mg2->lang['slideshowdelay']							= "Slideshow Verzögerung (Sek.)";
$mg2->lang['htmlarea']									= "HTMLArea (WYSIWYG Editor)";
$mg2->lang['tooltips']									= "Tooltips (Mini Thumbs)";
$mg2->lang['websitelink']								= "Link zur Hauptseite (leer = inaktiv)";
$mg2->lang['websitetext']								= "Text für Link zur Hauptseite";
$mg2->lang['accesstime']								= "Logout für Adminbereich nach X Minuten Inaktivität";
$mg2->lang['pwdrecursiv']								= "Passwortabfrage von Ordnern rekursiv (Galerie)";
$mg2->lang['marknew']									= "Markierung neuer als X Tage (0 = inaktiv)";
$mg2->lang['folderempty']								= "Der Ordner ist leer!";
$mg2->lang['requestfolder']							= "Der angeforderte Ordner";
$mg2->lang['notexists']									= " existiert nicht!";
$mg2->lang['damaged']									= " ist beschädigt!";
$mg2->lang['noimage']									= "Das angeforderte Bild existiert nicht!";
$mg2->lang['logout']										= "Logout (alle Ordner)";
$mg2->lang['logoutok']									= "Logout erfolgreich!";
$mg2->lang['recorddeleted']							= "Datenbankeintrag gelöscht";
$mg2->lang['recordsdeleted']							= "Datenbankeinträge gelöscht";
$mg2->lang['backuplink']								= "Datenbank Backup";
$mg2->lang['viewlogfile']								= "Logdatei anzeigen";
$mg2->lang['version1']									= "Sie haben die neuste MG2 Version";
$mg2->lang['version2']									= "MG2 Version X ist verfügbar!";
$mg2->lang['version3']									= "Sie haben anscheinend eine <b>neuere</b> Version als online verfügbar!";
$mg2->lang['backtofolder']								= "Zurück zum Ordner";

// gelöschte ab kh_mod 0.2.0
$mg2->lang['deletethumb']								= "Lösche Thumb";
$mg2->lang['showexif']									= "Zeige Exif";

// geändert in kh_mod 0.2.0
$mg2->lang['permerror1']								= "Zugriffsfehler: Galerie Root-Verzeichnis benötigt Schreibrechte!";
$mg2->lang['permerror2']								= "Zugriffsfehler: Bilderverzeichnis '$mg2->imagefolder' benötigt Schreibrechte!";
$mg2->lang['permerror3']								= "Zugriffsfehler: Die Datei 'mg2db_idatabase.php' benötigt Schreibrechte!";
$mg2->lang['permerror4']								= "Zugriffsfehler: Die Datei 'mg2db_idatabase_temp.php' benötigt Schreibrechte!";
$mg2->lang['permerror5']								= "Zugriffsfehler: Die Datei 'mg2db_fdatabase.php' benötigt Schreibrechte!";
$mg2->lang['permerror6']								= "Zugriffsfehler: Die Datei 'mg2db_fdatabase_temp.php' benötigt Schreibrechte!";
$mg2->lang['whattodo1']									= "Setze das Galerie Verzeichnis 'data' auf chmod 777";
$mg2->lang['whattodo2']									= "Setze das Bilderverzeichnis '$mg2->imagefolder' auf chmod 777";
$mg2->lang['whattodo3']									= "Setze die Datei 'mg2db_idatabase.php' auf chmod 744";
$mg2->lang['whattodo4']									= "Setze die Datei 'mg2db_idatabase_temp.php' auf chmod 744";
$mg2->lang['whattodo5']									= "Setze die Datei 'mg2db_fdatabase.php' auf chmod 744";
$mg2->lang['whattodo6']									= "Setze die Datei 'mg2db_fdatabase_temp.php' auf chmod 744";
$mg2->lang['sendmail']									= "Neue Kommentare an Admin senden";
// $mg2->lang['exif info'] in: $mg2->lang['exif_info']

// neu ab kh_mod 0.2.0
$mg2->lang['forebiddenxtensions']					= "FEHLER: Unerlaubte Dateierweiterung(en)";
$mg2->lang['renamefailure_image']					= "FEHLER: Image-Datei konnte nicht umbenannt werden!";
$mg2->lang['renamefailure_thumb']					= "FEHLER: Thumb-Datei konnte nicht umbenannt werden!";
$mg2->lang['renamefailure_medium']					= "WARNUNG: Medium-Datei konnte nicht umbenannt werden!";
$mg2->lang['renamefailure_comment']					= "WARNUNG: Kommentar-Datei konnte nicht umbenannt werden!";
$mg2->lang['tryitagain']								= "Noch einmal versuchen";
$mg2->lang['maxupload']									= "Maximal möglicher Upload pro Formular";
$mg2->lang['overwrite']									= "Überschreibe Dateien";
$mg2->lang['logip']										= "IP und Host in Logdatei speichern";
$mg2->lang['dbimport']									= "Datenbank Import";
$mg2->lang['comments_convert']						= "Kommentare konvertieren";
$mg2->lang['randomicon']								= "Zufalls Icon";
$mg2->lang['defaulticon']								= "Standard Icon";
$mg2->lang['make']										= "Kamera";
$mg2->lang['software']									= "Software";
$mg2->lang['datetime']									= "Geändert am";
$mg2->lang['colorspace']								= "Farbraum";
$mg2->lang['photographer']								= "Fotograf";
$mg2->lang['imagetitle']								= "Bildtitel";
$mg2->lang['captcha']									= "Zeichencode (Grafik)";
$mg2->lang['lock']										= "Sperren";
$mg2->lang['unlock']										= "Freigeben";
$mg2->lang['lockcomments']								= "Ausgewählte Kommentare sperren?";
$mg2->lang['unlockcomments']							= "Ausgewählte Kommentare freigeben?";
$mg2->lang['allowentries']								= "Erlaube Kommentareinträge";
// end
?>
