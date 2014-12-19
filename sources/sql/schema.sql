create schema room;

create table room.room (
    room_id serial primary key,
    name varchar not null unique,
    seats int4 not null check (seats > 0),
    options json,
    hour_price numeric (7,2) not null,
    size_m2 numeric(7,2)  not null check (size_m2 > 0)
);

create table room.booking (
    booking_id serial primary key,
    room_id int4 not null references room.room (room_id),
    timespan tsrange not null,
    booker_name varchar not null,
    confirmed boolean not null default false,
    created_at timestamp not null default now(),
    hour_price numeric (7,2) not null
);

alter table room.booking add constraint overlaping_booking exclude using gist (room_id with =, timespan with &&);

