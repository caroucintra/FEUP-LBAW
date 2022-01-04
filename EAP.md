# EAP: Architecture Specification and Prototype

This proposal corresponds to an architecture specification and prototype of an auction-holding website. Since the platform will be created using Laravel, the approach used in the architecture is MVC (separating Models from Views and Controllers).

## A7: Web Resources Specification
In this artifact, it is described how modules and permissions are conceptualized in this project. It is important to create a separation between the different functionalities regarding each module, that way, aiming to a well-defined abstraction of the final product.

### 1. Overview
This segment identifies the modules that will constitute our application.
|Module|Description|
|--------------|----------------|
|M01: Authentication|Web resources associated with user authentication. Includes the following system features: login/logout, registration, password recovery.|
|M02: Individual Profile|Web resources associated with individual profile management. Includes the following system features: view and edit personal profile information, list bids, see ratings, list notifications, create and list transactions.|
|M03: Auctions|Web resources associated with auctions posted. It is possible to see the auction's catalog, search for and create new auctions, see auction pages, participate by bidding or commenting, follow auctions to keep updated and rate auctioneers.|
|M04: Static pages|Web resources with static content are associated with this module: about, contact, services and faq.|  
|M05: User Administration|Web resources associated with user management, specifically: view and search users, delete or block user accounts, view and change user information, allow or block transactions and view system access details for each user.| 

### 2. Permissions
Permissions are documented here and will later be used on each action regarding modules of the website.

|            PUB           |         USR        |          AUC          |          ADM          |
|:------------------------:|:------------------:|:---------------------:|:---------------------:|
|           Pubic          |        User        |     Auctioneer     |     Administrator     |
| Users without privileges | Authenticated User | Auction Owner | System administrators |

### 3. OpenAPI Specification
OpenAPI specification in YAML format to describe the web application's web resources.

Link to the a7_openapi.yaml file in the group's repository.

