<?php

namespace App\Model;

use Nette;

final class CommentFacade
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
    }

    public function insertComment($data)
    {
        $post = $this->database
            ->table('comments')
            ->insert($data);

        return $post;
    }
    public function editComment($commentId, $data)
    {
        $comment = $this->database
            ->table('comments')
            ->get($commentId);
        $comment->update($data);
        return $comment;
    }
    public function deleteComment($commentId)
    {
        $comment = $this->database
            ->table('comments')
            ->get($commentId);

        if ($comment) {
            $comment->delete();
            return true; // Return true to indicate successful deletion
        }

        return false; // Return false if the mod was not found
    }
    public function getPublishedComments(int $limit, int $offset): Nette\Database\ResultSet
    {
        return $this->database->query(
            '
        SELECT * FROM comments
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
    /*
    public function getPublicArticlesCount(): int
    {
        return $this->database->fetchField('SELECT COUNT(*) FROM posts WHERE created_at < ?', new \DateTime);
    } */

    public function getCommentById(int $id)
    {
        $comment = $this->database
            ->table('comments')
            ->get($id);
        return $comment;
    }

    public function getAll()
    {
        return $this->database->table('comments')->fetchAll();
    }
}
