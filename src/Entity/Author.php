<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\OneToOne(targetEntity:"User")]
    #[ORM\JoinColumn(name:"user_id", referencedColumnName:"id")]
    private User $user;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: 'Post')]
    private Collection $posts;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $shortBio;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $phone;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $github;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Author
     */
    public function setUser(User $user): Author
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    /**
     * @param Collection $posts
     * @return Author
     */
    public function setPosts(Collection $posts): Author
    {
        $this->posts = $posts;
        return $this;
    }

    /**
     * @param Post $post
     * @return $this
     */
    public function addPost(Post $post): Author
    {
        $post->setAuthor($this);
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Author
     */
    public function setName(string $name): Author
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Author
     */
    public function setTitle(string $title): Author
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getShortBio(): ?string
    {
        return $this->shortBio;
    }

    /**
     * @param string|null $shortBio
     * @return Author
     */
    public function setShortBio(?string $shortBio): Author
    {
        $this->shortBio = $shortBio;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return Author
     */
    public function setPhone(?string $phone): Author
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGithub(): ?string
    {
        return $this->github;
    }

    /**
     * @param string|null $github
     * @return Author
     */
    public function setGithub(?string $github): Author
    {
        $this->github = $github;
        return $this;
    }
}
