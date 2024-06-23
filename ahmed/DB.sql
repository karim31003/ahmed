create database if not exists blog;
use blog;
create table if not exists users(
	id int primary key auto_increment,
    name varchar (255) not null,
    email varchar (255) not null unique,
    phone varchar (15) unique,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp
);

create table if not exists posts(
	id int primary key auto_increment,
    title varchar (255) not null,
    content text,
    image varchar(255),
    imagepost varchar(255),
    user_id int,
    
    constraint fk_user_id_users
    foreign key(user_id)
    references users(id)
    on delete cascade
    on update cascade
);
create table if not exists comments(
	id int primary key auto_increment,
    comment text not null,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp,
    post_id int,
    user_id int,
    
    constraint fk_post_id_posts
    foreign key(post_id)
    references posts(id)
    on delete cascade
    on update cascade,
    
    constraint fk_user_id_comments_users
    foreign key(user_id)
    references users(id)
    on delete cascade
    on update cascade
);
use blog;
ALTER TABLE USERS ADD COLUMN banned TINYINT(1) DEFAULT 0;
DESCRIBE USERS;

alter table users 
add column password varchar(255) not null after email;

alter table users
add column role enum('subscriber','admin') default 'subscriber' after phone;

alter table posts
add column created_at timestamp default current_timestamp;
alter table posts
add column updated_at timestamp default current_timestamp;

alter table users
add column image varchar(255);
CREATE TABLE post_likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT,
    user_id INT,
    action ENUM('like', 'unlike'),  -- 'like' for like action, 'unlike' for unlike action
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    UNIQUE (post_id, user_id, action)  -- Ensure each user can only like or unlike a post once
);

ALTER TABLE post_likes
ADD CONSTRAINT fk_post_id
FOREIGN KEY (post_id)
REFERENCES posts(id)
ON DELETE CASCADE;

ALTER TABLE post_likes
ADD CONSTRAINT fk_post_users_id
FOREIGN KEY (user_id)
REFERENCES users(id)
ON DELETE CASCADE;