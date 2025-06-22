<?php

namespace App\Actions\Post;

class FilterPosts
{
    public function execute($postQuery, ?string $filter)
    {

        return match ($filter) {
            'popular' => $postQuery->orderBy('views', 'desc'),
            'recent' => $postQuery->orderBy('created_at', 'desc'),
            'old' => $postQuery->orderBy('created_at', 'asc'),
            default => $postQuery->latest(),
        };
    }
}
