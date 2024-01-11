<link rel="stylesheet" href="../css/notes.css" />

# TUTORIAL NOTES

<a id="top-bookmark-btn" class="bookmark-link" href="#bookmark">JUMP TO BOOKMARK</a>


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

#### #GOTCHA: The .container div needs to be 100% height or the menu won't center vertically.

- Center menu in header with flexbox:

```css
header .container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
}
```

#### #GOTCHA: In his WordPress version, menus appear to have no underline except on hover by default. To match his configuration, we need to set text-decoration: none but add it on hover.

- Make these changes to **main.css**:

```css
header .top-bar li a {
  padding: .25rem 1rem;
  color: #fff;
  text-decoration: none;
}
header .top-bar li a:hover {
  text-decoration: underline;
}
```

#### @@ 16:08 - Now we should have a working top menu with "Home", "About Us", and "Contact Us"

- Next, add the `section.page-wrap` to page.php and template-contactus.php. So, for page.php:

```php
<?php get_header();  ?>

<section class="page-wrap">
<div class="container">
...
```

#### @@ 16:30 - Sub Menus

- Create and publish a page called **Our Team**
- Add as a submenu item (nested) of "About Us" in Appearance > Menus

#### #GOTCHA: When we refresh and view the header menu, "Our Team" is there but not styled. It should pop out on hover and be invisible otherwise, but it is visible and taking up space in the menu.

- Inspecting the code we can see that WordPress gives the nested a menu item a class of **sub-menu** like this:

```html
<ul class="sub-menu">
	<li id="menu-item-27" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-27"><a href="http://hkkbsnap01.local/our-team/">Our Team</a></li>
</ul>
```

- So, first we hide the submenu item:

```css
header .top-bar li .sub-menu {
  display: none;
}
```

#### #TIP: If a menu has a submenu, WordPress injects a class called "menu-item-has-children".

- To show on hover add `display:block` like this:

```css
header .top-bar .menu-item-has-children:hover .sub-menu {
  display: block;
}
```

- Then add these styles:

```css
header .top-bar li .sub-menu {
  display: none;
  position: absolute;
  top: 0;
  left: 0;
  background: #fff;
  box-shadow: 1px 1px 10px rgba(0,0,0,0.1);
}
```

#### #GOTCHA: When you hover on the menu, the submenu will now appear in on the far top left. We need to add styles to tell it to pop up RELATIVE TO the "About Us" menu item location. It is also showing a weird sun icon instead of letters.

- Target the list item itself by adding this code right after the `header .container` rule:

```css
header .top-bar li {
  position: relative;
}
```

#### #GOTCHA: Now the submenu comes up right on top of the parent menu item.

- Changing top from zero to **100%** will fix this issue:

```css
header .top-bar li .sub-menu {
  display: none;
  position: absolute;
  top: 100%;
  ...
```

- Turns out that 'sun' thing was a disc style list bullet. Remove bullets by adding this code to bottom of the .sub-menu rule:

```css
  margin: 0;
  padding: 0;
  list-style-type: none;
```

- Then give it a width of 300px and lets target the link itself for the color change:

```css
...
  margin: 0;
  padding: 0;
  list-style-type: none;
  width: 300px;
}

header .top-bar li .sub-menu a {
  color: red;
}
```

- We are getting closer. Now we have the submenu popping up in the right place and the submenu item text is displaying. Just a little more styling needed to make it look good.
- Let's center the text and give it some padding. The submenu link should now look like:

```css
header .top-bar li .sub-menu a {
  color: red;
  padding: .25rem;
  text-align: center;
}
```

#### #GOTCHA: There is no change - Why? Because the link is displaying as inline. We need to change display to block.

- Now, remove the link underline and make it so link text turns black on hover:

```css
...
  text-decoration: none;
}

header .top-bar li .sub-menu a:hover {
  color: black;
}
```

- Reduce submenu width to 200px and add rounded corners:

```css
header .top-bar li .sub-menu {
...
  width: 200px;
  border-radius: .5rem;
}
```

