-----------------------------------------
-- Types
-----------------------------------------
DROP TYPE IF EXISTS category_name CASCADE;
DROP TYPE IF EXISTS notification_type CASCADE;
DROP TYPE IF EXISTS transaction_type CASCADE;
CREATE TYPE category_name AS ENUM ('Clothing', 'Painting', 'Jewelry', 'Sculpture', 'Furniture', 'Accessories', 'Other');
CREATE TYPE notification_type AS ENUM ('New Follower', 'Auction Action', 'New Auction', 'New Bid', 'New Comment');
CREATE TYPE transaction_type AS ENUM ('Sell', 'Buy', 'Deposit', 'Debit');

-----------------------------------------
-- Tables
-----------------------------------------

DROP TABLE IF EXISTS authenticated_user CASCADE;
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

    CONSTRAINT minimum_age check (
        (date_part('year',now()- date_of_birth) +
        date_part('month',now()- date_of_birth)/12 +
        date_part('day',now()- date_of_birth)/365
        ) > 17)
);

DROP TABLE IF EXISTS user_follow CASCADE;
CREATE TABLE user_follow (
    follower_id INTEGER NOT NULL REFERENCES authenticated_user(id) ON UPDATE CASCADE ON DELETE CASCADE,
    followed_id INTEGER NOT NULL REFERENCES authenticated_user(id) ON UPDATE CASCADE ON DELETE CASCADE,

    PRIMARY KEY (follower_id, followed_id)
);

DROP TABLE IF EXISTS auction CASCADE;
CREATE TABLE auction (
    id SERIAL PRIMARY KEY,
    auction_name TEXT NOT NULL,
    initial_price FLOAT NOT NULL,
    deadline TIMESTAMP WITH TIME ZONE NOT NULL,         -- TIMESTAMP WITH TIME ZONE '2004-10-19 10:23:54+02'
    item_description TEXT NOT NULL,
    auction_owner INTEGER NOT NULL REFERENCES authenticated_user(id) ON UPDATE CASCADE ,

    CONSTRAINT valid_deadline check (
        (date_part('month',deadline-now())*43800+
        date_part('day',deadline-now())*1440+
        date_part('hour',deadline-now())*60+
        date_part('minute',deadline-now())
        ) > 30)
);

DROP TABLE IF EXISTS auction_follow CASCADE;
CREATE TABLE auction_follow (
    follower_id INTEGER NOT NULL REFERENCES authenticated_user(id) ON UPDATE CASCADE,
    auction_id INTEGER NOT NULL REFERENCES auction(id) ON UPDATE CASCADE,

    PRIMARY KEY (follower_id, auction_id)
);

DROP TABLE IF EXISTS category CASCADE;
CREATE TABLE category (
    id SERIAL PRIMARY KEY,
    auction_id INTEGER NOT NULL REFERENCES auction(id) ON UPDATE CASCADE,
    TYPE category_name DEFAULT 'Other'
);

DROP TABLE IF EXISTS bid CASCADE;
CREATE TABLE bid (
    id SERIAL PRIMARY KEY,
    bid_value FLOAT NOT NULL,
    bid_date TIMESTAMP WITH TIME ZONE DEFAULT now(),
    winner BOOL DEFAULT FALSE,

    auction_id INTEGER NOT NULL REFERENCES auction(id) ON UPDATE CASCADE,
    user_id INTEGER NOT NULL REFERENCES authenticated_user(id) ON UPDATE CASCADE
);

 DROP TABLE IF EXISTS greatest_bid CASCADE;
 CREATE TABLE greatest_bid (
    bid_id INTEGER NOT NULL REFERENCES bid(id) ON UPDATE CASCADE,
    auction_id INTEGER NOT NULL REFERENCES auction(id) ON UPDATE CASCADE,

    PRIMARY KEY (bid_id, auction_id)
);

DROP TABLE IF EXISTS user_comment CASCADE;
CREATE TABLE user_comment (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES authenticated_user(id) ON UPDATE CASCADE,
    auction_id INTEGER NOT NULL REFERENCES auction(id) ON UPDATE CASCADE,
    comment_text TEXT NOT NULL,
    comment_date TIMESTAMP WITH TIME ZONE DEFAULT now()
);

DROP TABLE IF EXISTS money_transaction CASCADE;
CREATE TABLE money_transaction (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES authenticated_user(id) ON UPDATE CASCADE,
    admin_id INTEGER REFERENCES authenticated_user(id) ON UPDATE CASCADE,
    transaction_value FLOAT NOT NULL,
    TYPE transaction_type NOT NULL,
    auction_id INTEGER REFERENCES auction(id) ON UPDATE CASCADE,

    CONSTRAINT minimum_transaction check (transaction_value > 0),
	CONSTRAINT valid_transaction check (
        ((type in ('Sell', 'Buy')) AND NOT(auction_id IS NULL)) OR
        ((type in ('Deposit', 'Debit')) AND NOT(admin_id IS NULL))
	)
);

DROP TABLE IF EXISTS item_image CASCADE;
CREATE TABLE item_image (
    address TEXT UNIQUE PRIMARY KEY,
    auction_id INTEGER NOT NULL REFERENCES auction(id)
);

DROP TABLE IF EXISTS user_notification CASCADE;
CREATE TABLE user_notification (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES authenticated_user(id) ON UPDATE CASCADE,
    type notification_type NOT NULL,
    auction_id INTEGER REFERENCES auction(id) ON UPDATE CASCADE,
    follower_id INTEGER REFERENCES authenticated_user(id) ON UPDATE CASCADE,
    comment_id INTEGER REFERENCES user_comment(id) ON UPDATE CASCADE,
    bid_id INTEGER REFERENCES bid(id),
    
    CONSTRAINT valid_notification check (
        ((type IN ('New Follower')) AND NOT(follower_id IS NULL)) OR
        ((type IN ('Auction Action')) AND NOT(auction_id IS NULL)) OR
        ((type IN ('New Bid')) AND NOT(bid_id IS NULL)) OR
        ((type IN ('New Comment')) AND NOT(comment_id IS NULL)) OR
        ((type IN ('New Auction')) AND NOT(auction_id IS NULL))
    )
);

DROP TABLE IF EXISTS review CASCADE;
CREATE TABLE review (
    id SERIAL PRIMARY KEY,
    id_reviewer INTEGER NOT NULL REFERENCES authenticated_user(id) ON UPDATE CASCADE,
    id_reviewed INTEGER NOT NULL REFERENCES authenticated_user(id) ON UPDATE CASCADE,
    review_text TEXT DEFAULT '',
    rating INTEGER DEFAULT 0,

    CONSTRAINT valid_rating check ((rating > -1) AND (rating < 6))
);