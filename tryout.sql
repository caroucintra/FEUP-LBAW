-----------------------------------------
-- Types
-----------------------------------------

CREATE TYPE categories AS ENUM ('Clothing', 'Painting', 'Jewelry', 'Sculpture', 'Furniture', 'Accessories');
CREATE TYPE notification_type AS ENUM ('New Follower', 'Auction Action', 'New Auction', 'New Bid', 'New Comment');
CREATE TYPE transaction_type AS ENUM ('Sell', 'Buy', 'Deposit', 'Debit');

-----------------------------------------
-- Tables
-----------------------------------------


DROP TABLE IF EXISTS authenticated_user;
CREATE TABLE authenticated_user (
    id SERIAL PRIMARY KEY,
    email TEXT NOT NULL CONSTRAINT user_email_uk UNIQUE,
    username TEXT NOT NULL CONSTRAINT user_username_uk UNIQUE,
    full_name TEXT NOT NULL,
    user_password TEXT NOT NULL,
    img TEXT,
    date_of_birth DATE NOT NULL,        -- '2021-12-01'
    admin_permission BOOLEAN DEFAULT FALSE,
    credit FLOAT DEFAULT 0,
    user_address TEXT,

    CONSTRAINT minimum_age check ((DATEDIFF(DAY, date_of_birth, GetDate()) / 365.25) >= 18)
);

DROP TABLE IF EXISTS follow;
CREATE TABLE follow (
    follower_id REFERENCES authenticated_user(id) NOT NULL,
    followed_id REFERENCES authenticated_user(id) NOT NULL
);

DROP TABLE IF EXISTS auction;
CREATE TABLE auction (
    id SERIAL PRIMARY KEY,
    auction_name TEXT NOT NULL,
    initial_price FLOAT NOT NULL,
    deadline TIMESTAMP WITH TIME ZONE NOT NULL,         -- TIMESTAMP WITH TIME ZONE '2004-10-19 10:23:54+02'
    greatest_bid REFERENCES bid(id),
    item_description TEXT NOT NULL,
    ---- ver o equivalente de DATEDIFF para o postgres
    CONSTRAINT valid_deadline check (DATEDIFF(minute, deadline, GetDate()) > 30)
);

DROP TABLE IF EXISTS category;
CREATE TABLE category (
    id SERIAL PRIMARY KEY,
    TYPE categories NOT NULL
);

DROP TABLE IF EXISTS bid;
CREATE TABLE bid (
    id SERIAL PRIMARY KEY,
    bid_value FLOAT NOT NULL,
    bid_date DATETIME DEFAULT,
    winner BOOL DEFAULT FALSE,

    auction REFERENCES auction(id),
    bidder REFERENCES authenticated_user(id),

    CONSTRAINT valid_value check (bid_value > auction.greatest_bid.bid_value)
);

DROP TABLE IF EXISTS auction_category;
CREATE TABLE item (
    auction_id REFERENCES auction(id),
    category_id REFERENCES category(id),
    
    PRIMARY KEY (auction_id, category_id)
);

DROP TABLE IF EXISTS comment;
CREATE TABLE comment (
    id SERIAL PRIMARY KEY,
    comment_text NOT NULL,
    comment_date TIMESTAMP WITH TIME ZONE DEFAULT now()
);

DROP TABLE IF EXISTS money_transaction;
CREATE TABLE money_transaction (
    id SERIAL PRIMARY KEY,
    user_id REFERENCES authenticated_user(id),
    admin_id REFERENCES authenticated_user(id),
    transaction_value FLOAT NOT NULL,
    TYPE transaction_type NOT NULL,
    auction_id REFERENCES auction(id),

    CONSTRAINT minimum_transaction check (transaction_value > 0),
    CONSTRAINT valid_transaction check (
        ((transaction_type == 'Sell' || transaction_type == 'Buy') && auction_id NOT NULL) ||
        ((transaction_type == 'Deposit'|| transaction_type == 'Debit') && auction_id NULL)
        ),
    CONSTRAINT valid_admin check (admin_id.admin_permission == TRUE)
);

