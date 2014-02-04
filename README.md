SiteChecker is a demonstration site built with PHP, MySQL and the Yii framework.

After a user enters a site URL and CAPTCHA they are told whether the site is up or down. The site check is also stored to a DB so the most recent checks can be displayed.

A lot of the code is boilerplate generated by Yii, but the files I would draw your attention to are:

[SiteController.php](https://github.com/dmcclure/site-checker/blob/master/protected/controllers/SiteController.php)
- This is the controller entry point, namely the actionIndex() function. It will initiate the site validation after a user has entered a URL.

[CheckSiteForm.php](https://github.com/dmcclure/site-checker/blob/master/protected/models/CheckSiteForm.php)
- The Yii model class for validating user input and retrieving the most recent site checks from the DB.

[SiteCheckDao.php](https://github.com/dmcclure/site-checker/blob/master/protected/models/SiteCheckDao.php)
- A Yii ActiveRecord class used for saving and retrieving site checks to the DB.

[CheckSite.php](https://github.com/dmcclure/site-checker/blob/master/protected/components/CheckSite.php)
- The component that performs the actual site check. I provides two different ways to check a site: using the cURL library, and doing a raw socket connection.

[index.php](https://github.com/dmcclure/site-checker/blob/master/protected/views/site/index.php)
- The primary view used to display the form, site check result, and table of recent checks.