- Add 4 more dummy submenu items by just adding anything (pages) to see what multiple items will look like.

#### #GOTCHA: The website content overlaps the dropdown submenu. You can see this effect on the contact page. Solve by adding a z-index value of 999 to the submenu.

- Make the top menu structure look like this:

```bash
.
├── Home
├── About Us/
│   ├── Our Team
│   ├── Our Team
│   ├── Contact Us
│   └── About Us/
│       ├── Our Team
│       ├── Our Team
│       ├── Contact Us
│       └── About Us
├── Home
└── Home
```

#### #GOTCHA: Nested 2nd level submenu displays in same column as 1st level, but should be offset.

- Target 2nd submenu and offset with `left: 100%`:

```css
...

header .top-bar .menu-item-has-children:hover .sub-menu {
  display: block;
}

/* 2nd level submenu */
header .top-bar .sub-menu li .sub-menu {
  left: 100%;
}
```

- Change where the 2nd level submenu starts with `top: 0`.


#### #GOTCHA: We should only target submenu we want to show when we highlight a link

- Make so the display block of submenu only shows when hovering the first level by adding direct child selector greater than sign arrows:

```css
header .top-bar > .menu-item-has-children:hover > .sub-menu {
  display: block;
}
```

#### #GOTCHA: This nested submenu targeting can get tricky. You may want to start with the following code that works, and play around changing things to see what effects it will have.

- Add this under the 1st level submenu hover rule:

```css
header .top-bar .menu-item-has-children .sub-menu > .menu-item-has-children:hover .sub-menu {
  display: block;
}
```

#### @@ 30:02 - How to create multiple theme locations

- Copy the `header` tag from header.php and paste in footer.php above current code
- In **footer.php** change the header tag to a footer tag
- Set them_location to footer-menu and menu_class to footer-bar like this: 

```php
wp_nav_menu(
  array(
    'theme_location' => 'footer-menu',
    'menu_class' => 'footer-bar',
  )
);
```

- In **functions.php** register a new location for footer menu:

```php
register_nav_menus(

  array(
    'top-menu' => 'Top Menu Location',
    'mobile-menu' => 'Mobile Menu Location',
    'footer-menu' => 'Footer Menu Location',
  )

);
```

- Go to Appearance > Menus and refresh and now we should see "Footer Menu Location" listed.
- Enable the "Footer Menu Location" checkbox

#### #TIP: He doesn't cover this in detail, but here's how we make and style the footer menu:

- Add another menu in Appearance > Menus called "Footer Menu" and assign it to the footer menu location

- All all current pages (Home, About Us, Contact Us, Our Team) to the menu and save

- Copy a good chunk of the header menu styles and replace "header" with "footer" and "top-bar" with "footer-bar". The footer styling should look like this:

```css
footer {
background: #111;
width: 100%;
height: 100px;
}
footer .footer-bar {
  list-style-type: none;
  margin: 0;
  padding: 0;
  display: flex; /* make menu horizontal */
  background: black;
  width: 100%;
}

footer .container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
}

footer .footer-bar li {
  position: relative;
}

footer .footer-bar li a {
  padding: .25rem 1rem;
  color: #fff;
  text-decoration: none;
}
footer .footer-bar li a:hover {
  text-decoration: underline;
}

footer .footer-bar li:first-child a {
  padding-left: 0;
}

footer .footer-bar li:last-child a {
  padding-right: 0;
}
```

- Now the footer styling matches the header styling on everthing except hover for nested submenus. This is enough to get the point across

!["Our theme at the end of vid 5 of the Mr Digital tutorial"](../images/screen-hkkb--01--tutwrk--mr-digital--wp-theme-scratch.jpg)
*Our theme at the end of vid 5 of the Mr Digital tutorial*

#### #TIP - Clear local changes for a single file with `git restore [filename]` (Source: https://www.git-tower.com/learn/git/faq/git-discard-changes)


### VID: 06 - Blog Archive, Posts, Pagination, Thumbnails

