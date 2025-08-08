Blog Web Application with User and Admin Dashboard
=============================================

Overview
--------

Welcome to my web application featuring intuitive dashboards for both users and administrators. Users can create and manage posts and update their profiles, while administrators can handle user management tasks, such as creating and deleting accounts. This project highlights fundamental CRUD operations, user authentication, and role-based access control as well as front-end and back-end development.

Features
--------

*   **User Registration and Login:** Users can create accounts and log in. Administrators can also log in to access the admin dashboard.
    
*   **User Dashboard:** Users can create posts, view their own posts, and see a comprehensive list of all posts.
    
*   **Admin Dashboard:** Administrators can view a list of all users and have the ability to delete users.
    
*   **Profile Management:** Users can easily update their profile username.
    

Installation
------------

### Prerequisites

*   PHP 7.4 or later
    
*   MySQL 5.7 or later
    
*   Web server (e.g., Apache)
    

### Setup

1.  Clone the repository:git clone https://github.com/AngelosFikias0/Web_Application.git
    
2.  Navigate to the project directory:cd your-repository
    
3.  Create the Database:
    
    *   Set up a database named wapp(short for web app) in MySQL.
        
4.  Set Up the Database:
    
    *   Import the provided SQL schema to create the necessary tables. This includes users, admins, and posts tables with the correct schema.
        
5.  Configure Database Connection:
    
    *   Update the database connection parameters in the PHP files to match your setup (e.g., localhost, root, password, wapp).
        
6.  Restart your web server:
    
    *   If using Apache, ensure that mod\_rewrite is enabled. Restart Apache with sudo service apache2 restart.
        

Usage
-----

1.  Access the Application:
    
    *   Open your browser and go to http://localhost/your-repository/Login.php.
        
2.  User Registration:
    
    *   Use the registration form to create a new user account.
        
3.  User Login:
    
    *   Log in with your username and password.
        
4.  User Dashboard:
    
    *   Create and manage posts, and view a list of existing posts.
        
5.  Admin Dashboard:
    
    *   Log in with admin credentials to manage user accounts.
        
6.  Profile Management:
    
    *   Update your username from the profile page.
        

Technologies Used
-----------------

*   **Frontend:** HTML, CSS
    
*   **Backend:** PHP
    
*   **Database:** MySQL
    
*   **Server:** Apache
    

Skills Showcase
---------------

*   **Web Development:** Demonstrated ability in both front-end and back-end web development.
    
*   **Database Management:** Experience in setting up and managing MySQL databases.
    
*   **Role-Based Access Control:** Implemented user and admin roles with effective access controls.
    
*   **CRUD Operations:** Proficient in implementing Create, Read, Update, and Delete functionalities.
    

Contributing
------------

1.  Fork the Repository:
    
    *   Click the "Fork" button at the top-right corner of the repository page on GitHub.
        
2.  Create a Branch:
    
    *   git checkout -b feature/YourFeature
        
3.  Make Changes:
    
    *   Commit your changes with a descriptive message: git commit -am 'Add new feature'
        
4.  Push to Your Branch:
    
    *   git push origin feature/YourFeature
        
5.  Create a Pull Request:
    
    *   Open a pull request from your branch to the main branch of the original repository.
        

License
-------

This project is licensed under the MIT License. See the LICENSE file for more details.

Feel free to adjust the content to better fit your project's specifics!
