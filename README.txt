##Brief notes on the functionality of the MVC structure

This is where I will write notes that help me to remember how to use the code.
###Views

When creating view files all dynamic data should be included via the $data array passed to the page.
The general rule is that designers should be able to create pages without having knowledge of any code
Calls to view() must specify the folder and the file in the form -> 'home/index' or 'login/failed', do not add the '.php'
Views must specify whether the user is loggedIn or not by passing that data 'loggedIn' values 0,1,2 are valid values. 0 = not logged in, 1 = logged in, 2 = currently loggin in

###Controls

The full logic of the page should be carried out in the controller. Any data that must be displayed must be passed to the view in the $data array

##Models

These are you classes and class files

##Redirects

These can be written within the code as Redirect::to('home'); where home is the name of the controller
