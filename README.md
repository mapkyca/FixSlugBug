# Slugbug Fixer

This tool addresses the object anomalies produced by this issue (https://github.com/idno/Known/issues/1864)

This bug made it possible for multiple entities to have the same slug (and therefore the same url) IF the creating
user could not see the existing post due to ACL controls.

E.g.

* Alice creates a private post "example"
* Bob creates a public post "example".

Bob's post is given the same slug as Alice's post since he can't see it during creation. This leads to much hilarity during
listing and referencing, since getURL() will always create a link which addresses the newest post.

This tool also checks for a possible interaction between #1864 and an older bug #1741 (https://github.com/idno/Known/issues/1741), where
under these circumstances it is possible to have two entities with duplicate UUIDs.

There is unfortunately no automated way of fixing this issue, but this tool should at least detect them.

## Usage

* Install the plugin in the usual way
* BACK UP YOUR DATABASE!
* Either visit https://yoursite.com/admin/slugbug
* Or run the console application fix-slugbug

You also have the option of executing a dry run to check if the output looks ok.

## See

 * Author: Marcus Povey <http://www.marcus-povey.co.uk> 

