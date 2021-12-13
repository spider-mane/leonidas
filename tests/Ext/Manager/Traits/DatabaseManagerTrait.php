<?php

namespace Tests\Ext\Manager\Traits;

trait DatabaseManagerTrait
{
    public static function resetDatabase()
    {
        static::deleteAllData();
    }

    public static function prepareWpdb()
    {
        global $wpdb;

        $wpdb->suppress_errors = false;
        $wpdb->show_errors = true;
        $wpdb->db_connect();
    }

    /**
     * Drops all tables from the WordPress database
     */
    public static function dropAllTables()
    {
        global $wpdb;

        $tables = $wpdb->get_col('SHOW TABLES;');

        foreach ($tables as $table) {
            // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $wpdb->query("DROP TABLE IF EXISTS {$table}");
        }
    }

    /**
     * Deletes all data from the database.
     */
    public static function deleteAllData(): void
    {
        global $wpdb;

        $tables = [
            $wpdb->posts,
            $wpdb->postmeta,
            $wpdb->comments,
            $wpdb->commentmeta,
            $wpdb->term_relationships,
            $wpdb->termmeta,
        ];

        foreach ($tables as $table) {
            //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $wpdb->query("DELETE FROM {$table}");
        }

        $relTables = [
            $wpdb->terms,
            $wpdb->term_taxonomy,
        ];

        foreach ($relTables as $table) {
            //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $wpdb->query("DELETE FROM {$table} WHERE term_id != 1");
        }

        $wpdb->query("UPDATE {$wpdb->term_taxonomy} SET count = 0");

        $wpdb->query("DELETE FROM {$wpdb->users} WHERE ID != 1");
        $wpdb->query("DELETE FROM {$wpdb->usermeta} WHERE user_id != 1");
    }

    /**
     * Deletes all posts from the database.
     */
    public static function deleteAllPosts()
    {
        global $wpdb;

        $all_posts = $wpdb->get_results("SELECT ID, post_type from {$wpdb->posts}", ARRAY_A);
        if (!$all_posts) {
            return;
        }

        foreach ($all_posts as $data) {
            if ('attachment' === $data['post_type']) {
                wp_delete_attachment($data['ID'], true);
            } else {
                wp_delete_post($data['ID'], true);
            }
        }
    }

    /**
     * Deletes a user from the database in a Multisite-agnostic way.
     *
     * @since 4.3.0
     *
     * @param int $user_id User ID.
     * @return bool True if the user was deleted.
     */
    public static function deleteUser($user_id)
    {
        if (is_multisite()) {
            return wpmu_delete_user($user_id);
        }

        return wp_delete_user($user_id);
    }

    /**
     * Updates the modified and modified GMT date of a post in the database.
     *
     * @since 4.8.0
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @param int    $post_id Post ID.
     * @param string $date    Post date, in the format YYYY-MM-DD HH:MM:SS.
     * @return int|false 1 on success, or false on error.
     */
    public static function updatePostModified($post_id, $date)
    {
        global $wpdb;

        return $wpdb->update(
            $wpdb->posts,
            [
                'post_modified' => $date,
                'post_modified_gmt' => $date,
            ],
            [
                'ID' => $post_id,
            ],
            [
                '%s',
                '%s',
            ],
            [
                '%d',
            ]
        );
    }

    /**
     * Starts a database transaction.
     */
    public static function startTransaction()
    {
        global $wpdb;

        $wpdb->query('SET autocommit = 0;');
        $wpdb->query('START TRANSACTION;');
        add_filter('query', [static::class, 'createTemporaryTables']);
        add_filter('query', [static::class, 'dropTemporaryTables']);
    }

    /**
     * Commits the queries in a transaction.
     *
     * @since 4.1.0
     */
    public static function commitTransaction()
    {
        global $wpdb;

        $wpdb->query('COMMIT;');
    }

    public static function rollbackDatabase()
    {
        global $wpdb;

        $wpdb->query('ROLLBACK');
    }

    /**
     * Replaces the `CREATE TABLE` statement with a `CREATE TEMPORARY TABLE` statement.
     *
     * @param string $query The query to replace the statement for.
     * @return string The altered query.
     */
    public static function createTemporaryTables($query)
    {
        if (0 === strpos(trim($query), 'CREATE TABLE')) {
            return substr_replace(trim($query), 'CREATE TEMPORARY TABLE', 0, 12);
        }

        return $query;
    }

    /**
     * Replaces the `DROP TABLE` statement with a `DROP TEMPORARY TABLE` statement.
     *
     * @param string $query The query to replace the statement for.
     * @return string The altered query.
     */
    public static function dropTemporaryTables($query)
    {
        if (0 === strpos(trim($query), 'DROP TABLE')) {
            return substr_replace(trim($query), 'DROP TEMPORARY TABLE', 0, 10);
        }

        return $query;
    }
}
