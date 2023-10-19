<link rel="stylesheet" href="../css/style-notes.css" />

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

#### @@ 9:19 - Register Styles

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

- ADD some text to the content area on **home** page. 
- I added lorem ipsum from https://trumpipsum.net/

> You know, it really doesn’t matter what you write as long as you’ve got a young, and beautiful, piece of text. You have so many different things placeholder text has to be able to do, and I don't believe Lorem Ipsum has the stamina. Look at that text! Would anyone use that? Can you imagine that, the text of your next webpage?! I write the best placeholder text, and I'm the biggest developer on the web by far... While that's mock-ups and this is politics, are they really so different? Despite the constant negative ipsum covfefe.
> 
> You're telling the enemy exactly what you're going to do. No wonder you've been fighting Lorem Ipsum your entire adult life. An ‘extremely credible source’ has called my office and told me that Barack Obama’s placeholder text is a fraud.
> 
> An 'extremely credible source' has called my office and told me that Lorem Ipsum's birth certificate is a fraud. I think my strongest asset maybe by far is my temperament. I have a placeholding temperament.
> 
> An ‘extremely credible source’ has called my office and told me that Barack Obama’s placeholder text is a fraud. Lorem Ipsum is unattractive, both inside and out. I fully understand why it’s former users left it for something else. They made a good decision. An 'extremely credible source' has called my office and told me that Lorem Ipsum's birth certificate is a fraud.

- We'll create some template parts on 
  
###### DEF: template part - sections to help organize WordPress web page parts

- Create new folder **includes/**
- Create new file in includes/ **section-content.php**
- Call section-content.php as template part in **front-page.php** with **get_template_part()** function:

```php
<?php get_template_part('includes/section', 'content'); ?>
```

- **get_template_part()**:
  - 1st arg: relative path with the first part of the name before the hyphen
  - 2nd arg: second part of the file name

- For testing, type "THIS IS THE CONTENT SECTION" in **section-content.php**

#### @@ 2:50 - Pulling Content from Database

- Now we are going to start pulling content from the database
- The following basically means **if we have some posts, loop through them and instantiate each one until done**

```php
<?php if( have_posts() ): while( have_posts() ): the_post(); ?>

  // DO STUFF

<?php endwhile; else: endif; ?>
```

- Now, show the content by replacing "// DO STUFF" with a call to **the_content()** like this:

```php
<?php if( have_posts() ): while( have_posts() ): the_post(); ?>

  <?php the_content(); ?>

<?php endwhile; else: endif; ?>
```

#### @@ 4:58 - Page Templates

- Create page **About Us** and type some text in content editor
- **#GOTCHA:** About Us page is blank because the front-page.php only works for the homepage, but every other page uses the **page.php** template
- In **page.php** add "This is a page template" as the content
- Now when you refresh the about-us page it should show that text

- Next, create a **Contact Us** page, but leave the content blank. When you view it, it will automatically display the dummy text

- Copy-paste from **front-page.php** into into **page.php**

---
### How to give each page its own template

#### @@ 7:00 - Contact Us Template

- Create new template for contact us page in theme root called **template-contactus.php**

- First tell wordpress this is a template with:

```php
<?php
/*
Template Name: Contact Us
*/
?>

This is the CONTACT PAGE template
```

- Now, in the Contact Us page editor, refresh the page and you should see a "Template" dropdown option in the right sidebar.
- If we choose "Contact Us" in the "Template" dropdown list and update, we will be using the "Contact Us" template

- Copy-Paste content from page.php and replace dummy text in **template-contactus.php**
- Now, **template-contactus.php** looks like this:

```php
<?php
/*
Template Name: Contact Us
*/
?>

<?php get_header();  ?>

  <div class="container">
    
    <h1><?php the_title(); ?></h1>

    <?php get_template_part('includes/section', 'content'); ?>

  </div>


<?php get_footer();  ?>
```

#### @@ 9:10 - Two Column Template (Bootstrap)

- Add bootstrap classes to **template-contactus.php**. This is what the file should look like now:

```php
<?php
/*
Template Name: Contact Us
*/
?>

<?php get_header();  ?>

  <div class="container">
    
    <h1><?php the_title(); ?></h1>

    <div class="row">

      <div class="col-lg-6">This is where the contact form goes</div>
      <div class="col-lg-6">
        <?php get_template_part('includes/section', 'content'); ?>
      </div>

    </div>

    <?php get_template_part('includes/section', 'content'); ?>

  </div>

<?php get_footer();  ?>
```

#### @@ 10:10 - Use different headers on different pages

- In theme root create new header template **header-secondary.php** with dummy text content of "This is the SECONDARY HEADER".
- In **front-page.php** add `'secondary'` as the **get_header()** argument like this:

```php
<?php get_header('secondary'); ?>
```

- To test if it worked, view home page source and the dummy text should be at the top.

- Copy the contents of header.php into header-secondary.php so the final result is:

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
  
  This is the SECONDARY HEADER
```

