<?
namespace root;

class AppConfig{
    static $DB_FILE = 'C:\OSPanel\domains\blog.local\blog.db';
    static $DB_TABLES = [
        'users' => 'CREATE TABLE users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        password TEXT NOT NULL,
        canPublishPosts INTEGER DEFAULT 0,
        createdAt DATETIME DEFAULT CURRENT_TIMESTAMP
    )',
        'posts' => 'CREATE TABLE posts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        content TEXT NOT NULL,
        authorId INTEGER NOT NULL,
        createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
        updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
        canHaveComments INTEGER DEFAULT 1,
        FOREIGN KEY (authorId) REFERENCES users(id)
    )',
        'comments' => 'CREATE TABLE comments (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        content TEXT NOT NULL,
        authorId INTEGER,
        postId INTEGER NOT NULL,
        commentId INTEGER,
        rating INTEGER DEFAULT 0,
        createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
        updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (authorId) REFERENCES users(id),
        FOREIGN KEY (postId) REFERENCES posts(id),
        FOREIGN KEY (commentId) REFERENCES comments(id)
    )',
        'tags' => 'CREATE TABLE tags (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        createdAt DATETIME DEFAULT CURRENT_TIMESTAMP
    )',
        'post_tags' => 'CREATE TABLE post_tags (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        postId INTEGER NOT NULL,
        tagId INTEGER NOT NULL,
        FOREIGN KEY (postId) REFERENCES posts(id),
        FOREIGN KEY (tagId) REFERENCES tags(id)
    )',
        'files' => 'CREATE TABLE files (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        size INTEGER NOT NULL,
        postId INTEGER NOT NULL,
        FOREIGN KEY (postId) REFERENCES posts(id)
    )',
        'sessions' => 'CREATE TABLE sessions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        userId INTEGER NOT NULL,
        token TEXT NOT NULL,
        createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
        updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (userId) REFERENCES users(id)
    )'
    ];
    static $PROVIDERS_TABLE = [
        'UserProvider' => 'users',
        'PostProvider' => 'posts',
        'CommentProvider' => 'comments',
        'TagProvider' => 'tags',
        'FileProvider' => 'files',
        'SessionProvider' => 'sessions'
    ];
}