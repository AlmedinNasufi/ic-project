#Bookstore Management System (API Overview)

##Setup and Installation

> 1.Clone the repository:
> git clone https://github.com/AlmedinNasufi/ic-project.git

> 2.Navigate to the Project Directory:
> cd path-to-your-project-directory

> 3.Install dependencies:
> composer install

> 4.Set up Environment Variables

> 5.Generate Application Key:
> php artisan key:generate

> 6.Generate JWT Key:
> php artisan jwt:secret

> 7.Migrate Data:
> php artisan migrate

> 8.Seed Database:
> Populate the database with Roles, Books, and Categories:

> php artisan db:seed

> Register an Admin User:
> You need to register a user manually as an Admin. After registration, set the role_id to 1 in the database to make them an Admin.

> Register a User:
> Similarly, register a regular user and set the role_id to 2 to give them standard user privileges.

> API Endpoints:
> To test and see all available API endpoints, check the provided Postman collection:
> https://www.postman.com/mission-geologist-17423713/workspace/the-icproject/overview

##Introduction:
The Bookstore Management System is a RESTful API developed using the Laravel framework. Its primary function is to manage the inventory of books and user preferences related to book categories. It provides features like book searching, adding, updating, and deletion, while also giving users the flexibility to view books based on their category preferences.

##Features:

##Authentication:

Utilizes JWT for authenticating users.
Ensures that only authenticated users can interact with the bookstore data.
##Admin Privileges:

Admins can add, view, update, or remove books.
They can also assign books to multiple categories, allowing for categorization like Fiction, Non-Fiction, Fantasy, etc.
##User Preferences:

Users can specify their preferred book categories in their profile.
They are then only able to view books that belong to these preferred categories.
##Book Details:

Each book is detailed with an author, title, ISBN, publication date, and assigned category or categories.
##Searching:

Users can search for books based on the author's name, title, or ISBN.
It allows for partial matches to improve user experience, especially if they only remember part of the title or author's name.
##Sorting:

The system returns books based on their publication date, with the most recently published books listed first.
##Database Schema:

Models include User, Book, and Category.
##Relationships:
Books and Categories have a many-to-many relationship.
Users have a many-to-many relationship with Categories to denote their preferences.
##Error Handling:

Implemented error handling to manage situations like book not found, invalid data entry, attempting to view non-preferred category, etc.
##Endpoints (A brief overview):

/api/books/search: Allows users to search for books based on certain criteria.
/api/books: Standard CRUD operations for managing books.
/api/categories: For managing book categories.
... (and more as per detailed requirements).
##Conclusion:
The Bookstore Management System is a robust API, catering to both admins and general users. With efficient category management, search functionalities, and user preferences, it provides a tailored experience for its users, ensuring they get relevant content based on their tastes.