- WordPress started as a blogging platform and has evolved into a fully-fledged CMS
- **single.php:** the core default template for all standard single posts

#### #GOTCHA: At 7:48 his is showing a page title when the post is clicked into by ours is showing nothing - Why? Because @ 00:57 he says let's grab the content from page.php -- but never actually does it on-screen! Instead, he switches gears and adds a bunch of posts in admin dashboard.

#### #TIP: Copy contents of page.php to single.php before going further

- The **single.php** file should now look like this:


```php

```

- Create **Test Post 1** in WP Admin Dashboard
- Create category **Blog**
- Assign category "Blog" to Test Post 1 and publish

- Appearance > Menus make **Top Bar** menu as follows:

```bash
.
├── Home
├── About Us
├── Our Team
└── Contact Us
```

- Add the "Blog" **category** to menu structure after "Our Team" so it looks like this:

```bash
.
├── Home
├── About Us
├── Our Team
├── Blog
└── Contact Us
```

- Now, we should have a link to the Blog category in the top bar menu

#### #GOTCHA - Clicking on the Blog menu link will just show a blank page at this point

- At this point, since Blog is category archive, it uses the default **archive.php** template

- Let's start building archive.php by pasting in the code from page.php. So, the code we start with should look like this:

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

- Add some lorem (3 paragraphs) to Test Post 1 content editor

- Create 3 tags **test1, test2, test3**

- INSTALL and activate plugin: Duplicate Post

#### #TIP - The plugin name in 2023 is called "Yoast Duplicate Post"

- Duplicate the test post 4 times for a total of 5

#### #TIP - DELETE the Hello World! default post. This probably should have been done at the very beginning of the tutorial.

- Rename the post with sequential numbers so now we have Test Post 1, Test Post 2 ... Test Post 5

#### #GOTCHA - On Blog page title is only showing "Test Post 2", but the content from all the posts is there.

- Create new file **section-archive.php** in includes/
- Copy all code from section-content.php -- this is known as the **loop**
- In **archive.php** change the get_template_part() 2nd parameter from "content" to "archive" like this:

```php
<?php get_template_part('includes/section', 'archive'); ?>
```

- Move the `H1` post title code from archive.php into section-archive.php. These two files should now look like this:

**archive.php**

```php
<?php get_header();  ?>

<section class="page-wrap">
<div class="container">
  
  <?php get_template_part('includes/section', 'archive'); ?>

</div>
</section>

<?php get_footer();  ?>
```

**section-archive.php**

```php
<?php if( have_posts() ): while( have_posts() ): the_post(); ?>

  <h1><?php the_title(); ?></h1>

  <?php the_content(); ?>

<?php endwhile; else: endif; ?>
```

#### #TIP - The code immediately above this tip is a basic WP posts "loop"

#### #GOTCHA - The whole blog post is showing in the post list, but we need the excerpt to show instead

- Replace the_content() in **section-archive.php** with `the_content()`
- Add a "read more" link with `the_permalink()`
- Style as row cards with Bootstrap classes
- Style link as button with bootstrap. Final result code for section-archive.php:

```php
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div class="card mb-3">

      <div class="card-body">

        <h3><?php the_title(); ?></h3>
        <?php the_excerpt(); ?>

        <a href="<?php the_permalink(); ?>">Read more</a>

      </div>

    </div>

<?php endwhile; else : endif; ?>
```

![Blog list layout with Bootstrap styling](../images/screen-hkkb--05--tutwrk--mr-digital--wp-theme-scratch.jpg)

_Blog list layout with Bootstrap styling_


- When we click the top "Read more" link we should see the post title and content

![Single blog post layout for Test Post 2](../images/screen-hkkb--06--tutwrk--mr-digital--wp-theme-scratch.jpg)
_Single blog post layout for Test Post 2_


#### @@ 8:54 - Pagination

- We can use WP built-in pagination functionality
- 2 ways to paginate:
  - Show before, prev, and next link
  - Show a bunch of number to take you to that specific page

