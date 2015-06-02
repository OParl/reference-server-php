![Build Status](https://badge.buildkite.com/552ff73604a4aa7d98f03caa8b80c5a697c8b543739d4bfe79.svg)

# OParl API - Serverreferenzimplementierung

Dies ist eine Referenzimplementierung der OParl-API. Eine Livedemo mit **Beispieldaten** ist unter
[demoserver.oparl.org](http://demoserver.oparl.org) verfügbar. 

## Mitentwickeln oder selbst hosten

Dieses Programm wird mit Hilfe des [Laravel 5.0](laravel/laravel) Frameworks in PHP 5.4 entwickelt.
Allgemeine Hinweise zum Aufsetzen einer lokalen Entwicklungsumgebung für Laravelanwendungen findet
sich in der [Dokumentation](http://laravel.com/docs/5.0/homestead). 

Die Umgebungsvariablen in `.env.example` sind die für Homestead funktionierenden Defaultwerte, daher
reicht es, diese einfach in eine `.env` zu kopieren.
 
### SQLite

Momentan gibt es noch die Möglichkeit, SQLite als Datenbankbackend zu benutzen. Dazu muss
in `.env` einfach `DB_DEFAULT=sqlite` gesetzt werden. Zusätzlich sollte die Existenz einer
Datenbank mit `touch storage/database.sqlite` sichergestellt werden.
 
**Die Benutzung von SQLite bringt u.U. signifikante Performanceeinbußen mit sich!**

### MySQL

Es wird empfohlen anstatt SQLite MySQL als Backend zu nutzen. Dazu muss natürlich die in
`.env` angegebene Datenbankverbindung funktionieren.

### Postgres

*Die Unterstützung für Postgres ist in Arbeit.*

### Datenbankmodel und Beispieldaten

Nach der Einrichtung der Datenbankverbindung ist es noch **notwendig** das Datenbankschema zu intialisieren.
Dazu ist einfach `php artisan migrate` auszuführen (Im Falle von MySQL oder Postgres innerhalb der Homestead VM!)

Wenn die Beispieldaten generiert werden sollen, kann dies mit `php artisan db:seed` getan werden.

## Nutzung der Referenzimplementierung als API für existente RIS

Es wird in Zukunft möglich sein, diese Referenzimplementierung als Grundlage für eine Einbindung von 
OParl in bestehende RIS-Systeme zu verwenden. Nähere Informationen dazu werden mit dem Release 
von OParl 1.0 veröffentlicht.
