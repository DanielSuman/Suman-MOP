<?php

namespace App\Model;

use Nette;

final class PostFacade
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
    }
    /*         $post = $this->database
                ->table('posts')
                ->get($postId);
            $post->update($data);
        } else {
            $post = $this->database
                ->table('posts')
                ->insert($data); */
    public function insertPost($data)
    {
        $post = $this->database
            ->table('posts')
            ->insert($data);

        return $post;
    }
    public function editPost($postId, $data)
    {
        $post = $this->database
            ->table('posts')
            ->get($postId);
        $post->update($data);
        return $post;
    }
    public function getPublicArticles(int $limit, int $offset): Nette\Database\ResultSet
    {
        return $this->database->query(
            '
        SELECT * FROM posts
        WHERE created_at < ?
        ORDER BY created_at DESC
        LIMIT ?
        OFFSET ?',
            new \DateTime,
            $limit,
            $offset,
        );
        /*    ->table('posts')
            ->where('created_at < ', new \DateTime)
            ->order('created_at DESC'); */
    }

    public function getPublicArticlesCount(): int
    {
        return $this->database->fetchField('SELECT COUNT(*) FROM posts WHERE created_at < ?', new \DateTime);
    }

    public function getPostById(int $id)
    {
        $post = $this->database
            ->table('posts')
            ->get($id);
        return $post;
    }
}