- In the archive it needs to be outside of the loop (in **archive.php**)


#### #GOTCHA: Tried styling the notes/main.md background white and color black then realized it wasn't that simple. Reinstalled VSCode Extension: Markdown Preview Github Styling. Will just need to enable/disable the plugin as needed.

- in **archive.php** add **previous_posts_link()** and **next_posts_link()**:

```php
<?php get_header();  ?>

<section class="page-wrap">
<div class="container">
  
  <?php get_template_part('includes/section', 'archive'); ?>

  <?php previous_posts_link(); ?>
  <?php next_posts_link(); ?>

</div>
</section>

<?php get_footer();  ?>
```

#### #GOTCHA: No pagination appears on the posts page because we haven't set a limit yet.

- Set posts limit to 3:
  - Dashboard > Settings > Reading > Blog pages to show at most: **3**


#### #TIP: Make sure that posts is plural as in "previous_posts_link" instead of "previous_post_link"


- Pagination Method 2:

  - Paginates with page numbers so you can navigate more quickly
  - Put the following code in **archive.php** under the get_template_part():

```php
  global $wp_query;

  $big = 999999999; // need an unlikely integer

  echo paginate_links([
    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
    'format' => '?paged=%#%',
    'current' => max( 1, get_query_var( 'paged' ) ),
    'total' => $wp_query->max_num_pages
  ]);
  ?>
```

- #GOTCHA: Changed back to simple version with previous/next post links to follow tutorial

---


#### #TIP: This is now our standard archive template. To make new archive template:

- The name of our current category is 'blog'

#### #TIP: We have a category of 'blog' assigned, rather than assigning the posts list page as blog in Settings > Reading

<br><br>

<p class="code-filename">category-blog.php</p>

- clone archive.php -> **category-blog.php**
- Because of WP template hierarchy all posts with category of 'blog' will automatically be handled by **category-blog.php**
- If we had a category of 'dogs' we could make a custom archive page **category-dogs.php**


---

<p class="code-filename">single.php</p>

- single.php starts with same code as page.php
- Create separate section (template-part) for blog posts: **includes/section-blogcontent.php**


<p class="code-filename">section-blogcontent.php</p>

- Create blank file
- Paste loop in. Now it looks like this:

**The Loop:**

```php
<?php if ( have_posts() ): while( have_posts() ): the_post(): ?>

  <?php the_content(); ?>

<?php endwhile; else: endif; ?>
```

- In single.php change 'content' to 'blogcontent'

- Get author details inside the loop so that WP already knows the post ID
- Use the **get_the_author_meta()** function to grab user/author details

```php
<?php if ( have_posts() ): while( have_posts() ): the_post(); ?>

  <?php the_content(); ?>

  <?php 
    $fname = get_the_author_meta('first_name');
    $lname = get_the_author_meta('last_name');
    echo $fname . ' ' . $lname;
  ?>

<?php endwhile; else: endif; ?>
```

- Group the variable definitions and add a "posted by" line:

```php
  <?php 
    $fname = get_the_author_meta('first_name');
    $lname = get_the_author_meta('last_name');
  ?>

  <p>Posted by: <?php echo $fname; ?> <?php echo $lname; ?></p>
```

- To add publish date of the post to top of blog post add this code before the_content():

```php
  <?php echo get_the_date('d/m/Y h:i:s'); ?>
```

![Author at bottom and date/time at top](../images/screen-hkkb--09--tutwrk--mr-digital--wp-theme-scratch--section-blogcontent.jpg)

*Blog post (section-blogcontent.php) with author bottom and date top*

- More options for PHP date/time formats here: https://www.php.net/manual/en/datetime.format.php


- Add this code below the "posted by" section:

```php
<?php
$tags = get_the_tags();
foreach ( $tags as $tag ): ?>

  <a href="<?php echo get_tag_link( $tag->term_id ); ?>"><?php echo $tag->name; ?></a>

<?php endforeach; ?>
```
---

