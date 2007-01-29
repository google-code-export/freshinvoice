Thanks for installing FreshInvoice.

How to become an admin:

Create a standard user.
Goto your database via PHPMyAdmin or SSH MySQL shell.

Give your user (table: klant) the usergroup 99.

Or via MySQL SHELL:
UPDATE klant SET usergroup='99' WHERE klantId='1';

Logout, and log back in.

Next, to automaticly create and send your invoices, we add a crontab (cronjob) or task (windows).
If you do not know how to do this, please ask your host.
Add the following code:

50 9 * * * /path/to/bin/php /path/to/cron.php

This crontab automaticly sends all your invoices and reminders at 9:50.
Change the numbers to your liking.

If you have any problems, comments, cheers or feature requests don't, hasitate to contact:

Arnoud Vermeer
FreshWay Innovations
a.vermeer@freshway.biz