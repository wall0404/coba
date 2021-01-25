# Coba

Uses Laravel, Vue, Vue-Router, Vuex, Passport

## Projekt einrichten

### 1. Composer installieren

https://getcomposer.org/

### 2. Node JS (npm) installieren

https://www.npmjs.com/get-npm



### 3. Github Desktop Client installieren

Graphische Benutzeroberfläche für Git installieren.
Anmelden und das Coba Projekt clonen.

https://desktop.github.com/

### 4. Server und MySql konfigurieren

#### Server
Welche Serveranwendung man nutzt spielt im Endeffekt keine große Rolle. Hauptsache PHP Version > 7.4 läuft
Es kann auch die PHP eigene Serveranwendung zur Entwicklung genutzt werden. Siehe dafür **Ende von Punkt 6**


#### MySql
Danach MySql installieren. Sinnvoll ist es mit Sicherheit auch eine grafische Oberfläche wie phpmyadmin zu installieren. Dafür gibt es auch genug Anleitungen im Internet :)

In MySql danach eine leere Datenbank erstellen. Als Name der DB bietet sich `coba` an.

### 5. ENV Datei anpassen

Die ENV Datei (`.../coba/.env`) enthält vertrauliche Informationen und ist von Rechner zu Rechner unterschiedlich.
Deshalb ist sie nicht im Github Projekt enthalten. Allerdings können einige Standard-Werte aus der `.../coba/.env.exmaple` entnommen werden, die danach dann noch angepasst werden müssen
Also Datei clonen
```console
cp .env.example .env
```
und zum Beispiel die DB Zugangsdaten eintragen

#### DB Zugangsdaten
In der ENV Datei `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, und `DB_PASSWORD` so anpassen, dass sie zu den Zugangsdaten von unserem MySql-Server passen. Als `DB_DATABASE` den Namen verwenden, der als Name für die leere DB angegeben wurde.



### 6. Projekt finalisieren

Um alle zusätzlichen Dependecies zu laden:
```console
composer install
npm install
php artisan key:generate
```

Alle erforderlichen Tabellen in der Datenbank erstellen und Datenbank mit ersten Beispiel Daten füllen. 
```console
php artisan migrate:fresh --seed
```




Coba nutzt **laravel mix** um alle Javascript und CSS Dateien in einzelne kompakte Datein zu verpacken. Um die Änderungen an einzelnen Dateien zu beobachten und in die Hauptdatei zu übernhemen müssen wir mit folgendem Befehl einen Watcher starten

```console
npm run watch
```

Jetzt gegebenenfalls den PHP Server in einem neuen Terminal Thread (also nicht den watch task abbrechen) starten:
```console
php artisan serve
```


### 7. Installation Testen

Die angezeigte URL kann geöffnet werden.

Zugangsdaten für Sebastian (Standard-Nutzer) sind:
```console
E-Mail: s.schmitt@example.net
Passwort: password
```


## Arbeiten mit Git

Jeder soll sich bitte selber über die grundsätzlichen Funktionen von Git informieren.
Im Folgenden einigen wir uns nur für eine einheitliche Vorgehensweise.

### Branch erstellen
Für eine User-Story/Feature wird ein neuer Branch erstellt und dort alle Änderungen getrackt.
Dafür wird der Branch vom aktuellen **develop** Branch geclont.

Nach einem Sprint werden alle Änderungen von Marc in den master Branch übernommen.

### Commits erstellen

### Änderungen pushen
