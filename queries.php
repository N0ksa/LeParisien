<?php>

    //Defininirani upiti prema bazi podataka

    define('QUERY_GET_IMAGE_BY_ID', "SELECT imagePath FROM articles WHERE id=?");
    define('QUERY_DELETE_ARTICLE_BY_ID', "DELETE FROM articles WHERE id=?");
    define('QUERY_UPDATE_ARTICLE_WITH_IMAGE', "UPDATE articles SET title=?, summary=?, articleText=?, category=?, archive=?, imagePath=? WHERE id=?");
    define('QUERY_UPDATE_ARTICLE_WITHOUT_IMAGE', "UPDATE articles SET title=?, summary=?, articleText=?, category=?, archive=? WHERE id=?");
    define('QUERY_GET_UNARCHIVED_ARTICLES_BY_CATEGORY', "SELECT * FROM articles WHERE archive=0 AND category=? ORDER BY STR_TO_DATE(articleDate, '%Y-%m-%d %H:%i:%s') DESC");
    define('QUERY_GET_LATEST_UNARCHIVED_ARTICLES_BY_CATEGORY', "SELECT * FROM articles WHERE archive=0 AND category=? ORDER BY STR_TO_DATE(articleDate, '%Y-%m-%d %H:%i:%s') DESC LIMIT 3");
    define('QUERY_GET_ALL_ARTICLES_ORDERED_BY_DATE', "SELECT * FROM articles ORDER BY articleDate DESC");
    define('QUERY_CHECK_USER', "SELECT * FROM users WHERE username = ?");
    define('QUERY_INSERT_USER', "INSERT INTO users (name, surname, username, password, level) VALUES (?, ?, ?, ?, ?)");
    define('QUERY_CHECK_USERNAME', "SELECT * FROM users WHERE username=?");
    define('QUERY_INSERT_ARTICLE', "INSERT INTO articles (articleDate, title, summary, articleText, imagePath, category, archive)  VALUES (?, ?, ?, ?, ?, ?, ?)");
    define('QUERY_SELECT_ARTICLE_BY_ID', "SELECT * FROM articles WHERE id = ?");






?>