[a7_openapi.yaml](https://github.com/carolcintra24/FEUP-LBAW/blob/master/A7_openapi.yaml)

``` sql

openapi: 3.0.0

info:
  version: '1.0'
  title: 'LBAW The Absolute Artion Web API'
  description: 'Web Resources Specification (A7) for The Absolute Artion'

servers:
- url: http://lbaw.fe.up.pt
  description: Production server

externalDocs:
  description: Find more info here.
  url:  https://git.fe.up.pt/lbaw/lbaw2122/lbaw2184
 

  tags:
  - name: 'M01: Authentication'
    description: 'Web resources associated with user authentication. Includes the following system features: login/logout, registration, password recovery.'
  - name: 'M02: Individual Profile'
    description: 'Web resources associated with individual profile management. Includes the following system features: view and edit personal profile information, list bids, rate auctioneers, list notifications, create and list transactions.'
  - name: 'M03: Auctions'
    description: 'Web resources associated with auctions posted. It is possible to see the auction catalog, search for and create new auctions, see auction pages, participate by bidding or commenting, follow auctions to keep updated.'
  - name: 'M04: Static pages'
    description: 'Web resources with static content are associated with this module: about, contact, services and faq.'
  - name: 'M05: User Administration'
    description: 'Web resources associated with user management, specifically: view and search users, delete or block user accounts, view and change user information, and view system access details for each user.'

paths:
  /login:
    get:
      operationId: R101
      summary: 'R101: Login Form'
      description: 'Provide login form. Access: PUB'
      tags:
        - 'M01: Authentication'
      responses:
        '200':
          description: 'Ok. Show Log-in UI15'
    post:
      operationId: R102
      summary: 'R102: Login Action'
      description: 'Processes the login form submission. Access: PUB'
      tags:
        - 'M01: Authentication'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                email:          # <!--- form field name
                  type: string
                password:    # <!--- form field name
                  type: string
              required:
                  - email
                  - password

      responses:
        '302':
          description: 'Redirect after processing the login credentials.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302User:
                  description: 'Successful authentication. Redirect to user profile.'
                  value: '/users/{id}'
                302Admin:
                  description: 'Successful authentication. Redirect to admin page.'
                  value: '/admin/{id}'
                302Error:
                  description: 'Failed authentication. Redirect to login form.'
                  value: '/login'

  /logout:

    post:
      operationId: R103
      summary: 'R103: Logout Action'
      description: 'Logout the current authenticated user. Access: USR, ADM'
      tags:
        - 'M01: Authentication'
      responses:
        '302':
          description: 'Redirect after processing logout.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful logout. Redirect to home.'
                  value: '/home'

  /register:
    get:
      operationId: R104
      summary: 'R104: Register Form'
      description: 'Provide new user registration form. Access: PUB'
      tags:
        - 'M01: Authentication'
      responses:
        '200':
          description: 'Ok. Show Sign-Up UI16'

    post:
      operationId: R105
      summary: 'R105: Register Action'
      description: 'Processes the new user registration form submission. Access: PUB'
      tags:
        - 'M01: Authentication'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                name:
                  type: string
                email:
                  type: string
                picture:
                  type: string
                  format: binary
              required:
                - email
                - password

      responses:
        '302':
          description: 'Redirect after processing the new user information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful authentication. Redirect to user profile.'
                  value: '/users/{id}'
                302Failure:
                  description: 'Failed authentication. Redirect to login form.'
                  value: '/login'
                  
  /recoverPassword:
    get:
      operationId: R106
      summary: 'R106: Recover Password Form'
      description: 'Lets the user replace the password. Access: PUB'
      tags:
        - 'M01: Authentication'
      responses:
        '200':
          description: 'Ok. Show Recover Password Form UI17'     
    post:
      operationId: R107
      summary: 'R107: Recover Password'
      description: 'Lets the user replace the password. Access: PUB'
      tags:
        - 'M01: Authentication'
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                email:
                  type: string
              required:
                - email

      responses:
       '200':
          description: 'Email successfully sent'
       '403':
          description: 'Email not recognized'
  
  

  /users/{id}:
    get:
      operationId: R201
      summary: 'R201: View user public profile'
      description: 'Show the user image, name, description, average rating, email and selling items. Access: PUB'
      tags:
        - 'M02: Individual Profile'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '200':
          description: 'Ok. Show User Profile UI10'


  /users/{id}/profile: #Mostra o perfil para editar
    get:
      operationId: R202
      summary: 'R202: View user profile'
      description: 'Show the individual user profile and allow editing. Access: USR'
      tags:
        - 'M02: Individual Profile'
      parameters:
        - $ref: '#/components/parameters/ID'

      responses:
        '200':
          description: 'Ok. Show User Profile UI10'

  /users/{id}/profile/bids:
    get:
      operationId: R203
      summary: 'R203: View user bids'
      description: 'Show the individual user bid history. Access: USR'
      tags:
        - 'M02: Individual Profile'
      parameters:
        - $ref: '#/components/parameters/ID'

      responses:
        '200':
          description: 'Ok. Show User Bid History UI1X'

  /users/{id}/profile/ratings:
    get:
      operationId: R204
      summary: 'R204: View user ratings'
      description: 'Show the ratings done by previous buyers of that user. Access: PUB'
      tags:
        - 'M02: Individual Profile'
      parameters:
        - $ref: '#/components/parameters/ID'

      responses:
        '200':
          description: 'Ok. Show User Ratings UI1X'


  /users/{id}/notifications:
    get:
      operationId: R205
      summary: 'R205: View user notifications'
      description: 'Show the notifications created for that user. Access: USR'
      tags:
        - 'M02: Individual Profile'
      parameters:
        - $ref: '#/components/parameters/ID'

      responses:
        '200':
          description: 'Ok. Show User Notifications UI1X'


  /users/{id}/newtransaction:
    post:
      operationId: R206
      summary: 'R206: Create a new transaction'
      description: 'Allows user to make a new movement on their account; transfering the money from the site to a real bank account or the other way around. Access: USR'
      tags:
        - 'M02: Individual Profile'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                in/out:
                  type: string
                value:
                  type: float
              required:
                - in/out
                - value
      responses:
        '302':
          description: 'Redirect after transaction confirmation.'
          headers:
            location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful transaction. Redirect to profile.'
                  value: '/users/{id}/profile'
                302Failure:
                  description: 'Failed transaction. Redirect to profile.'
                  value: '/users/{id}/profile'


  /users/{id}/transactions:
    get:
      operationId: R207
      summary: 'R207: View user transactions'
      description: 'Show the transactions done by that user. Includes all credit movement. Access: USR'
      tags:
        - 'M02: Individual Profile'
      parameters:
        - $ref: '#/components/parameters/ID'

      responses:
        '200':
          description: 'Ok. Show User Transactions UI1X'
          
  /users/{id}/profile/newrating:
    post:
      operationId: R209
      summary: 'R209: User rating'
      description: 'Allows users to rate one another after winning an auction.'
      tags:
        - 'M02: Individual Profile'
      parameters:
        - $ref: '#/components/parameters/ID'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              required:
                - comment
                - stars
              properties:
                comment:
                  type: string
                stars:
                  type: float

      responses:
        '200':
          description: 'Rating successfully done'
        '403':
          description: 'Rating failed'

  /users/{id}/profile/auctions:
    get:
      operationId: R208
      summary: 'R208: View user auctions'
      description: 'Show the auctions done by the user. Access: PUB'
      tags:
        - 'M02: Individual Profile'
      parameters:
        - $ref: '#/components/parameters/ID'

      responses:
        '200':
          description: 'Ok. Show Auctions UI1X'
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    id:
                      type: integer
                    title:
                      type: string
                    description:
                      type: string
                    images:
                      type: string
                      format: binary
                    auctioneer:
                      type: string
                    deadline:
                      type: time
                    initial price:
                      type: float
                    greatest bid:
                      type: float

  /users/{id}/delete:
    delete:
      operationId: R210
      summary: 'R210: Delete user profile'
      description: 'Allows users to delete their personal profile. Access: USR'
      tags:
        - 'M02: Individual Profile'
      parameters:
        - $ref: '#/components/parameters/ID'

      responses:
        '200':
          description: 'Profile deleted successfully'
        '404':
          description: 'Failed to delete profile'

  /api/catalog:
    get:
      operationId: R301
      summary: 'R301: View Auctions Catalog'
      description: 'Show the Auctions Catalog ordered by last bid made and allow filtering the displayed auctions. Access: PUB'
      tags:
        - 'M03: Auctions'
      parameters:
        - in: query
          name: Category
          description: Category wanted by the visitor of the catalog
          schema:
            type: string
          required: false
        - in: query
          name: color
          description: color wanted by the visitor of the catalog
          schema:
            type: string
          required: false
    
      responses:
        '200':
          description: 'Ok. Show Auction Catalog UI12'

  /api/search:
    get:
      operationId: R302
      summary: 'R302: Search Auctions API'
      description: 'Searches for Auctions and returns the results as JSON. Access: PUB.'

      tags:
        - 'M03: Auctions'

      parameters:
        - in: query
          name: query
          description: String to use for full-text search
          schema:
            type: string
          required: false
        - in: query
          name: Auction
          description: Category of the auction
          schema:
            type: string
          required: false
        - in: query
          name: User name 
          description: Auctioneer of the auction
          schema:
            type: string
          required: false
     
      responses:
        '200':
          description: 'Ok. Show Auction Search UI13'
          content:
            application/x-www-form-urlencoded:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    id:
                      type: integer
                    title:
                      type: string
                    description:
                      type: string
                    images:
                      type: string
                      format: binary
                    auctioneer:
                      type: string
                    deadline:
                      type: time
                    initial price:
                      type: float
                    greatest bid:
                      type: float
                   
                   
                example:
                  - id: 5
                    title: Pintura Surrealista
                    description: A minha perspetiva de uma estante prestes a cair pintado em óleo na tela. 80*30
                    images: ???
                    auctioneer: Hokusai Nagi
                    deadline: 36:20:49  
                    initial price: 30€
                    greatest bid: 47,56 €
                  - id: 47
                    title: Vaso em cerâmica
                    description: Vaso em forma de uma esfera branca com riscas pretas e azuis.
                    images: ???
                    auctioneer: Daniela Soares 
                    deadline: 00:36:14  
                    initial price: 2 €
                    greatest bid: 44 €


  /api/newpost:
    post:
      operationId: R303
      summary: 'R303: Create Auction'
      description: 'Allows user to create a new Auction. Access: USR.' 

      tags:
        - 'M03: Auctions'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              required:
                - initial_price
                - name
                - deadline
                - item_description
                - owner
                - item_image
                - category
              properties:
                initial_price:
                  type: float
                name:
                  type: string
                deadline:
                  type: time
                item_description:
                  type: float
                category:
                  type: string
                owner:
                  type: id
                item_image:
                  type: string
                  format: binary
      responses:
        '200':
          description: 'Auction successfully created'
        '403':
          description: 'Auction failed'


  /api/auctions/{id}:
    get:
      operationId: R304
      summary: 'R304: View Auction'
      description: 'View all public information regarding an auction. Access: PUB.' # Não seria Auctioneer? - joao
      tags:
        - 'M03: Auctions'
      parameters:
        - $ref: '#/components/parameters/ID'
    
      responses:
        '200':
          description: 'Ok. Show Auction Page UI14'
          content:
            application/x-www-form-urlencoded:
              schema:
                  type: object
                  properties:
                    name:
                      type: string
                    item_description:
                      type: string
                    category:
                      type: string
                    images:
                      type: string
                      format: binary
                    owner:
                      type: string
                    deadline:
                      type: time
                    initial_price:
                      type: float
                    greatest_bid:
                      type: float

    put:
      operationId: R305
      summary: 'R305: Follow Auction'
      description: 'Allows user to follow an auction. Access: USR.'
      tags:
        - 'M03: Auctions'
      parameters:
        - $ref: '#/components/parameters/ID'
      responses:
        '200':
          description: 'Following auction'
        '403':
          description: 'Follow failed'
      
  /api/auctions/{id}/comment:
    post:
      operationId: R306
      summary: 'R306: Comment on Auction'
      description: 'Allows user to comment on an auction. Access: USR.'
      tags:
        - 'M03: Auctions'
      parameters:
        - $ref: '#/components/parameters/ID'
      
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              required:
                - text
              properties:
                text:
                  type: string
      responses:
        '200':
          description: 'Comment successfully done'
        '403':
          description: 'Comment failed'

  /api/auctions/{id}/bid:
    post:
      operationId: R307
      summary: 'R307: Bid on Auction'
      description: 'Allows user to bid on an auction. Access: USR.'
      tags:
        - 'M03: Auctions'
      parameters:
        - $ref: '#/components/parameters/ID'
      
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              required:
                - value
              properties:
                value:
                  type: float
      responses:
        '200':
          description: 'Bid successfully done'
        '403':
          description: 'Bid failed'

  /api/auctions/{id}/edit:
    get:
      operationId: R308
      summary: 'R308: Show Auction for editing'
      description: 'Allows auctioneers to edit their auction. Access: AUC.'
      tags:
        - 'M03: Auctions'
      
      responses:
        '200':
          description: 'Auction updated successfully'
        '403':
          description: 'Update failed'

/api/auctions/{id}/delete:
  delete:
      operationId: R309
      summary: 'R309: Delete Auction'
      description: 'Allows auctioneers to delete their auction. Access: AUC.'
      tags:
        - 'M03: Auctions'
      
      responses:
      '200':
        description: 'Auction deleted successfully'
      '403':
        description: 'Delete failed'

  /homepage:
    get:
      operationId: R401
      summary: 'R401: Homepage'
      description: 'Provide Homepage. Access: PUB'
      tags:
        - 'M04: Static pages'
      responses:
        '200':
          description: 'Ok. Show UI01'

  /about_us:
    get:
      operationId: R402
      summary: 'R402 About us'
      description: 'Access about us page. Access: PUB'
      tags:
        - 'M04: Static pages'
      responses:
        '200':
          description: 'OK, Show UI02'
          
  /services:
    get:
      operationId: R403
      summary: 'R403 Services'
      description: 'Access Services page. Access: PUB'
      tags:
        - 'M04: Static pages'
      responses:
        '200':
          description: 'OK, Show UI03'

  /contact:
    get:
      operationId: R404
      summary: 'R404 Contact'
      description: 'Access contacts page. Access: PUB'
      tags:
        - 'M04: Static pages'
      responses:
        '200':
          description: 'OK, Show UI04'

  /faq:
    get:
      operationId: R405
      summary: 'R405 FAQ'
      description: 'Access FAQ page. Access: PUB'
      tags:
        - 'M04: Static pages'
      responses:
        '200':
          description: 'OK, Show UI05'  
     
  /admin/users:
    get:
      operationId: R501
      summary: 'R501: View all users'
      description: 'Show a list with all users. Access: ADM'
      tags:
        - 'M05: User Administration'
      responses:
        '200':
          description: 'Ok. Show UI15'
  
  /admin/users/search:
    get:
      operationId: R502
      summary: 'R502: Search for a user'
      description: 'Show the searched user. Access: ADM'
      tags:
        - 'M05: User Administration'
      parameters:
        - in: query
          name: user id
          description: Searched user Id
          schema:
            type: integer
          required: false
        - in: query
          name: username
          description: Searched user name
          schema:
            type: string
          required: false
        - in: query
          name: email
          description: Searched user email
          schema:
            type: string
          required: false
     
      responses:
        '200':
          description: 'Ok. Show User Search UI16 Access: ADM'
          content:
            application/x-www-form-urlencoded:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    id:
                      type: integer
                    username:
                      type: string
                    
                example:
                  - id: 5
                    username: meduarda123
                    email: duda123@gmail.com
   
  /admin/users/{id}/delete: 
    delete:
      operationId: R503
      summary: 'R503 - Delete user'
      description: 'Deletes a user Access: ADM'
      tags:
        - 'M05: User Administration'
      parameters:
        - $ref: '#/components/parameters/ID'
        
      responses:
        '204':  
          description: 'Successfully deleted the user'
        '404':
          description: 'User not found'
                    
  /admin/users/{id}/block: 
    put:
      operationId: R504
      summary: 'R504 - Block user'
      description: 'Blocks a user Access: ADM'
      tags:
        - 'M05: User Administration'
      parameters:
        - $ref: '#/components/parameters/ID'

      responses:
        '204':  
          description: 'Successfully blocked the user'
        '404':
          description: 'User not found' 
          
  /admin/users/{id}/profile: 
    get:
      operationId: R505
      summary: 'R505 - Get user profile information'
      description: 'Returns all profile information about the user Access: ADM'
      tags:
        - 'M05: User Administration'
      parameters:
        - $ref: '#/components/parameters/ID'

      responses:
        '200':
          description: 'Successfully returned the user information'
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/UserInfo'

  /admin/users/{id}/change_profile: 
    put:
      operationId: R506
      summary: 'R506 - Change user profile information'
      description: 'Updates the user profile information Access: ADM'
      tags:
        - 'M05: User Administration'

      parameters:
        - $ref: '#/components/parameters/ID'

      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/UserInfo'

      responses:
        '204':
          description: Successfully updated user profile 
        '404':
          description: 'User not found'           

```

## A8: Vertical prototype

This artifact presents the prototype of the website, including the features and web resources implemented so far, and the code itself.

### 1. Implemented Features
#### 1.1. Implemented User Stories
The user stories that were implemented in the prototype where the following.

#### User

| Identifier | Name             | Priority | Description                                                                                               |
|------------|------------------|----------|-----------------------------------------------------------------------------------------------------------|
| US01       | See Home         | High     | As a _User_, I want to go to the Main page to see a overview of the website.                              |
| US02       | See About        | High     | As a _User_, I want to view the About page so that I can learn more about the website and its developers. |
| US03       | Consult Services | High     | As a _User_, I want to view the website's services and get information about them.                        |
| US04       | Consult FAQ      | High     | As a _User_, I want to view the FAQ to find answers to common questions about the website.                |
| US05       | Consult Contacts | High     | As a _User_, I want have access to the creator's contacts so that I can contact them if needed.           |
| US06       | Search           | High     | As a _User_, I want be able to search posts or users so that it is easier to find what I'm interested in.               |

#### Visitor

| Identifier | Name              | Priority | Description                                                                                                                                                                                            |
|------------|-------------------|----------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| US11       | Sign-in           | High     | As a _Visitor_, I want to log in so that I may see sensitive information.                                                                                                                              |
| US12       | Sign-up           | High     | As a _Visitor_, I want to create an account in the system so that I may verify myself.                                                                                                                 |
#### Authenticated User

| Identifier | Name             | Priority | Description                                                                                               |
|------------|------------------|----------|-----------------------------------------------------------------------------------------------------------|
| US22       | Log Out              | High     | As an _Authenticated User_, I want to be able to log out from my account so that I have control of when and where I am logged in my account.                        |
| US24       | View Profile         | High     | As an _Authenticated User_, I want to view my own profile so that I know what is displayed to other people.                        |

#### Admnistrator

|Identifier|Name|Priority|Description|                                                                                                                                       
|---|---|---|---|
|||||


#### Auctioneer

| Identifier | Name                  | Priority | Description                                                                                                                              |
|------------|-----------------------|----------|------------------------------------------------------------------------------------------------------------------------------------------|
| US41       | Create Auctions       | High     | As an _Auctioneer_, I want to be able to create auctions so that I can use the platform to sell my items.                                |
| US42       | Edit Auctions         | High     | As an _Auctioneer_, I want to be able to edit live auctions so that I can update information if needed.                                  |
| US43       | Cancel Auctions       | High     | As an _Auctioneer_, I want to be able cancel my auctions if no one has made a bid on it yet, in case I no longer want to sell that item. |

#### Bidder

| Identifier | Name                   | Priority | Description                                                                                                                |
|------------|------------------------|----------|----------------------------------------------------------------------------------------------------------------------------|
| US51       | Bid on Auctions        | High     | As a _Bidder_, I want to bid on auctions so that I can try and buy the items I'm interested in.                            |
| US52       | See my Bidding History | High     | As a _Bidder_, I want to be able to see my bidding history so that I have always access to the actions I made on the site. |


### 2.2. User Stories
For The Absolute Artion system, consider the user stories that are presented in the following sections.

#### User

| Identifier | Name             | Priority | Description                                                                                               |
|------------|------------------|----------|-----------------------------------------------------------------------------------------------------------|
| US01       | See Home         | High     | As a _User_, I want to go to the Main page to see a overview of the website.                              |
| US02       | See About        | High     | As a _User_, I want to view the About page so that I can learn more about the website and its developers. |
| US03       | Consult Services | High     | As a _User_, I want to view the website's services and get information about them.                        |
| US04       | Consult FAQ      | High     | As a _User_, I want to view the FAQ to find answers to common questions about the website.                |
| US05       | Consult Contacts | High     | As a _User_, I want have access to the creator's contacts so that I can contact them if needed.           |
| US06       | Search           | High     | As a _User_, I want be able to search posts or users so that it is easier to find what I'm interested in.               |


#### Visitor

| Identifier | Name              | Priority | Description                                                                                                                                                                                            |
|------------|-------------------|----------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| US11       | Sign-in           | High     | As a _Visitor_, I want to log in so that I may see sensitive information.                                                                                                                              |
| US12       | Sign-up           | High     | As a _Visitor_, I want to create an account in the system so that I may verify myself.                                                                                                                 |
| US13       | OAuth API Sing-in           | Low     | As a _Visitor_, I want to log in through my Facebook account so that may verify myself.                                                                                                         |
| US14       | OAuth API Sing-up           | Low     |As a Visitor, I want to create an account linked to my Facebook account in the system so that my personal information is automatically migrated and so I can link my account to a business page.                                                                                                                 |

#### Authenticated User

| Identifier | Name             | Priority | Description                                                                                               |
|------------|------------------|----------|-----------------------------------------------------------------------------------------------------------|
| US21       | Edit Profile         | High     | As an _Authenticated User_, I want to edit my profile so that I can choose what information to share.                              |
| US22       | Log Out              | High     | As an _Authenticated User_, I want to be able to log out from my account so that I have control of when and where I am logged in my account.                        |
| US23       | Delete Account       | High     | As an _Authenticated User_, I want to be able to delete my account so that my profile doesn't publicly exist anymore.           |
| US24       | View Profile         | High     | As an _Authenticated User_, I want to view my own profile so that I know what is displayed to other people.                        |
| US25       | Follow Auctions      | Medium   | As an _Authenticated User_, I want to follow auctions so that I am notified when there's new actions regarding them.                        |
| US26       |  See Notifications       | Medium      | As an _Authenticated User_, I want to be able to see my notifications in order to be updated on aactions on the site. |
| US27       | Follow Other Profiles| Medium   | As an _Authenticated User_, I want to follow other users so that I can keep myself updated on their actions. |
| US28       | Comment              | Low      | As an _Authenticated User_, I want to comment on auctions so that I can share my opinion. |
| US29       | Edit Comment         | Low      | As an _Authenticated User_, I want to edit my comments so that I fix a possible mistake. |
| US30       | Delete Comment       | Low      | As an _Authenticated User_, I want to delete a comment in case I don't it to be public anymore. |

#### Admnistrator

| Identifier | Name           | Priority | Description                                                                                                                                                                                                        |
|------------|----------------|----------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| US31       | Stop Auctions  | High     | As an _Admin_, I want to be able to stop and cancel auctions so that if anything goes wrong, that auction is cancelled and possibly deleted.                                                                       |
| US32       | Ban Users      | High     | As an _Admin_, I want to be able to ban users who disrespect the terms of service or the community guidelines, so that they can no longer have access to the content that an authenticated user has access to. |
| US33       | Delete Content | High     | As an _Admin_, I want to be able to see reported content and delete it, so that I can remove inappropriate content.                                                                                                |

#### Auctioneer

| Identifier | Name                  | Priority | Description                                                                                                                              |
|------------|-----------------------|----------|------------------------------------------------------------------------------------------------------------------------------------------|
| US41       | Create Auctions       | High     | As an _Auctioneer_, I want to be able to create auctions so that I can use the platform to sell my items.                                |
| US42       | Edit Auctions         | High     | As an _Auctioneer_, I want to be able to edit live auctions so that I can update information if needed.                                  |
| US43       | Cancel Auctions       | High     | As an _Auctioneer_, I want to be able cancel my auctions if no one has made a bid on it yet, in case I no longer want to sell that item. |
| US44       | Receive Notifications | Medium     | As an _Auctioneer_, I want to receive notifications so that I am up to date with my live auctions.   


#### Bidder

| Identifier | Name                   | Priority | Description                                                                                                                |
|------------|------------------------|----------|----------------------------------------------------------------------------------------------------------------------------|
| US51       | Bid on Auctions        | High     | As a _Bidder_, I want to bid on auctions so that I can try and buy the items I'm interested in.                            |
| US52       | See my Bidding History | High     | As a _Bidder_, I want to be able to see my bidding history so that I have always access to the actions I made on the site. |
| US53       | Rate the Seller        | Medium   | As a _Bidder_, I want to be able to rate the seller so that I know I have a way of rating my experience with the buy.      |
| US54       | Receive Notifications  | High     | As a _Bidder_, I want to receive notifications so that I am up to date with the auctions I participated in.                |



#### 1.2. Implemented Web Resources
The web resources that were implemented in the prototype where the following:

#### Module M01: Authentication

|Web resource name|URL to access the web resource|
|--------------|----------------|
|R01: Login|/login|
|R02: Logout||
|R03: Registration|/register| 

#### Module M02: Individual Profile

|Web resource name|URL to access the web resource|
|--------------|----------------|
|R01: View personal profile|/profile/{user_id}|
|R02: View personal active auctions|/profile/{user_id}|
|R03: View Bidding history|/bid_history| 

#### Module M03: Auctions

|Web resource name|URL to access the web resource|
|--------------|----------------|
|R01: View auctions catalog|/catalog|
|R02: Search for and create new auctions|/auctions|
|R03: See auction pages|/auctions/{auction_id}| 
|R04: Participate by bidding|/auctions/{auction_id}| 

#### Module M04: Static pages

|Web resource name|URL to access the web resource|
|--------------|----------------|
|R01: See About page|/about|
|R02: See Terms of Service page|/services|
|R03: See FAQ page|/faq| 
|R04: See Contact page|/contact| 

#### Module M05: User Administration

|Web resource name|URL to access the web resource|
|--------------|----------------|
|R01: View other users profile|/profile/{user_id}|

### 2. Prototype

The url for the prototype is:
http://lbaw2184.lbaw.fe.up.pt/

Credentials:

Admin user:

email: admin@admin.com
passwrod: 1234

Regular user:

Pode cancelar auction porque não tem nenhuma bid.
Criar um novo auction. 
Fazer bids em outras auctions.

email: carsonjames@mail.com
password: 1234

Perfil mais completo com active e unactive auctions.

email: luisarodrigues@mail.com
password: 1234


Code available at:
https://git.fe.up.pt/lbaw/lbaw2122/lbaw2184

GROUP2184, 21/12/2021

Group member 1: Ana Bárbara Carvalho Barbosa, up201906704@up.pt <br>
Group member 2: Carolina Cintra Fernandes Figueira, up201906845@up.pt <br>
Group member 3: João Gabriel Ferreira Alves, up201810087@fc.up.pt <br>
Group member 4: Maria Eduarda Fornelos Dantas, up201709467@up.pt (Editor)
