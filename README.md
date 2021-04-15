# PressShare
*Share the the your mobile's clipboard with your PC*  
By *Sesso Kosga Bamokaï Michée*  
pseudo : *senor16*
  

## Description
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
To create an acount, you provide an :
- Email
- Pseudo
- Password
## Structure of the project
I use the *MVC* model. So I have 7 classes :
* Models
    - Model : the supperclass with contains the sql to add, update, get and delete press and users.  
    - Pres : with one **s**, it contains the sql to manage press
    - User : it contains the sql needed to manage an user    

* Controllers
    - Controller : the superclass that contains the render method, and home
    - Press : it manage the interactions for presses
    - Users : it manage the interactions for users
    - Errors: it manage how errors are showed to the user
    
    
  