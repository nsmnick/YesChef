webpack-builder
==========

Webpack based compiler for SASS and JS that outputs to a Wordpress theme folder and can be cleanly removed from a development site for production.

1. Simply place a copy of the webpack-builder folder in the Wordpress site's root folder.
2. In the terminal navigate to the webpack-builder folder, e.g.
```
cd /Applications/MAMP/htdocs/wordpress/webpack-builder/
```
4. Run ```npm install```
5. Edit the '.env' file and change the 'PUBLIC_PATH_ROOT' variable to the path of your Wordpress themes folder. Change 'PUBLIC_FOLDER_NAME' to your theme folder name.
6. In the terminal run ```npm run build``` to compile all assets for production or ```npm run watch``` to run a development build that watches out for file changes. Live reload plugin is also supported.

That's it!


Other Notes

In the webpack-builder folder a
