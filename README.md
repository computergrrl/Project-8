# Project-8 - User Authentication
# Add User authentication to a Todo app

1. Allows new users to register for the application. User's passwords are stored as a hash.
2. Ability for a user to login to the application
3. Ability to log out of the application
4. Users are able to update their passwords
5. All new tasks are assigned to the logged in user
6. Only show tasks belonging to the logged in user
7. ONLY the home, registration, and login pages should be accessible for unauthenticated visitors. All other pages should require authentication.

*************       EXTRAS           *****************

-When logging in, JWT is created using "createJWT" function .

-Upon user registration, the "createJWT" function is called and user is
automatically logged in.

-Pages are personalized based on the current logged in user and correct Welcome message and user name is displayed.

-After logging in, the "Register" and "Login" links are removed.
