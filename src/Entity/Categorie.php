<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use http\Exception\RuntimeException;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 * @ORM\Table(name="categorie")
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $publishedAt;

    /**
     * @var Post[]|Collection
     *
     * @ORM\OneToMany(
     *      targetEntity="Post",
     *      mappedBy="categorie",
     *      orphanRemoval=true,
     *      cascade={"persist"}
     * )
     */
    private $posts;

    public function __construct()
    {
        $this->publishedAt = new \DateTime();
        $this->tags = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        if (null === $title) {
            throw new RuntimeException('Title cannot be null');
        }

        $this->title = $title;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        if (null === $slug) {
            throw new RuntimeException('Slug cannot be null');
        }

        $this->slug = $slug;
    }

    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTime $publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }

    public function getPosts()
    {
        return $this->posts;
    }

    public function addPost(Post $post)
    {
        $post->setCategorie($this);

        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
        }
    }

    public function removePost(Post $post)
    {
        $this->posts->removeElement($post);
    }
}
