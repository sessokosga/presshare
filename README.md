# ![Logo PressShare](svg/share-alt.svg) ![Logo PressShare](svg/clipboard.svg) PressShare

_Share the the content your mobile's clipboard with your PC_

## Description

### Why this project ?

I was using my smartphone. I got some text that I needed to copy to my computer.  
Usually, to do so :

1. I copy the text
2. I create a .txt file with _WPS_
3. I copy the file to my computer

There is too much steps to do it.  
So I decided to create a local website where I will upload the text  
and get dirrect access to it with my computer. So was born what will become  
the _PressShare_ project.

_PressShare_ help you to share text and links with your computer.

## Functionnalities

The content of your clipboard is called a _Press_
_Presshare_ allow you to :

- Add
- Modify
- See
- and Delete

_Presses_
In order to add a _Press_, you must first create an account.  
You have access to the all the _press_ that are published. Of course,  
only the author of a _press_ can update and delete it.

## Structure of the project

- Models

  - Model: It contains the informations needed to onnect to the database  
    and some basic functions
  - User : It executes the queries needed to perform user actions
  - Press : It executes the queries needed to manage _press_

- Controllers
  - Controller : It contains basic functions used by their subclasses
  - Press : it manage the interactions for presses
  - Users : it manage the interactions for users
  - Errors: it manage how errors are showed to the user
- Views:
  We have a directory for each controller. Each directory contains  
   the needed files to render the view.

## Set up

### Server

You can use either Apache or Nginx, jus specify in the index.php which one you want :

    // Use with Apache
    $url = $_SERVER['SERVER_ADDR'] == "::1" ? 'localhost' : $_SERVER['SERVER_ADDR'];
    $url = $url . ':' . $_SERVER['SERVER_PORT'];
    define('ROOT_URL', 'http://' . $url . '/presshare/');

    // Use with Nginx
    define('ROOT_URL', 'http://presshare.test/');

### Database

You can use either MySQL or PostgreSQL, specify which one you wanna use in the `app/model.php` file.

    private $db = "pgsql"; // `mysql` or `pgsql`

You will specify the login informations in the `setLoginInfo()` method.

Test account :

- pseudo : senor16
- password : senor16

## Possible ameliorations

The current state of the project is good, bud not great.  
There are some improvements and functionnalities that can be added.  
I encourage you to improve the project by adding more functionnalities.  
There are some functionnalities that needed to be added tothe project:

- Give to the user the possibility to decide wether his _press_ will be public or private
- Give to the user the possibility to browser all the press or just the _press_ he published

Have good courage. See you soon.

By _Sesso Kosga Bamokaï Michée_  
pseudo : _senor16_
