# ER: Requirements Specification Component

This proposal corresponds to an information system with a web interface to support an online auction service. Any registered user can place items up for auction or bid on the existing items.The seller sets an initial price and the period of time the auction will be open, and the system automatically manages the bidding deadlines and determines the winner.

## A1: Project Presentation - The Absolute Artion

A platform inspired by Vinted that allows different users to sell and buy handmade unique pieces in a real time auction. The auction model we chose is Absolute Auction, which means highest bid wins regardless of price and the current highest bidder can't bid until someone else does. Although the deadlines are previously stablished, they can be extended by 30 minutes when a new bid is made in the last 15 minutes. Users can search items by price, color, type of item or username. Our project has categorized users, depending on their permissions. 
1. Unauthenticated users (guests) are allowed to search for auctions and auctioneer profiles, explore the web page by browsing, but can't participate on auctions or create new ones.
2. Authenticated users can create auctions to sell their work and or participate on other users auctions. By following or having an auction, the user will receive notifications on new bids, approaching deadline, the end of the auction and the winner. The auction followers are also notified when it is canceled (by the owner or an administrator). Users may follow each other to receive notifications on new posts. Another functionality is to check their bidding history and followed auctions as well as choose to share those with other users. In their personal page will be a section with all of their live auctions, which they can edit, cancel (if there's no bid yet) and manage status. The user can only bid if there is credit associated to their account, so if they win the auction, the money is directly discounted from that credit and cashed in the artist's account. All bidders can rate the seller, view previous biddings on a particular auction and report inappropriate content.
3. Administrators are user accounts that can't participate on or create new auctions, but are responsible for manegement actions of The Absolute Artion. Those can stop auctions, block user accounts, or delete reported actions.

Our goal with this project is to create a platform where artists can promote their art ranging from paintings to jewellery and even clothing. We think that kind of work is being forgotten with the rising of fast fashion and industrialisation. Altough there are a lot of other platforms that allow this online transactions, our project will prioratize connecting artists to enthusiasts.

## A2: Actors and User stories
This artifact serves as an agile record of the project's requirements, containing the actors specifications and user stories.

### 2.1 Actors
For The Absolute Artion system, the actors are represented in Figure 1 and described in Table 1.

![](/Pictures/users.png)
*Figure 1 - Actors*

| Identifier         | Description                                                                                                                                            |
|--------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------|
| User               | Generic user that can explore and search the website.                                                                                                  |
| Authenticated User | Authenticated user that can comment on other people's auctions, have a personal profile and a notification panel and report inappropriate content. |
| Visitor            | Unauthenticated user that can register itself(sign-up) or sign-in in the system.                                                                       |
| Auctioneer         | Authenticated user that can create an auction.                                                                                                         |
| Bidder             | Authenticated user that can bid on other people's auctions and view bidding history.                                                                   |
| Administrator      | Authenticated user that can stop auctions, block other user accounts and delete inappropiate content among other management functions.             |
| OAuth API          | External OAuth API that can be used to register or authenticate into the system.                                                                       |

*Table 1 - The Absolute Artion actors and their descriptions* 


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

*Table 2 - User user stories*

#### Visitor

| Identifier | Name              | Priority | Description                                                                                                                                                                                            |
|------------|-------------------|----------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| US11       | Sign-in           | High     | As a _Visitor_, I want to log in so that I may see sensitive information.                                                                                                                              |
| US12       | Sign-up           | High     | As a _Visitor_, I want to create an account in the system so that I may verify myself.                                                                                                                 |
| US13       | OAuth API Sign-in | Low      | As a _Visitor_, I want to log in through my Facebook account so that may verify myself.                                                                                                                |
| US14       | OAuth API Sign-up | Low      | As a _Visitor_, I want to create an account linked to my Facebook account in the system so that my personal information is automatically migrated and so I can link my account to a business page. |

*Table 3 - Visitor user stories*

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


*Table 4 - Authenticated User user stories*


#### Admnistrator

| Identifier | Name           | Priority | Description                                                                                                                                                                                                        |
|------------|----------------|----------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| US31       | Stop Auctions  | High     | As an _Admin_, I want to be able to stop and cancel auctions so that if anything goes wrong, that auction is cancelled and possibly deleted.                                                                       |
| US32       | Ban Users      | High     | As an _Admin_, I want to be able to ban users who disrespect the terms of service or the community guidelines, so that they can no longer have access to the content that an authenticated user has access to. |
| US33       | Delete Content | High     | As an _Admin_, I want to be able to see reported content and delete it, so that I can remove inappropriate content.                                                                                                |

*Table 5 - Administrator user stories*


#### Auctioneer

| Identifier | Name                  | Priority | Description                                                                                                                              |
|------------|-----------------------|----------|------------------------------------------------------------------------------------------------------------------------------------------|
| US41       | Create Auctions       | High     | As an _Auctioneer_, I want to be able to create auctions so that I can use the platform to sell my items.                                |
| US42       | Edit Auctions         | High     | As an _Auctioneer_, I want to be able to edit live auctions so that I can update information if needed.                                  |
| US43       | Cancel Auctions       | High     | As an _Auctioneer_, I want to be able cancel my auctions if no one has made a bid on it yet, in case I no longer want to sell that item. |
| US44       | Receive Notifications | Medium     | As an _Auctioneer_, I want to receive notifications so that I am up to date with my live auctions.                                       |

*Table 6 - Auctioneer user stories*


#### Bidder

| Identifier | Name                   | Priority | Description                                                                                                                |
|------------|------------------------|----------|----------------------------------------------------------------------------------------------------------------------------|
| US51       | Bid on Auctions        | High     | As a _Bidder_, I want to bid on auctions so that I can try and buy the items I'm interested in.                            |
| US52       | See my Bidding History | High     | As a _Bidder_, I want to be able to see my bidding history so that I have always access to the actions I made on the site. |
| US53       | Rate the Seller        | Medium   | As a _Bidder_, I want to be able to rate the seller so that I know I have a way of rating my experience with the buy.      |
| US54       | Receive Notifications  | High     | As a _Bidder_, I want to receive notifications so that I am up to date with the auctions I participated in.                |

*Table 7 - Bidder user stories*


### 2.3. Supplementary Requirements
This section includes business rules, technical requirements, and restrictions.

#### Business rules

| Identifier | Name                            | Description                                                                                                                          |
|------------|---------------------------------|--------------------------------------------------------------------------------------------------------------------------------------|
| BR01       | Set Auction Deadline            | The deadline of the auction will be set when it is created and except for when someone bids in the last 15 minutes, it cannot change. |
| BR02       | Deleted Auction Bidding History | The bidding history of an auction is kept in record even if the auction is cancelled or deleted.                                     |
| BR03       | Auction Deadline                | The auction deadline must be in a date greater than the date of its creation.                                                         |
| BR04       | Media Types                     | The auction can only display a maximum of 10 photos or videos showing the product.                                                   |
| BR05       | Bidding                     | A user cannot bid on their own auction.                                                 |
| BR06       | Deleted Account                     | The user's information is kept in the database even if the account is deleted.                                                 |

*Table 8 - The Absolute Artion business rules*


#### Technical requirements

| Identifier | Name                | Description                                                                                                                                                                                                                                                                                                                                   |
|------------|---------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| TR01       | Availability        | Apart from possible errors, the system should be available 100% of the time.                                                                                                                                                                                                                                                                  |
| TR02       | Accessibility       | The system should be accessed regardless of the web browser that is being used.                                                                                                                                                                                                                                                               |
| **TR03**   | **Usability**       | **The website will be accessible to anyone in terms of technical experience.  No prior knowledge will be required, because the system will be easy to navigate through and understand.**                                                                                                                                                   |
| TR04       | Performance         | The system should have the fastest response possible, so that the user won't be stuck in the same page and can have the most dynamic experience possible.                                                                                                                                                                                 |
| **TR05**   | **Web Application** | **Standard web technologies and programming languages such as HTML, JavaScript and CSS will be adopted, guaranteeing that anyone with a browser can access the site. No additional software or app will be required to the usage of the system.**                                                                                         |
| TR06       | Portability         | The Absolute Artion should be accessible using any platform or OS, so that the user base of the system is as large as it can be.                                                                                                                                                                                                              |
| TR07       | Database            | An updated version of PostGreSQL database management system should be associated with the site so that all the data is safely stored.                                                                                                                                                                                                                |
| TR08       | Security            | The access to different information should be secured to different users through authentication.                                                                                                                                                                                                                                              |
| TR09       | Scalability         | The system should be prepared to function well regardless of the number of users registered or online.                                                                                                                                                                                                                                        |
| **TR10**   | **Ethics**          | **User data protection should be a critical concern to The Absolute Artion, in order to guarantee the security of data that is shared with the system. Each user can choose the amount of information that he wants to expose and no data shall be collected or shared without the acknowledgment and authorization from its owner.** |

*Table 9 - The Absolute Artion technical requirements*


#### Restrictions

| Identifier | Name     | Description                                                                                                                                                          |
|------------|----------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| C01        | Deadline | The system should be ready to use by the end of January, that way the project presentation will show all the fuctionalities and details we plan on implementing. |

*Table 10 - The Absolute Artion restrictions*


## A3: Information Architecture
This artefact's goals are to specificate how the site will be organized through pages and exemplify a couple of them.

### 1. Sitemap

The Absolute Artion will be organized the same way a simple online shop would be: 
- At all times, the user can access Static Pages, which will always be hyperlinked in the top of the page displayed. With that in mind, all the pages concerning information on the site (About, FAQ, Services, Contact) are together.
- Administration Pages are separated from everything else because only a few people have access to it.
- A user can log in, sign up or recover their password through different Authentication Pages.
- A user can access their own page just by clicking a button on the top right and people can see and follow each other's profile pages, that's why User Pages are distinct from other kinds.
- The Auction Pages cover every page concerning the auctions, which are: the catalog and search that any user can browse, and by clicking on one auction, its details.

![](/Pictures/sitemap.png)
*Figure 1: The Absolute Artion Sitemap*

### 2. Wireframes
We plan on implementing the pages for the Auction Details (UI14) and User Profile (UI10) as it is shown below.

#### UI14: Auction Details

![](/Pictures/auctiondetails.png)
*Figure 2: Auction Details Page*

#### UI10: User Profile

![](/Pictures/userprofile.png)
*Figure 3: User Profile Page*

## Revision history
Changes made to the first submission:
- User's credit card information is now a credit account specific for the site, that can be cashed in and out.
- Information regarding Regular/Premium users was deleted, since that feature is not gonna be implemented for now.
- User is no longer able to delete auctions.

**GROUP2184**, 08/11/2021

Group member 1: Ana Bárbara Carvalho Barbosa, up201906704@up.pt<br>
Group member 2: Carolina Cintra Fernandes Figueira, up201906845@up.pt<br>
Group member 3: João Gabriel Ferreira Alves, up201810087@fc.up.pt<br>
Group member 4: Maria Eduarda Fornelos Dantas, up201709467@up.pt (Editor)
