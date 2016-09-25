<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Article.
 *
 * @ORM\Table(name="article")
 * @ORM\Entity()
 *
 * @Hateoas\Relation("self", href = "expr('/articles/' ~ object.getSlug())")
 *
 * @ExclusionPolicy("all")
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * Exclude
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Expose
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="leading_article", type="text", nullable=true)
     * @Expose
     */
    private $leading;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     * @Expose
     */
    private $body;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     * @Expose
     */
    private $createdAt;

    /**
     * @var string
     * @Gedmo\Slug(fields={"title"}, updatable=false)
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     * @Expose
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="createdBy", type="string", length=255)
     * @Expose
     */
    private $createdBy;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body.
     *
     * @param string $body
     *
     * @return Article
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Article
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Article
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set createdBy.
     *
     * @param string $createdBy
     *
     * @return Article
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy.
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set leading.
     *
     * @param string $leading
     *
     * @return Article
     */
    public function setLeading($leading)
    {
        $this->leading = $leading;

        return $this;
    }

    /**
     * Get leading.
     *
     * @return string
     */
    public function getLeading()
    {
        return $this->leading;
    }
}
