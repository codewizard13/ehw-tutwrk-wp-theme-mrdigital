<link rel="stylesheet" href="../css/style-main.css" />

# TUTORIAL NOTES

<a class="bookmark-link" href="#bookmark">JUMP TO BOOKMARK</a>


### VID: 01-02

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
- Unzip and drag **css/** and **js/** folders into your theme root
- Create an **images/** folder in theme root also

@@ 9:19

#### Enqueue Styles in functions.php:

- Add **load_css()** function to functions.php
- Register bootstrap stylesheet
  - Give it a handle first -- could be "clownshoes", but "bootstrap" makes more sense
  - Use the .min version of bootstrap.css because it saves loading time **#performance**
  - Then tell wordpress where to find the bootstrap css file with **get_template_directory_uri()**
  - The third argument is a list of dependencies (other stylesheets this one may depend on). If not, just type `array(),`
  - Fourth arg is version -- can put `false`
  - Fifth arg is media, as in for responsive media queries. Just type 'all' unless you have reason not to

- Immediately after creating function, call it with `wp_enqueue_style('bootstrap')`


###### DEF: **get_template_directory_uri():** tells WP the root of the stylesheet directory

```php
function load_css() {

  wp_register_style(
    'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css',
    array(), false, 'all');
  wp_enqueue_style('bootstrap');

}

```

- Add the style to the WP boot sequence with **add_action()**:

```php
function load_css() {

  wp_register_style(
    'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css',
    array(), false, 'all');
  wp_enqueue_style('bootstrap');

}
add_action('wp_enqueue_scripts', 'load_css');
```

- Now, if we go to the homepage and refresh, it will still be blank, but if you view the source code (**CTRL-U**) you should see `/css/bootstrap.min.css` in a `link rel` tag.

- Next, we will load JavaScripts for Bootstrap
- **#GOTCHA:** Bootstrap does have jQuery as a dependency, so ...
- WordPress automatically ships with jQuery
- **jQuery Migrate:** a patch provided by WordPress which helps you use jQuery plugins that require a newer version jQuery; for backward compatibility
- Version: false
- last parameter = "in footer": true

```php
function load_js() {

  wp_register_script('bootstrap-scripts', get_template_directory_uri() . '/js/bootstrap.min.js',
  'jquery', false, true);
  wp_enqueue_script('bootstrap-scripts');

}
add_action('wp_enqueue_scripts', 'load_js');
```

- Now, as long as you have registered an enqueued the script and done add action, you should see `/js/bootstrap.min.js` show up in a `script` tag before the closing body tag in the page source.

- **#GOTCHA:** If we search for jQuery in the page source, although WordPress automatically includes it in the core, it is not included on the page. To include in your custom theme we need to enqueue it as a script. Enqueue jQuery before the register_script() statements in **load_js()**:

```php
function load_js() {

  wp_enqueue_script('jquery');
  wp_register_script('bootstrap-scripts', ...
```

- Now, if we refresh the page source, jQuery will be in our header.


### VID: 04 - Template Parts & Page Templates

- **#GOTCHA:** Discrepancy - Offscreen after the last vid (03) he added the `div class='container'` section with the title to **front-page.php** like this:

```php
<?php get_header();  ?>

  <div class="container">
    
    <h1><?php the_title(); ?></h1>

  </div>


<?php get_footer();  ?>
```

- ****

















## BOOKMARK

---