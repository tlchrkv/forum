CREATE TABLE files (
    id UUID NOT NULL,
    name VARCHAR(63) NOT NULL,
    mime_type VARCHAR(255) NOT NULL,
    placement VARCHAR(255) NOT NULL,
    created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL,
    relation_table VARCHAR(255) NOT NULL,
    relation_id UUID NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE users (
    id UUID NOT NULL,
    name VARCHAR(63) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(63) NOT NULL,
    created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL,
    updated_at TIMESTAMP(0) WITH TIME ZONE NULL,
    created_by UUID NULL,
    updated_by UUID NULL,
    PRIMARY KEY(id)
);

CREATE TABLE user_forum_categories (
    id UUID NOT NULL,
    forum_category_id UUID NOT NULL,
    PRIMARY KEY(id, forum_category_id)
);

CREATE TABLE forum_categories (
    id UUID NOT NULL,
    name VARCHAR(63) NOT NULL,
    slug VARCHAR(63) NOT NULL,
    created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL,
    updated_at TIMESTAMP(0) WITH TIME ZONE NULL,
    created_by UUID NOT NULL,
    updated_by UUID NULL,
    PRIMARY KEY(id)
);

CREATE TABLE forum_topics (
    id UUID NOT NULL,
    category_id UUID NOT NULL,
    name VARCHAR(63) NOT NULL,
    slug VARCHAR(63) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL,
    updated_at TIMESTAMP(0) WITH TIME ZONE NULL,
    created_by UUID NOT NULL,
    updated_by UUID NULL,
    PRIMARY KEY(id)
);

CREATE TABLE forum_comments (
    id UUID NOT NULL,
    topic_id UUID NOT NULL,
    reply_to UUID NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL,
    updated_at TIMESTAMP(0) WITH TIME ZONE NULL,
    created_by UUID NOT NULL,
    updated_by UUID NULL,
    PRIMARY KEY(id)
);