- REPLACED Trump Ipsum on homepage with Carl Sagan ipsum 
- I added lorem ipsum from https://saganipsum.com/

> Encyclopaedia galactica descended from astronomers decipherment gathered by gravity consciousness vanquish the impossible. Hundreds of thousands finite but unbounded great turbulent clouds another world not a sunrise but a galaxyrise preserve and cherish that pale blue dot. White dwarf radio telescope with pretty stories for which there's little good evidence preserve and cherish that pale blue dot the ash of stellar alchemy two ghostly white figures in coveralls and helmets are softly dancing?
> 
> Two ghostly white figures in coveralls and helmets are softly dancing a billion trillion rich in heavy atoms permanence of the stars bits of moving fluff finite but unbounded. How far away not a sunrise but a galaxyrise dream of the mind's eye tesseract star stuff harvesting star light are creatures of the cosmos. Made in the interiors of collapsing stars a very small stage in a vast cosmic arena ship of the imagination Sea of Tranquility cosmic ocean cosmic ocean.
> 
> Billions upon billions invent the universe Drake Equation culture tingling of the spine a very small stage in a vast cosmic arena. Rig Veda rich in mystery bits of moving fluff a still more glorious dawn awaits star stuff harvesting star light cosmic ocean. Preserve and cherish that pale blue dot a mote of dust suspended in a sunbeam tendrils of gossamer clouds network of wormholes vastness is bearable only through love take root and flourish and billions upon billions upon billions upon billions upon billions upon billions upon billions.
>

- Ran that lorem through www.loremipzum.com to add headers, links, unordered lists, etc. Then tweaked to create this resulting dummy lorem text:

![Homepage with Sagan ipsum](../images/screen-tutwrk--mr-digital--wp-theme-scratch--11---pg-home--lorem-sagan.jpg)

<h2>A inven little eye stellar permanence a cherish another.</h2>

Lorem ipsum dolor sit amet. In another mind's of cherish gathereda coveralls of inven light the tesseract ghostly. A star clouds <strong>And coveralls</strong> are heavy there's. Of stuff small in blue galactica

<blockquote cite="https://www.loremipzum.com">
  The interiors ghostly in decipherment good the world gravity Sea ocean
  vanquish in hundreds clouds of blue figures!
</blockquote>

<h4>The vanquish telescope the descended Tranquility ash billion escended!</h4>

A cosmic stories <em>A rich and cosmic descended a that stars</em> a interiors sunrise a radio star. The preserve little but stage cosmos and
billions galactica. In coveralls consciousness <a href="https://www.loremipzum.com" target="_blank" rel="noopener">Of hundreds</a> and sunrise hundreds.

<ul>
  <li>Of white dancing of decipherment softly.</li>
  <li>And Tranquility evidence a ocean moving are star upon.</li>
</ul>

---

- In test post 2 add another tag **test5**. Observe on Test Post 2 post that the new tag shows up :)

#### #GOTCHA: Instructor is using Bootstrap 4, however in Bootsrap 5 'bg-success' must be used instead of 'badge-success'.

- Add `class="badge bg-success"` to section-blogcontent.php to style tags as green buttons

```php
    <a href="<?php echo get_tag_link( $tag->term_id ); ?>" class="badge bg-success">
      <?php echo $tag->name; ?>
    </a>
```

![Tags styled as green buttons in blog posts](../images/screen-tutwrk--mr-digital--wp-theme-scratch--12---bootstrap-style-on-tags-in-blogcontent.jpg)


