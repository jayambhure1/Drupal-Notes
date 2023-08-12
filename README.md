# Drupal-Notes


**Installing PHPCS for Drupal** 
- composer global require drupal/coder
- composer require acquia/coding-standards

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
- Open Module Page Like: https://www.drupal.org/project/webform
- Then click on Version control
- Then select branch vertion and clone the Repo 
- Then create new branch and done your changes
  > git branch branch_name
- Then create path File 
  > git diff --no-prefix import > content_sync.patch
- Then added your file in composer.json inside patches
- Last Run composer update command
  > composer update drupal/module_name --with-all-dependencies
		
**Export and Import config files using drush commad :**
1) C:\xampp\htdocs\cmacgm  here open git bash and run below
   > alias drush="vendor//drush//drush//drush.bat"
3) Export Command
   > drush cex
4) Import Command
   > drush cim

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
- Git clone http:url
- Git remote -v
- git remote rm origin
- git remote add origin origin_path
- git branch -a
- git pull origin
- git checkout dev
- git pull
- git checkout -b feature/ticketname
- git status or git diff
- git add .
- git commit -m "msg"
- git push 

**Some important Node JS imp**
- npm set strict-ssl false
- npm install
- npm run build
- npm run watch

**GIT Rebase comments**
- git checkout dev
- git pull
- git checkout feature/***
- git pull
- git merge dev
- git push

**GIT Revert**
- git checkout
- git pull origin develop
- git revert commit_id
- git push origin path

**Kint PHP**
> composer require kint-php/kint --dev
- Add follow codein setting.php
> if(class_exists(Kint)){
> \Kint::$depth_limit = 5;
> }
    
