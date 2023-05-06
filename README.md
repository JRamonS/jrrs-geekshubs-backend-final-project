# Welcome to the Database of my Happy Petz

<details>
  <summary>Content 📝</summary>
  <ol>
    <li><a href="#objetivo">Objective</a></li>
    <li><a href="#sobre-el-proyecto">About the project</a></li>
    <li><a href="#stack">Stack</a></li>
    <li><a href="#diagrama-bd">Diagram</a></li>
    <li><a href="#instalación-en-local">Installation🚀</a></li>
    <li><a href="#endpoints">Endpoints</a></li>
    <li><a href="#futuras-funcionalidades">Future functionalities</a></li>
    <li><a href="#estado">Project status</a></li>
    <li><a href="#contribuciones">Contributions</a></li>
    <li><a href="#licencia">License</a></li>
    <li><a href="#conclusion">Conclusion</a></li>
    <li><a href="#agradecimientos">Acknowledgments</a></li>
    <li><a href="#contacto">Contacto</a></li>

  </ol>
</details>

## Objective
This project is a functional API connected to a database for a dog grooming business, called Happy Petz, with one-to-many and many-to-many relationships, as well as verification tokens for access to certain sections of the grooming website depending on the type of user.

## About the project
I have created an API connected to the database for a dog grooming salon where the user can register and login, as well as access different parts of the database depending on the type of user that has registered.

## Stack
Technologies used:
<div align="center">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo"></a>
<a href="https://developer.mozilla.org/es/docs/Web/JavaScript">
    <img src= "https://img.shields.io/badge/javascipt-EFD81D?style=for-the-badge&logo=javascript&logoColor=black" width="150"/>
</a>
 </div>
 
 ## Diagram BD Trello
|||
|-|-|
|<img width="794" alt="Diagrama" src="https://user-images.githubusercontent.com/118629906/236620666-6baf1d92-f54a-486c-8761-e2724e1ceb0c.png">|<img width="316" alt="Diagrama2" src="https://user-images.githubusercontent.com/118629906/236620987-bcfabb68-b928-4ed2-98e7-ad97609756ff.png">|

<img width="739" alt="Base de Datos" src="https://user-images.githubusercontent.com/118629906/236621035-552ce1dd-5cb6-4120-bdd1-b0d783d40d9b.png">

<img width="954" alt="Trello" src="https://user-images.githubusercontent.com/118629906/236621193-ef3af6aa-be8e-4628-96f6-d965802372b1.png">

## Installation in local🚀
1. Clone the repository
2. ` $ composer and npm install`
3. Create .env file and duplicate .env.example file
4. Generate a key.
5. To create the new key and insert it automatically in the .env, we will execute:
$ `php artisan key:generate`
6. Execute migrations and seeders $ `php artisan migrate:refresh --seed`.

## Endpoints
<details>
<summary>Endpoints</summary>

- AUTH

    - REGISTER

    - CREATE

            POST localhost:8000/api/register 
        body:
        ``` js
            {
                "name" : "Juan",
                "surname" : "Diaz",
                "email" : "juan@juan.com",
                "password": "Ruiz12354",
                "phone": "685258741",
                "address": "C/ Ruiz Camino 1"
            }
        ```

    - LOGIN

           POST localhost:8000/api/login 
        body:
        ``` js
            {
                "email": "juan@juan.com",
                "password": "Ruiz12354"
            }
        ```
    - LOGOUT

           POST localhost:8000/api/logout
        Auth:
        ``` js
            Token
        ```
    - USER-PROFILE

           GET localhost:8000/api/profile
        Auth:
        ``` js
            Token
        ```
        
     - USER-UPDATE-PROFILE

           PUT localhost:8000/api/profile
        body:
        ``` js
            {
                "id": 24,
                "phone": "+34658974568",
                "address": "c/ la milagrosa 54"
            }
        ```
        

- PETS

    - REGISTER

            POST localhost:8000/api/pets 
        body:
        ``` js
            {
                "name": "luis",
                "type": "dog",
                "breed": "German Shepherd",
                "age": "7"
            }
        ```
    - USER-PETS
            
            GET localhost:8000/api/pets
        Auth:
        ``` js
            Token
        ```
           
           

