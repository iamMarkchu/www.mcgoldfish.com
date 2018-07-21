<?php
/**
 * Created by PhpStorm.
 * User: chukui
 * Date: 7/22/2018
 * Time: 12:19 AM
 */

namespace App\Repositories;

use App\Models\Tag;

class TagRepository
{
    /**
     * @var Tag
     */
    private $tag;

    public function __construct(Tag $tag)
    {

        $this->tag = $tag;
    }

    public function getFillable()
    {
        return $this->tag->getFillable();
    }

    public function fetchList($map, $pageSize=30)
    {
        return $this->tag->where($map)->paginate($pageSize);
    }

    public function find($id)
    {
        return $this->tag->find($id);
    }

    public function create($data)
    {
        foreach ($data as $k => $v)
        {
            $this->tag->$k = $v;
        }
        $this->tag->save();
    }

    public function update($data, $id)
    {
        $tag = $this->tag->find($id);
        if (!$tag)
            return false;

        foreach ($data as $k => $v)
        {
            $tag->$k = $v;
        }
        $tag->save();
        return $tag;
    }
}