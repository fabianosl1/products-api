create table if not exists categories(
    id      serial primary key,
    name    text not null unique
);

create table if not exists tags(
    id      serial primary key,
    name    text not null unique
);
create table if not exists products(
    id          serial primary key,
    name        text not null unique,
    description text not null,
    price       numeric(10, 2) not null,
    likes       int not null,
    category_id int not null

    constraint  fk_category references categories on delete restrict
);

create table if not exists products_tags(
    product_id  int not null references products,
    tag_id      int not null references categories,

    primary key (product_id, tag_id)
);


