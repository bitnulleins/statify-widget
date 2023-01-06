=== Statify Widget ===
Contributors: bitnulleins
Tags: statify, widget, popular posts, custom post types, bit01, wordpress
Requires at least: 3.8
Tested up to: 4.9.4
Requires PHP: 5.6
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Widget um beliebte Inhalte (Seiten, Artikel...) anzeigen zu lassen. Basiert auf der Statistik von Statify.

== Description ==

Das *Statify Widget* zeigt die beliebtesten Inhalte anhand des [Statify](http://wordpress.org/plugins/statify/)-Plugin von Sergej Müller. Schnell und Übersichtlich.

= Statify =

Plugin für Besucherstatistiken mit Schwerpunkten Datenschutz, Transparenz und Übersichtlichkeit.

**Hinweis**: Dieses Widget funktioniert nur in Verbindung mit dem Statify Plugin.

= Eigene Inhaltstypen =

Eigene Inhaltstypen (Custom Post Types) werden unterstützt und können auch angezeigt werden.

= Intelligente Zusammenfassung =

Sollte es einmal verschiedene Pfade zu einem Inhalt geben fügt das Widget sie zusammen und addiert die Aufrufe.

= Aufrufe einzelner Inhalte =

Mit Hilfe des Shortcode `[statify-count]` lassen sich Aufrufe des aktuellen Beitrags oder Seite anzeigen. Mit den Optionen "prefix" und "suffix" lassen sich angezeigte Texte vor (Präfix) und nach (Suffix) den Anrufen kontrollieren:

`[statify-count prefix="Insgesamt" suffix="Aufrufe."]`

Ergebnis: Insgesamt 243 Aufrufe.

= Einstellungen =

Im Widget können folgende Einstellungen vorgenommen werden:

* Titel
* Inhaltstyp (Standard: Artikel)
* Anzahl (Standard: 5)
* Aufrufe anzeigen (Standard: Nein)

= Support =

Freundliche Fragen zum Widget beantworte ich gerne unter *Support*.

= Autor =

* Finn Dohrn
* [Webseite](http://www.bit01.de)

== Installation ==

Installiere zuvor das Plugin [Statify](http://wordpress.org/plugins/statify/) von Sergej Müller. Und anschließend aus dem Plugin Verzeichnis "Statify Widget" installieren und aktivieren.

Manuell:

1. Lade den Ordner "statify-widget" in den Plugin-Ordner (./wp-content/plugins/)
1. Aktiviere das Plugin auf deiner Seite
1. Füge unter Design > Widgets das "Satify Widget" hinzu

== Frequently Asked Questions ==

= Das Widget findet keine Einträge =

Dann hat Statify noch keine Einträge zur Statistik hinzugefügt.

= Seiten und Beiträge gemeinsam anzeigen =

Ja! Seit 1.1.4 geht das. Einfach im Widget Inhaltstyp: "Seiten und Beiträge" auswählen. Er zeigt dann die Standard Inhaltstypen "post" und "page" zusammen an.

= Aufrufe einzelner Artikel/Seiten anzeigen =

Mit dem Shortcode und Theme-Funktionen ist das möglich. Die Angabe eines Präfix und Suffix ist dabei nicht Pflicht:

`[statify-count prefix="Insgesamt" suffix="Aufrufe."]`

Folgende Funktionen geben im Theme die Anzahl Aufrufe für eine Artikel ID (`$post_id`) zurück. Ist keine ID angegeben, wird die Anzahl der aktuellen Seite zurück gegeben.

* `get_statify_count($post_id)` (nur die Anzahl, benötigt echo-Aufruf)
* `statify_count($post_id)` (mit fertigen Text)

Beispiel: `<?php echo get_statify_count(); ?> Aufrufe`

= Ich habe keine statische Seite als Startseite =

Kein Problem. Es wird ein Pseudo Eintrag "Startseite" angezeigt.

= Ich habe die Permalink-Struktur geändert =

Das ändert nichts. Das Plugin nimmt jeden Statify Eintrag und fügt Sie sinnvoll zusammen.

== Screenshots ==

1. Statify Widget Ergebnis
2. Statify Widget Einstellungen

== Changelog ==

= 1.1.4 =

* Inhaltstyp: "Beiträge und Seiten" hinzugefügt um gemeinsam anzuzeigen
* Aufrufe für Artikel Shortcode und Theme Funktion

= 1.1.3 =

* Aufnahme der Weiterentwicklung und getestet für WordPress 4.7.6

= 1.1.2 =
* Korrekturen in der Validierung

= 1.1.1 =
* Benutzerdefinierter Text für die Anzahl der Aufrufe
* Nicht benutztes require_once() entfernt
* span-Element um die Anzahl der Aufrufe hinzugefügt

= 1.1 =
* Begrenzung der Datensätze aufgehoben
* title-Attribut zu den Links hinzugefügt

= 1.0 =
* Veröffentlichung der ersten Version

== Upgrade Notice ==

Keine Upgrades.
