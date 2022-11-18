# Drupal-Notes


**Installing PHPCS for Drupal** 
1) composer global require drupal/coder
2) composer require acquia/coding-standards

**For Enbled Module by Default.**
- config/default/core.extension.yml

**Open Auth Consumer Public and Private Key**
Folder Path : D:/key/public.key
- openssl genrsa -out private.key 2048
- openssl rsa -in private.key -pubout > public.key

**Add this line to show all errors in Drupals**
$config['system.logging']['error_level'] = 'verbose';

**Adding Pach in to module :**
	1)Download module with verstion using git 
	2)then create new branch 
	3)Add your changes in new repo
	4)Then git hub
		-- git diff --no-prefix import > content_sync.patch
