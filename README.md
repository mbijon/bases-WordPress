# Bases WordPress

Bases is a starter repo for a basic WordPress site. It's a customized version of [Mark Jaquith's WordPress Skeleton](https://github.com/markjaquith/WordPress-Skeleton) repo.

It adds a bunch of plugins that I tend to use frequently on client projects. It also has some of the git-ness removed to make it easier for non-IT clients to manage with wp-admin and their standard update/backup processes.

## Server Config

* The web root will be the `/html` folder in this repo
* `local-config.php` and `wp-config.php` will be one level above root

## Questions & Answers

**Q:** Why remove all the things like submodules and `/shared/` from WordPress-Skeleton?
**A:** See the 'Customizations and Why' section. If those choices aren't useful to you feel free to start your own fork of WP-Skeleton or fork Bases.

**Q:** Will you no like the git-ness?  
**A:** Not relying entirely on git has more to do with client preferences. Mark may have been lucky with finding or training git-hungry clients, while this fork seems to work for more typical IT & update > backup processes.

**Q:** Will you accept pull requests?  
**A:** Unlikely. Since this is a stripped-down fork of Jaquith's WP-Skeleton it's likely only going to get updates is WP-Skeleton is updated.

**Q:** Will you add "Plugin X"?  
**A:** Unlikely. But feel free to share info about your plugin. If it fills a need for one of my clients and it's bug-free on a dozen or so sites, then I may add it here.

## Customizations and Why

* No more git submodules: Other than [submodules being a pain](http://alexking.org/blog/2012/03/05/git-submodules-vs-svn-externals), with bigger clients I've found that IT departments tend to have their own methods for managing externals that don't involve git. Smaller clients tend to prefer managing updates through the wp-admin & then running a backup, instead of the extra efforts needed to update externals via git.
* Added plugins. This is a quick-start for client projects, so these are either dev-helper tools or plugins I use on nearly every project.
* The `/content` folder was removed in favor of the default `/html/wp-content` path. This tends to make more sense to IT staffers with experience running a default/out-of-the-box WordPress config. And, if you need an external content path for dev the settings are limited to the dev block of `wp-config.php`
* Several empty content folders, like `/html/wp-content/uploads` are included to make strict or other custom permissions easier to address