- [Bootstrap 5: Badge](https://getbootstrap.com/docs/5.0/components/badge/)


---

- Add categories to blogcontent:

```php
<?php
$categories = get_categories();
?>

<?php foreach ( $tags as $tag ): ?>

  <a href="<?php echo get_tag_link( $tag->term_id ); ?>" class="badge bg-success">
    <?php echo $tag->name; ?>
  </a>

<?php endforeach; ?>

<?php foreach ( $categories as $category): ?>
  <a href="<?php echo get_category_link( $category->term_id ); ?>">
    <?php echo $category->name; ?>
  </a>

<?php endforeach; ?>
```

#### #GOTCHA: Instructor uses get_the_category() instead of get_categories() and it still works.

- Add archive name to top of archive in archive.php above the get_template_part:

```php
  <h1><?php echo single_cat_title() ?></h1>
  
  <?php get_template_part('includes/section', 'archive'); ?>
```

- Add same statement in category-blog.php

---

#### @@ - 27:00 - ADD COMMENTS section to blog posts

- Add comments section in blogcontent loop (section-blogcontent.php) under the categories foreach:

```php
  <?php comments_template(); ?>
```

- Post reply "Test" as logged in user on Test Post 2:

![Comment form added to blog posts](../images/screen-tutwrk--mr-digital--wp-theme-scratch--13---test-post-2--comment.jpg)

- Disable comments section for now

#### #TIP: ALT-SHIFT-P creates a page break in WordPress admin editor (Not to be confused with "Read More" tag)

- #TIP: You can also manually add page break in text mode by typing `<!--nextpage-->`

#### GOTCHA: After adding page breaks to a post and updating, nothing happens!

- Add wp_link_pages() to bottom of single.php to create pagination in a single blog post. It works by creating a pseudo-page everywhere there is a page break in the current post:

```php
<?php get_template_part('includes/section', 'blogcontent'); ?>

<?php wp_link_pages(); ?>
```

![Add pseudo-pagination to a single post with page breaks and wp_link_pages()](../images/screen-tutwrk--mr-digital--wp-theme-scratch--14---test-post-2--page-break-pagination.jpg)

---

- I added some default styling for blockquotes to bottom of **main.css**:

```css
/* BLOCKQUOTE: Default */

blockquote {
  padding: .6rem 1rem .8rem 1rem;
  margin: 1rem;
  border: solid 1px;
  border-left: solid #333 6px;
  display: table;
}
```

![Blockquote on homepage with default style applied](../images/screen-tutwrk--mr-digital--wp-theme-scratch--15---pg-home--blockquote-style.jpg)


#### @@ - 30:59 - ADD Image to Blog Post


- ADD **post thumbnail**

#### #GOTCHA: Nowhere currently in right post editor sidebar to select **featured image** (post thumbnail). Solve by adding "support".

- In functions.php add support in the "Theme Options" section for post-thumnails:

```php
// Theme Options
add_theme_support('menus');
add_theme_support('post-thumbnails');
```

![Featured image section available after adding post-thumbnails support in functions.php](../images/screen-tutwrk--mr-digital--wp-theme-scratch--17--wpadmin-post--add-feat-img-thumb.jpg)


- Add a featured image

#### #GOTCHA: Image doesn't show yet in post because we haven't added the code to display it yet.

- Add code to template **single.php** to display thumbnail:


```php
<section class="page-wrap">
<div class="container">

  <?php if(has_post_thumbnail()): ?>

    <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="img-fluid mb-3 img-thumbnail">

  <?php endif; ?>

  <h1><?php the_title(); ?></h1>
```

#### #GOTCHA: Post thumbnail displays way too large in post

#### @@ 34:38 - Create custom image sizes:

- When you upload image to media gallery, WP automatically checks your **functions.php** to see what images sizes you want created

#### #GOTCHA: You wouldn't want to load a 3MB image even if that's the size of the original image you uploaded. So, WP lets you register sizes to automatically generate image sizes you specify in the theme

- At bottom of **functions.php**, add Custom Image Sizes code
- **Hard Crop:** If you upload a large dimension image, that image will get cut out in the same place on every image. 

#### #TIP: Set last parameter in **add_image_size()** function to true for hard crop, else false.

```php
// Custom Image Sizes
add_image_size('blog-large', 800, 400, false);
add_image_size('blog-small', 300, 200, true);
```

#### #GOTCHA: We've defined the image sizes to be created, but how do we tell WordPress to generate all those sizes for all the images already uploaded?

#### #TIP: Add PLUGIN: Force Regenerate Thumbnails. THEN: Tools > Force Regenerate Thumbnails > Regenerate All Thumbnails

#### #GOTCHA: Extra default image sizes being generated that aren't listed in functions.php, nor in Settings > Media

https://quadlayers.com/remove-thumbnails-in-wordpress/



#### #TIP #SOLVED: WordPress 5.3 introduced additional image sizes which can be found via /wp-includes/media.php

- Update your function, like so, removed the extra sizes: [source](https://wordpress.stackexchange.com/questions/354378/wordpress-adding-scaled-images-that-dont-exist-1536x1536-and-2048x2048)

```php
function remove_default_image_sizes( $sizes) {
    unset( $sizes['large']); // Added to remove 1024
    unset( $sizes['thumbnail']);
    unset( $sizes['medium']);
    unset( $sizes['medium_large']);
    unset( $sizes['1536x1536']);
    unset( $sizes['2048x2048']);
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'remove_default_image_sizes');
```

- Another option: [source](https://wordpress.stackexchange.com/questions/354378/wordpress-adding-scaled-images-that-dont-exist-1536x1536-and-2048x2048)
  
> You could also remove those image sizes completely using remove_image_size (see: https://developer.wordpress.org/reference/functions/remove_image_size/)
>
> Example (to be placed in your functions.php file):

```php
remove_image_size('1536x1536');
remove_image_size('2048x2048');
```

> This function, however, won't work for default WP image sizes (e.g. 'thumbnail', 'medium', 'large', etc.). There's a work-around though. Simply set the sizes to 0:

```php
update_option( 'thumbnail_size_h', 0 );
update_option( 'thumbnail_size_w', 0 );
update_option( 'medium_size_h', 0 );
update_option( 'medium_size_w', 0 );
update_option( 'medium_large_size_w', 0 );
update_option( 'medium_large_size_h', 0 );
update_option( 'large_size_h', 0 );
update_option( 'large_size_w', 0 );
```

#### #GOTCHA: Althought the intructor recommends Force Renerated Thumbnails plugin I'm not seeing a significant advantage over Regnerate Thumbnails plugin.

- **Regenerate Thumbnails** plugin shows you all registered image sizes on its main settings screen under **Tools > Regenerate Thumbnails**:

![Regenerate Thumbnails plugin shows all registered thumbnail sizes, so no guesswork needed](/images/screen-tutwrk--mr-digital--wp-theme-scratch--19--regen-thumbs--current-registered-img-sizes.jpg) 


#### #GOTCHA: Core images sizes are not removed with remove_image_size()!

- Tried using **update_option()** for the core 'medium' and 'medium-large' sizes. No-go -- Sure, it zeroes out the size values but doesn't remove them from the interface.
- Added the **remove_default_image_sizes()** function above to the bottom of functions.php. No-go

#### #TIP #SOLVED: Added a priority of 20, as per [this WordPress.org forum post](https://wordpress.org/support/topic/deregister-image-sizes/?) to the add_filter() statement, causing it to run after sizes are registered by core like this:

```php
add_filter('intermediate_image_sizes_advanced', 'remove_default_image_sizes', 20);
```

![Plugin Regenerate Thumbnails shows that '1536x1536' are removed '2048x2048' and core sizes 'medium' and 'medium_large' are zeroed out](/images/screen-tutwrk--mr-digital--wp-theme-scratch--20--regen-thumbs--err--img-sizes-incorrect.jpg)

_Plugin Regenerate Thumbnails shows that '1536x1536' are removed '2048x2048' and core sizes 'medium' and 'medium_large' are zeroed out_

![Plugin FORCE Regenerate Thumbnails shows that on clicking the button, two core sizes were deleted and only the custom sizes added in functions.php are regenerated.](/images/screen-tutwrk--mr-digital--wp-theme-scratch--21--force-regen-thumbs--core-sizes-deleted-higher-prio.jpg)

_Plugin FORCE Regenerate Thumbnails shows that on clicking the button, two core sizes were deleted and only the custom sizes added in functions.php are regenerated._

- Edit **single.php** to force a specific named image size ("blog-large") in blog posts:

```php
<img src="<?php the_post_thumbnail_url('blog-large'); ?> ...
```

![Force 'blog-large' image size in blog posts](/images/screen-tutwrk--mr-digital--wp-theme-scratch--22--test-post-2--after-add-img-size-blog-large.jpg)

#### #GOTCHA: Instructor points out that image appears to be scaled instead of cropped!

#### #TIP #SOLVED: Change the third parameter on add_image_size('blog-large') from false to true and then click "Regenerate Thumbnails"

```php
add_image_size('blog-large', 800, 400, true);
```

#### #TIP: Setting false on add_image_size() will find a size that is <= your desired dimensions and it will scale the image proportionally

![After changing add_image_size('blog-large') crop parameter to true](/images/screen-tutwrk--mr-digital--wp-theme-scratch--23--test-post-2--change-add-img-size-true.jpg)

_After changing add_image_size('blog-large') crop parameter to true_


#### #GOTCHA: Upon trying to export THIS .md file to HTML with MDExtended today, received this error:

```cmd
Cannot read properties of null (reading 'replace')
TypeError: Cannot read properties of null (reading 'replace')
	at normalize (c:\Users\erich\.vscode\extensions\jebbs.markdown-extended-1.1.3\node_modules\mimoza\index.js:32:21)
	at Mimoza.getMimeType (c:\Users\erich\.vscode\extensions\jebbs.markdown-extended-1.1.3\node_modules\mimoza\index.js:158:21)
	at Function._getMimeType [as getMimeType] (c:\Users\erich\.vscode\extensions\jebbs.markdown-extended-1.1.3\node_modules\mimoza\index.js:206:18)
	at html5_embed_renderer (c:\Users\erich\.vscode\extensions\jebbs.markdown-extended-1.1.3\node_modules\markdown-it-html5-embed\lib\index.js:41:25)
	at md.renderer.rules.image (c:\Users\erich\.vscode\extensions\jebbs.markdown-extended-1.1.3\node_modules\markdown-it-html5-embed\lib\index.js:108:14)
	at s.renderInline (c:\Users\erich\.vscode\extensions\yzhang.markdown-all-in-one-3.6.1\dist\node\main.js:1:450022)
	at s.render (c:\Users\erich\.vscode\extensions\yzhang.markdown-all-in-one-3.6.1\dist\node\main.js:1:450426)
	at md.renderer.render (c:\Users\erich\.vscode\extensions\bierner.markdown-preview-github-styles-2.0.3\dist\extension.js:82:59)
	at f.render (c:\Users\erich\.vscode\extensions\yzhang.markdown-all-in-one-3.6.1\dist\node\main.js:1:443558)
	at renderHTML (c:\Users\erich\.vscode\extensions\jebbs.markdown-extended-1.1.3\out\src\services\exporter\shared.js:43:40)
	at renderPage (c:\Users\erich\.vscode\extensions\jebbs.markdown-extended-1.1.3\out\src\services\exporter\shared.js:28:16)
	at PuppeteerExporter.<anonymous> (c:\Users\erich\.vscode\extensions\jebbs.markdown-extended-1.1.3\out\src\services\exporter\puppeteer.js:63:48)
	at Generator.next (<anonymous>)
	at fulfilled (c:\Users\erich\.vscode\extensions\jebbs.markdown-extended-1.1.3\out\src\services\exporter\puppeteer.js:5:58)
```

- Attempted export of PDF instead and popup said required "Chromium" as a dependency so I confirmed to download and install
- Tried reverting to older version of **Markdown Extended** - no-go - same error

- Posted **#ISSUE** here: https://github.com/qjebbs/vscode-markdown-extended/issues/157


#### @@ 38:32 - STOPPED



<a id="bookmark" href="#top-bookmark-btn" title="back to top">BOOKMARK</a>
---