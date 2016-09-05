<?php

namespace InoBundle\Services;

use InoBundle\Entity\Author;

class AuthorModel extends AbstractModel
{
    const REPOSITORY = 'InoBundle:Author';

    /**
     * @return array
     */
    public function getAllAuthors()
    {
        return $this->getRepository()
            ->findAll()
        ;
    }

    /**
     * @param $id
     *
     * @return Author
     */
    public function getByIdOrEmpty($id)
    {
        $entity = $this->find($id);

        if (!$entity) {
            return new Author();
        }

        return $entity;
    }

}