DROP TABLE IF EXISTS item_image;
CREATE TABLE item_image (
    image_adress TEXT PRIMARY KEY
);

DROP TABLE IF EXISTS user_notification;
CREATE TABLE user_notification (
    id SERIAL PRIMARY KEY,
    TYPE notification_type NOT NULL,
    auction_id REFERENCES auction(id),
    follower_id REFERENCES authenticated_user(id),
    comment_id REFERENCES comment(id),
    bid_id REFERENCES bid(id),
    
    CONSTRAINT valid_notification check (
        ((notification_type == 'New Follower') && follower_id NOT NULL) ||
        ((notification_type == 'Auction Action') && auction_id NOT NULL) ||
        ((notification_type == 'New Bid') && bid_id NOT NULL) ||
        ((notification_type == 'New Comment') && comment_id NOT NULL) ||
        ((notification_type == 'New Auction') && auction_id NOT NULL)
    )
);

DROP TABLE IF EXISTS review;
CREATE TABLE review (
    id SERIAL PRIMARY KEY,
    id_reviewer REFERENCES authenticated_user(id),
    id_reviewed REFERENCES authenticated_user(id),
    review_text TEXT DEFAULT "",
    rating INTEGER DEFAULT 0,

    CONSTRAINT valid_rating check (rating >= 0 && rating <=5)
);



--------------------------------
CREATE TABLE work (
   id SERIAL PRIMARY KEY,
   title TEXT NOT NULL,
   obs TEXT,
   img TEXT,
   year INTEGER,
   id_users INTEGER REFERENCES users (id) ON UPDATE CASCADE,
   id_collection INTEGER REFERENCES collection (id) ON UPDATE CASCADE,
   CONSTRAINT year_positive_ck CHECK ((year > 0))
);

CREATE TABLE author_work (
   id_author INTEGER NOT NULL REFERENCES author (id) ON UPDATE CASCADE,
   id_work INTEGER NOT NULL REFERENCES work (id) ON UPDATE CASCADE,
   PRIMARY KEY (id_author, id_work)
);

CREATE TABLE book (
   id_work INTEGER PRIMARY KEY REFERENCES work (id) ON UPDATE CASCADE,
   edition TEXT,
   isbn BIGINT NOT NULL CONSTRAINT book_isbn_uk UNIQUE,
   id_publisher INTEGER REFERENCES publisher (id) ON UPDATE CASCADE
);

CREATE TABLE nonbook (
   id_work INTEGER PRIMARY KEY REFERENCES work (id) ON UPDATE CASCADE ON DELETE CASCADE,
   TYPE media NOT NULL
);

CREATE TABLE item (
   id SERIAL PRIMARY KEY,
   id_work INTEGER NOT NULL REFERENCES work (id) ON UPDATE CASCADE,
   id_location INTEGER NOT NULL REFERENCES location (id) ON UPDATE CASCADE,
   code INTEGER NOT NULL,
   date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

CREATE TABLE loan (
   id SERIAL PRIMARY KEY,
   id_item INTEGER NOT NULL REFERENCES item (id) ON UPDATE CASCADE,
   id_users INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
   start_t TIMESTAMP WITH TIME ZONE NOT NULL,
   end_t TIMESTAMP WITH TIME ZONE NOT NULL,
   CONSTRAINT date_ck CHECK (end_t > start_t)
);

CREATE TABLE review (
   id_work INTEGER NOT NULL REFERENCES work (id) ON UPDATE CASCADE,
   id_users INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
   date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
   comment TEXT NOT NULL,
   rating INTEGER NOT NULL CONSTRAINT rating_ck CHECK (((rating > 0) OR (rating <= 5))),
   PRIMARY KEY (id_work, id_users)
);

CREATE TABLE wish_list (
   id_work INTEGER NOT NULL REFERENCES work (id) ON UPDATE CASCADE,
   id_users INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
   PRIMARY KEY (id_work, id_users)
);