Mailordie: yet another php mailform
====================================

`mail() or die()` is a short PHP script acting as a relay between your contact
forms placed on static websites or hosted on servers with no working mail()
function available. You can host a single instance of mailordie to provide a
contact form back-end to multiple websites.

Features
--------

* Uses GET form: you can use it from your other servers.
* Uses server-side configured tokens: your email adresses are hidden.
* Flexible: send any fields from your form.

What it currently lacks
-----------------------

* Security: prepare to be spammed.
* Attachements.
* Sorting form fields.
* Obvious stuff I can't remember.

Requirement
-----------

* A PHP host with a working `mail()` function.
* That's all folks.

Installation
------------

1. Edit and send mailordie.php on your server.
2. Create a form in your static site (have a look at example.html).
3. ????
4. Profit!!!
