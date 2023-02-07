<?php

/**
 * Category
 * Groupings for articles
 */
class Category {

    /*** Get all the categories */
    public static function getAll($conn) {

        $sql = "SELECT * 
        FROM category
        ORDER BY name";

        $results = $conn->query($sql);

        return $results->fetchAll(PDO::FETCH_ASSOC);
    }
}
