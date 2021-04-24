# ![Logo PressShare](svg/share-alt.svg) ![Logo PressShare](svg/clipboard.svg) PressShare
*Share the the content your mobile's clipboard with your PC* [Access to the demo](https://pressshare.000webhostapp.com)  
Test account :  
- pseudo : pseudo
- password : password  

By *Sesso Kosga Bamokaï Michée*  
pseudo : *senor16*
  

## Description
### Why this project ?
I was using my smartphone. I got some text that I needed to copy to  my computer.  
Usually, to do so :
1. I copy the text
2. I create a .txt file with *WPS*
3. I copy the file to my computer  

There is too much steps to do it.   
So I decided to create a local website where I will upload the text  
and get dirrect access to it with my computer. So was born what will become  
the *PressShare* project.  
    
*PressShare* help you to share text and links with your computer. 

## Functionnalities
The content of your clipboard is called a *Press*
*Presshare* allow you to :
- Add
- Modify
- See
- and Delete  

*Presses* 
In order to add a *Press*, you must first create an account.  
You have access to the all the *press* that are published. Of course,  
only the author of a *press* can update and delete it.
    

## Structure of the project

* Models
    - Model: It contains the informations needed to onnect to the database  
     and some basic functions   
    - User : It executes the queries needed to perform user actions  
    - Press : It executes the queries needed to manage *press*

* Controllers
    - Controller : It contains basic functions used by their subclasses
    - Press : it manage the interactions for presses
    - Users : it manage the interactions for users
    - Errors: it manage how errors are showed to the user
* Views:
    We have a directory for each controller. Each directory contains   
    the needed files to render the view. 

## Possible ameliorations
The current state of the project is good, bud not great.  
There are some improvements and functionnalities that can be added.  
I encourage you to improve the project by adding more functionnalities.  
There are some functionnalities that needed to be added tothe project:
* Give to the user the possibility to decide wether his *press* will be public or private
* Give to the user the possibility to browser all the press or just the *press* he published 

Have good courage. See you soon.

By *Sesso Kosga Bamokaï Michée*  
pseudo : *senor16*
