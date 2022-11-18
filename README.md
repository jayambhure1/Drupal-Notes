# Drupal-Notes


**Installing PHPCS for Drupal** 
	1) composer global require drupal/coder
	2) composer require acquia/coding-standards

**How to use PHPCS**
- C:\Users\username\AppData\Roaming\Composer\vendor\bin>phpcs --standard=AcquiaDrupalStrict --extensions=php,module,inc,install,test,profile,theme,info,txt,md,yml "Path of yout Folder"


**For Enbled Module by Default.**
- config/default/core.extension.yml

**Open Auth Consumer Public and Private Key**
Folder Path : D:/key/public.key
- openssl genrsa -out private.key 2048
- openssl rsa -in private.key -pubout > public.key

**Add this line to show all errors in Drupals**
- $config['system.logging']['error_level'] = 'verbose';

**Close Commit Editor :**
- :wq

**Adding Pach in to module :**
1) Download module with verstion using git 
2) then create new branch 
3) Add your changes in new repo
4) Then git hub
 > git diff --no-prefix import > content_sync.patch
		
**Create config files using drush commad :**
1) C:\xampp\htdocs\cmacgm  here open git bash and run below 
	> alias drush="vendor//drush//drush//drush.bat"
2) Run Command -> drush cex
3) Result : all config list there you done the changes
4) Then Enter -> Yes
5) for checking this file open cmacgm/config

**Bypass SSO Using Drush**
> C:\xampp\htdocs\cmacgm  
1) here open git bash and run below
2) alias drush="vendor//drush//drush//drush.bat"
3) Run Command -> drush uli
4)Result will come like this way :
  [warning] default does not appear to be a resolvable hostname or IP, not starting browser. You may need to use the --uri option in your command or site alias to indicate the correct URL of this site.
  > default/user/reset/1/1647932882/SM5VX1MvoV473uc5bSPIh4c52HNZDbvku7MShubxTAM/login
5) Update Default path with new path

**Importnant GIT commant**
> Git clone http:url
> Git remote -v
> git remote rm origin
> git remote add origin origin_path
> git branch -a
> git pull origin
> git checkout dev
> git pull
> git checkout -b feature/ticketname
 Add in to folder

> git status or git diff
> git add .
> git commit -m "msg"
> git push 


    
