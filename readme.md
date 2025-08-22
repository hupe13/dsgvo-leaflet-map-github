# DSGVO snippet for Leaflet Map and its Extensions Github Version

Contributors: hupe13  
Tags: dsgvo, gdpr, leaflet  
Tested up to: 6.8  
Stable tag: 3.0  
Requires at least: 6.0  
Requires PHP: 7.4  
License: GPLv2 or later  

Respect the DSGVO / GDPR when you use Leaflet Map and Extensions for Leaflet Map.

## Description

### GDPR

There is an official [WordPress plugin](https://wordpress.org/plugins/dsgvo-leaflet-map/) and it is not necessary for you to use this one. Unless you have a suggestion for an improvement or a new function and I ask you to test it.

According to the GDPR, the user must actively agree if content is to be loaded from third-party servers.  
The WordPress plugins <a href="https://wordpress.org/plugins/leaflet-map/">Leaflet Map</a> and <a href="https://wordpress.org/plugins/extensions-leaflet-map/">Extensions for Leaflet Map</a> are loading content from the defined tile servers as well as unpkg.com.  
This plugin requests the user's permission to load the maps.  
You can customize the text and use it on your own responsibility.

The plugin supports <a href="https://wordpress.org/plugins/theme-translation-for-polylang/">Theme and plugin translation for Polylang (TTfP)</a>.

### DSGVO

Es gibt ein offizielles [WordPress Plugin](https://de.wordpress.org/plugins/dsgvo-leaflet-map/) und es ist nicht nötig, dass du dieses hier verwendest. Es sei denn, du hast einen Vorschlag für eine Verbesserung bzw. eine neue Funktion und ich bitte dich, diese zu testen.

Laut DSGVO muss der Nutzer aktiv zustimmen, wenn Inhalte von Drittservern geladen werden sollen.  
Die WordPress-Plugins [Leaflet Map](https://de.wordpress.org/plugins/leaflet-map/) und [Erweiterungen für Leaflet Map](https://de.wordpress.org/plugins/extensions-leaflet-map/) laden Inhalte von den definierten Kachelservern sowie unpkg.com.  
Dieses kleine Snippet holt die Zustimmung des Nutzers zum Laden der Karten ein.  
Du kannst den Text anpassen und es auf eigene Verantwortung verwenden.  

Das Plugin unterstützt <a href="https://wordpress.org/plugins/theme-translation-for-polylang/">Theme and plugin translation for Polylang (TTfP)</a>.

## Documentation

Documentation in <a href="https://leafext.de/doku/dsgvo/">German</a>, <a href="https://leafext.de/en/doku/dsgvo/">English</a> and an <a href="https://leafext.de/extra/dsgvo-example/">example</a>.

## Screenshots

1. Settings <br>![Settings](.wordpress-org/screenshot-1.png)
2. Frontend <br>![Frontend](.wordpress-org/screenshot-2.png)

## Installation

* Install and configure the plugin <a href="https://wordpress.org/plugins/leaflet-map/">Leaflet Map</a>.
* Install and configure the plugin <a href="https://wordpress.org/plugins/extensions-leaflet-map/">Extensions for Leaflet Map</a>.
* Then install this plugin: Download the <a href="https://github.com/hupe13/extensions-leaflet-map-dsgvo/archive/refs/heads/main.zip">ZIP file</a> and install it on the plugin page of your WordPress installation.
* Go to Settings - Leaflet Map - Leaflet Map GDPR and get documentation and settings options.

Please install [leafext-update-github](https://github.com/hupe13/leafext-update-github) to get updates and keep an eye on this repository in case I've made any mistakes.

## Frequently Asked Questions

**Is that enough to comply with the GDPR?**

* I don't know, ask a law expert.

## Changelog

### 250822

* fixed: leafext_plugin_active did not work with network activated plugins
* The version 2.4 should be 3.0, as there were new shortcodes.
* Dealing with dependency frpm Extensions Leaflet Map if WP < 6.5

### Previous

[Changelog](https://github.com/hupe13/extensions-leaflet-map-dsgvo/blob/main/changes.md)
