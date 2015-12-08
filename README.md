# pods-hookpress
Adding custom content webhooks to wordpress

## What it does
Adding this plugin will allow wordpress server with both pods and hookpress plugins installed to show and trigger POST
requests about custom content added with pods. This allows for flexible and convenient way to add content types and get 
notifications about them being saved and such.

## NOTE
This plugin was written as a need for a current project of mine. While writing it I had to learn PHP and the wordpress
System itself. This will not work without this PR -> https://github.com/mitcho/hookpress/pull/12

The features added here are for post saving of pods content and this lack the pre save hooks because I didn't need it.

So after reading this, if you need this plugin so make sure to PR every change and also let me know that this plugin is
in some way important.