- APPOINTMENTS

    - CREATE

           POST localhost:8000/api/appointment
            body:
            ``` js
                {
                    "observation": "Es alegico al shapoo",
                    "dateTime": "2023-04-15 13:30:00",
                    "service_id": "1",
                    "pet_id": "10"
                }
            ```
            
            
            
     - USER-APPOINTMENTS

           GET localhost:8000/api/appointment
        Auth:
        ``` js
            Token
        ```    
      - UPDATE-APPOINTMENT

           PUT localhost:8000/api/appointment
            body:
            ``` js
                {
                    "observation": "Es alegico al shapoo",
                    "dateTime": "2023-04-15 13:30:00",
                    "service_id": "1",
                    "pet_id": "10"
                }
            ```
            
            
            
      - DELETE-APPOINTMENT

           DELETE localhost:8000/api/appointment
            body:
            ``` js
                {
                    "appointment_id": 12"
                }
            ```

- ADMIN

    -  USERS-UPDATE-PROFILE-ADMIN

           PUT localhost:8000/api/profile/admin
        body:
        ``` js
            {
                "id": 24,
                "phone": "+34658974568",
                "address": "c/ la milagrosa 54"
            }
        ```
        
       
    - DELETE-PROFILE
            
            DELETE localhost:8000/api/users
           body:
        ``` js
            {
                "id": 24,
            }
        ```

     - ALL APPOINTMETS

            GET localhost:8000/api/appointments/admin
        Auth:
        ``` js
            Token
        ```
                 
</details>

## Future functionalities
- Control all access to each of the routes through tokens

## Project status
Project under construction

## Contributions
Suggestions and contributions are always welcome

## License
This project is under MIT License.

## Conclusion
I managed to raise and develop the proposed objective of creating an API connected to its database for a dog grooming salon using Laravel and JavaScript technologies. It addressed the main aspects of the project. Such as the possibility of registration and login, create, modification and deletion of appointments, and display of different services, access via tokens to different routes etc…

It was possible to identify the main design problems of the database, the various difficulties that arose especially with the method of verification of the token and the different relationships between the tables of the database that were managed to address adequately so that all the functionalities foreseen in the basic design of the project were correctly carried out.
 
 ## Acknowledgments

I thank my colleagues for their time dedicated to this project:

- **Dani**  
<a href="https://github.com/datata" target="_blank"><img src="https://img.shields.io/badge/github-24292F?style=for-the-badge&logo=github&logoColor=red" target="_blank"></a>

- ***David***  
<a href="https://github.com/Dave86dev" target="_blank"><img src="https://img.shields.io/badge/github-24292F?style=for-the-badge&logo=github&logoColor=green" target="_blank"></a>

- ***Mara***  
<a href="https://github.com/Dave86dev" target="_blank"><img src="https://img.shields.io/badge/github-24292F?style=for-the-badge&logo=github&logoColor=green" target="_blank"></a>

- ***Alvaro***  
<a href="https://github.com/alvarito101093" target="_blank"><img src="https://img.shields.io/badge/github-24292F?style=for-the-badge&logo=github&logoColor=green" target="_blank"></a>

- ***Jose***  
<a href="https://github.com/JoseMarin" target="_blank"><img src="https://img.shields.io/badge/github-24292F?style=for-the-badge&logo=github&logoColor=green" target="_blank"></a>

## Contact


-  ***José Ramón Rosario Santana*** 

<a href="https://www.linkedin.com/in/jose-ramon-rosario-36721a242/" target="_blank"><img src="https://img.shields.io/badge/-LinkedIn-%230077B5?style=for-the-badge&logo=linkedin&logoColor=white" target="_blank"></a>

<a href="https://www.github.com/JRamonS/" target="_blank"><img src="https://img.shields.io/badge/github-24292F?style=for-the-badge&logo=github&logoColor=green" target="_blank"></a> 