- You could do the same thing for the footer by creating **footer-whatever.php**

### VID: 05 - Navigation Menus

#### @@ 00:30 - How to Enqueue our own custom stylesheet

- Create new file **main.css** in css/ folder


#### #GOTCHA: Make sure you enqueue your custom styles AFTER all others because you want your styles to be able to override the defaults, bootstrap, and all others.

- In **functions.php**, duplicate the bootstrap register and enqueue style statements in **load_css()** and replace "bootstrap" and "bootrap.min" with "**main**" like this:

```php
function load_css() {

  wp_register_style(
    'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css',
    array(), false, 'all');
  wp_enqueue_style('bootstrap');


  wp_register_style(
    'main', get_template_directory_uri() . '/css/main.css',
    array(), false, 'all');
  wp_enqueue_style('main');

}
```

- Verify that the style is enqueued by checking the home page source. Your 'main.css' should appear under the line with 'bootstrap.min.css'.

#### @@ 2:11 - Tidy up our theme

- In **header.php** add `header` tag below the opening body tag
- In **main.css** style the header with:

```css
header {
  background: #111;
  width: 100%;
  height: 100px;
}
```

#### #GOTCHA: Make sure to remove the `'secondary'` argument from the **get_header()** statement in **front-page.php** or the new header style won't display. 

- Edit your profile and uncheck "Show Toolbar when viewing site"

- Wrap `div.container` tag in **front-page.php** with `section.page-wrap` tag:

```php
<?php get_header();  ?>

<section class="page-wrap">
  <div class="container">

    <h1><?php the_title(); ?></h1>

    <?php get_template_part('includes/section', 'content'); ?>

  </div>
</section>

<?php get_footer();  ?>
```

STOPPED @ 4:21

---

- **NEXT WE ARE CREATING THE NAV MENU**

#### #GOTCHA: We have to tell WordPress to enable menu functionality -- it is not enabled by default.

- In **funtions.php** create a "Theme Options" section and enable menus with the **add_theme_support()** function:

```php
// Theme Options
add_theme_support('menus');
```

- Add "Load Stylesheets" and "Load JavaScripts" comments to appropriate sections in functions.php.

- Now, menus are enabled

#### @@ 5:50 - Creating our first menu

- Appearance > Menus > create menu "Top Bar"
- Add all 3 pages (Home, About Us, Contact Us) to Top Bar

#### #TIP: Create "menu locations" to hook into with register_nav_menus() in functions.php.

```php
// Menus
register_nav_menus(

  array(
    'top-menu' => 'Top Menu Location',
    'mobile-menu' => 'Mobile Menu Location',
  )

);
```

- In the arguments array the stub / handle is on the left and the display name on the right
- Now, you should see the display names listed on the **Appearance > Menus page under "Display Location"**
- Add Top Menu to header using the **wp_nav_menu()** hook in functions.php:

```php
<header>

  <?php
  wp_nav_menu(
    array(
      'theme_location' => 'top-menu',
    )
  );
  ?>

</header>
```

- Now, you the menu should display in the black header that we created. 
  
#### #GOTCHA:  The header top nav menu is currently unstyled, so it shows as an unordered list on the top left. We will need to style it next.

- In **header.php** wrap the wp_nav_menu() function in a `div.container` bootstrap class in order to center the div on the page. Note, the menu will still be aligned left.
- 

---

### Some options for the wp_nav_menu() args array:

- **menu**: hard-codes whatever menu, in this case the menu titled "Top Bar"

```php
    wp_nav_menu(
      array(
        'menu' => 'Top Bar',
      )
    );
```

- **menu_class**: adds a class to the generated wp_nav_menu(). Add a class called 'top-bar' like this:

```php
wp_nav_menu(
  array(
    'theme_location' => 'top-menu',
    'menu_class' => 'top-bar',
  )
);

```

- Verify by inspected the source code and look for `class="top-bar"`

- Top begin styling, just create a `header .top-bar` class in main.css like this:

```css
header .top-bar {
  list-style-type: none;
  margin: 0;
  padding: 0;
  display: flex; /* make menu horizontal */
}
```

#### @@ 13:00 - Now you should have a **horizontal menu** with no whitespace

- We are going to work in **main.css** now
- Add spacing to all menu item links:

```css
header .top-bar li a {
  padding: .25rem 1rem;
}
```

- Remove left padding from first item:

```css
header .top-bar li:first-child a {
  padding-left: 0;
}
```

- Remove right padding from last item:

```css
header .top-bar li:last-child a {
  padding-right: 0;
}
```

- Change menu link color:

```css
header .top-bar li a {
  padding: .25rem 1rem;
  color: #fff;
}
```















































## BOOKMARK

---