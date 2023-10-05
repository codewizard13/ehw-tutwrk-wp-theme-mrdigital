| INFO PROPERTY | VALUE                                   |
| ------------- | --------------------------------------- |
| Program Name  | **THEME: EHW Tutwrk - Mr Digital 2019** |
| File Name     | README.md                               |
| Date Created  | 10/02/23                                |
| Date Modified | --                                      |
| Version       | 00.01.00                                |
| Programmer    | **Eric Hepperle**                       |

### TECHNOLOGIES

<img align="left" alt="WordPress" title="WordPress" width="26px" src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/wordpress/wordpress-original.svg" style="padding-right:10px;" />

<img align="left" alt="Git" title="Git" width="26px" src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/git/git-original.svg" style="padding-right:10px;" />

<img align="left" alt="GitHub" title="GitHub" width="26px" src="https://user-images.githubusercontent.com/3369400/139448065-39a229ba-4b06-434b-bc67-616e2ed80c8f.png" style="padding-right:10px;" />

<br>

## TAGS

`Tutwrk` `WordPress` `WordPress Themes` `Themes from Scratch`


## PURPOSE

Learn how to create custom WordPress theme hand-coding from scratch by following tutorial by YouTube channel **[Mr Digital](https://www.youtube.com/@mrdigitalau)**

### Tutorial Info

- Title: WordPress Theme Development From Scratch - 3.  Enqueuing CSS and JS to WordPress theme (2019)
- Full URL: https://www.youtube.com/watch?v=KtMwTBl-j8I&list=PLgFB6lmeXFOpHnNmQ4fdIYA5X_9XhjJ9d&index=3
- Base URL: https://www.youtube.com/watch?v=KtMwTBl-j8I
- Channel: Mr Digital
- Channel URL: https://www.youtube.com/@mrdigitalau
- Avatar URL: https://yt3.ggpht.com/ytc/APkrFKbYApVma-AuENTW0cGN27QJCbSiXnjiNufZteBT=s88-c-k-c0x00ffffff-no-rj



## NOTES

- screenshot.png = 1200x900
- Create 10 templates:
  * functions.php: default plugin for WP
  * page.php: template for all page
  * single.php: single blog post template
  * archive.php: post lists pages
  * front-page.php: automatically attaches itself to your homepage. This template automatically loads on the front page

---

### VID: 03

#### Main Theme Template Files:

| File               | Purpose                                                                      |
| ------------------ | ---------------------------------------------------------------------------- |
| **functions.php**  | default plugin for WP. Adds additional functionality that WP core is missing |
| **page.php**       | default page template                                                                             |
| **single.php**     |single blog post template                                                                              |
| **index.php**      |                                                                              |
| **front-page.php** |                                                                              |
| **archive.php**    |post list pages                                                                              |
| **search.php**     | search results                                                                              |
| **404.php**        |page not found                                                                              |
| **header.php**     |default site header                                                                              |
| **footer.php**     |default site footer                                                                              |


---

**functions.php:**

- Create template file: **header.php**
- Create template file: **footer.php**

---

- Add header.php to front-page.php with:

```php
<?php get_header(); ?>
```

- In header we put an **html scaffold**

---

- In **header.php** in VSCode TYPE `html:5` and press TAB to auto generate HTML5 scaffolding

```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
```


- Closing body and html tags in **footer.php**

- Front page will be blank, but can test by seeing if the full html tag contents are in "view source" in code inspector

---

- Let's enqueue our stylesheet

wp_head() and wp_footer() are similar to hooks that inject styles into header and footer

**header.php**

```php
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <?php wp_head(); ?>

</head>
<body>
```

**footer.php**

```php
<?php wp_footer(); ?>

</body>
</html>
```

- If you refresh your page the wordpress **admin bar** should now be showing


---

- Enqueue stylesheets in **functions.php**

- We are going to be installing **Bootstrap**

- Download compiled css and js from [getbootstrap.com](getbootstrap.com)
- Unzip and drag css/ and js/ folders into your theme root
- Create an **images/** folder in theme root also

@@ 19:20





---